<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
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
   * TopHeadlinesBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   *   The language manager instance.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory instance.
   * @param \Drupal\dp_world_news\NewsProviderFactoryInterface $newsProviderFactory
   *   The news provider factory instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LanguageManagerInterface $languageManager, LoggerChannelFactoryInterface $loggerFactory, NewsProviderFactoryInterface $newsProviderFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->languageManager = $languageManager;
    $this->loggerFactory = $loggerFactory->get('dp_world_news');
    $this->newsProviderFactory = $newsProviderFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('language_manager'),
      $container->get('logger.factory'),
      $container->get('dp_world_news.provider.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build = [];

    $parameters = [
      'language' => $this->languageManager->getCurrentLanguage()->getId(),
    ];

    try {
      $articles = $this->newsProviderFactory->provider('news_api')->getLatestNews($parameters);

      $build['articles'] = [
        '#markup' => $articles,
      ];
    }
    catch (\Exception $e) {
      $this->loggerFactory->error($e->getMessage());
    }

    return $build;
  }

}
