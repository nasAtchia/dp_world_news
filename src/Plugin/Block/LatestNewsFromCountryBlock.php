<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dp_world_news\NewsProviderFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Latest news from country' block.
 *
 * @Block(
 *   id = "dp_latest_news_from_country",
 *   admin_label = @Translation("Latest news from country"),
 *   category = @Translation("World News")
 * )
 */
class LatestNewsFromCountryBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The news provider factory instance.
   *
   * @var \Drupal\dp_world_news\NewsProviderFactoryInterface
   */
  protected $newsProviderFactory;

  /**
   * LatestNewsFromCountryBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\dp_world_news\NewsProviderFactoryInterface $newsProviderFactory
   *   The news provider factory instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, NewsProviderFactoryInterface $newsProviderFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

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
      $container->get('dp_world_news.provider.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $parameters = [
      'country' => 'us',
    ];
    $articles = $this->newsProviderFactory->getProvider('news_api')->getArticles($parameters);
    $build = [];

    $build['articles'] = [
      '#markup' => $articles,
    ];

    return $build;
  }

}
