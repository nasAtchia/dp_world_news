<?php

namespace Drupal\dp_world_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
        [
          'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.',
          'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa',
          'image_url' => 'https://dummyimage.com/600x400/000/fff',
          'published_at' => '2023-01-01T00:00:00Z',
          'source' => 'Example.com',
          'title' => 'Article 1',
          'url' => 'https://example.com/',
        ],
        [
          'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.',
          'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa',
          'image_url' => 'https://dummyimage.com/600x400/000/fff',
          'published_at' => '2023-01-01T00:00:00Z',
          'source' => 'Example.com',
          'title' => 'Article 2',
          'url' => 'https://example.com/',
        ],
      ],
    ];

    return $build;
  }

}
