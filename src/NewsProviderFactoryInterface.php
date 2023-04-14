<?php

namespace Drupal\dp_world_news;

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
   * @throws \InvalidArgumentException
   *   Thrown when a news provider cannot be found.
   */
  public function provider(string $providerKey): NewsProviderInterface;

}
