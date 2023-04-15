<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\dp_world_news\NewsProviderFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Top headlines' block.
 *
 * @Block(
 *   id = "dp_top_headlines",
 *   admin_label = @Translation("Top headlines"),
 *   category = @Translation("World News")
 * )
 */
class TopHeadlinesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The language manager instance.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The logger factory instance.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * The news provider factory instance.
   *
   * @var \Drupal\dp_world_news\NewsProviderFactoryInterface
   */
  protected $newsProviderFactory;

  /**
   * The URL generator instance.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * TopHeadlinesBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory instance.
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   *   The language manager instance.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory instance.
   * @param \Drupal\dp_world_news\NewsProviderFactoryInterface $newsProviderFactory
   *   The news provider factory instance.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $urlGenerator
   *   The URL generator instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, LanguageManagerInterface $languageManager, LoggerChannelFactoryInterface $loggerFactory, NewsProviderFactoryInterface $newsProviderFactory, UrlGeneratorInterface $urlGenerator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->configFactory = $configFactory;
    $this->languageManager = $languageManager;
    $this->loggerFactory = $loggerFactory->get('dp_world_news');
    $this->newsProviderFactory = $newsProviderFactory;
    $this->urlGenerator = $urlGenerator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('language_manager'),
      $container->get('logger.factory'),
      $container->get('dp_world_news.provider.factory'),
      $container->get('url_generator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'news_provider' => 'news_api',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['news_provider'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose a News Provider'),
      '#description' => $this->t('The news provider from which to fetch the news.'),
      '#options' => [
        'news_api' => 'News API',
        'news_data' => 'NewsData',
      ],
      '#default_value' => $this->configuration['news_provider'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $values = $form_state->getValues();
    $this->configuration['news_provider'] = $values['news_provider'];
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state): void {
    if ($providerKey = $form_state->getValue('news_provider')) {
      $configKey = $providerKey . '.api_key';
      $providerApiKey = $this->configFactory->get('dp_world_news.settings')->get($configKey);

      if (!$providerApiKey) {
        $form_state->setErrorByName('news_provider', $this->t('Missing API key for @provider. Add an API key on the <a href="@link">settings page</a>.', [
          '@provider' => $providerKey,
          '@link' => $this->urlGenerator->generateFromRoute('dp_world_news.settings'),
        ]));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $config = $this->getConfiguration();

    $build = [];

    $parameters = [
      'language' => $this->languageManager->getCurrentLanguage()->getId(),
    ];

    try {
      $articles = $this->newsProviderFactory->provider($config['news_provider'])->getLatestNews($parameters);

      $build['articles'] = [
        '#markup' => $articles,
      ];

      $build['#cache'] = [
        'max-age' => 3600,
      ];
    }
    catch (\Exception $e) {
      $this->loggerFactory->error($e->getMessage());
    }

    return $build;
  }

}
