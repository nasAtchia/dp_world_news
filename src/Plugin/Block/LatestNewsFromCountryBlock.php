<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\dp_world_news\Article;

/**
 * Provides a 'Latest news from country' block.
 *
 * @Block(
 *   id = "dp_latest_news_from_country",
 *   admin_label = @Translation("Latest news from country"),
 *   category = @Translation("World News")
 * )
 */
class LatestNewsFromCountryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $build['articles'] = [
      '#markup' => [
        new Article(
          'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.',
          'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa',
          'https://dummyimage.com/600x400/000/fff',
          '2023-01-01T00:00:00Z',
          'Example.com',
          'Article 1',
          'https://example.com/',
        ),
        new Article(
          'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.',
          'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa',
          'https://dummyimage.com/600x400/000/fff',
          '2023-01-01T00:00:00Z',
          'Example.com',
          'Article 2',
          'https://example.com/',
        ),
      ],
    ];

    return $build;
  }

}
