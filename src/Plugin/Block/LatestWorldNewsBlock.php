<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\dp_world_news\Article;

/**
 * Provides a 'Latest world news' block.
 *
 * @Block(
 *   id = "dp_latest_world_news",
 *   admin_label = @Translation("Latest world news"),
 *   category = @Translation("World News")
 * )
 */
class LatestWorldNewsBlock extends BlockBase {

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
