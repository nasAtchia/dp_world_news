<?php

namespace Drupal\dp_world_news;

/**
 * Defines the interface for a news provider object.
 */
interface NewsProviderInterface {

  /**
   * Fetches the list of articles.
   *
   * @param array $parameters
   *   API parameter list.
   *
   * @return array
   *   List of articles.
   */
  public function getArticles(array $parameters): array;

}
