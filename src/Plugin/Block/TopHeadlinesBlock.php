<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dp_world_news\NewsProviderFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
   * The request stack instance.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * TopHeadlinesBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory.
   * @param \Drupal\dp_world_news\NewsProviderFactoryInterface $newsProviderFactory
   *   The news provider factory instance.
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   The request stack instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelFactoryInterface $loggerFactory, NewsProviderFactoryInterface $newsProviderFactory, RequestStack $requestStack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->loggerFactory = $loggerFactory->get('dp_world_news');
    $this->newsProviderFactory = $newsProviderFactory;
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory'),
      $container->get('dp_world_news.provider.factory'),
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $parameters = [
      'language' => $this->requestStack->getCurrentRequest()->getLocale(),
    ];

    try {
      $articles = $this->newsProviderFactory->provider('news_api')->getArticles($parameters);

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
