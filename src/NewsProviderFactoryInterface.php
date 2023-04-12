<?php

namespace Drupal\dp_world_news;

use Drupal\dp_world_news\Exception\NewsProviderNotFoundException;

/**
 * Defines the interface for a news provider factory object.
 */
interface NewsProviderFactoryInterface {

  /**
   * Gets the news provider instance.
   *
   * @param string $providerKey
   *   The news provider key.
   *
   * @return NewsProviderInterface
   *   The news provider instance.
   *
   * @throws NewsProviderNotFoundException
   *   Thrown when a news provider cannot be found.
   */
  public function provider(string $providerKey): NewsProviderInterface;

}
