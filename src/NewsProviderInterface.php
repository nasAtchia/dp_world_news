<?php

namespace Drupal\dp_world_news;

/**
 * Defines the interface for a news provider object.
 */
interface NewsProviderInterface {

  /**
   * Fetches the latest news.
   *
   * @param array $parameters
   *   API parameter list.
   *
   * @return array
   *   List of articles.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   *   Thrown when there is a failure in making an API call to the provider.
   */
  public function getLatestNews(array $parameters): array;

}
