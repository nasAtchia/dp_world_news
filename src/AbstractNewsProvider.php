<?php

namespace Drupal\dp_world_news;

use GuzzleHttp\Client;

/**
 * Defines the abstract class for a news provider object.
 */
abstract class AbstractNewsProvider {
  /**
   * The news provider API key.
   *
   * @var string
   */
  protected $apiKey;

  /**
   * The list of articles.
   *
   * @var array
   */
  protected $articles = [];

  /**
   * The HTTP Client instance.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * AbstractNewsProvider constructor.
   *
   * @param \GuzzleHttp\Client $httpClient
   *   The HTTP Client instance.
   * @param string $apiKey
   *   The news provider API key.
   */
  public function __construct(Client $httpClient, string $apiKey) {
    $this->httpClient = $httpClient;
    $this->apiKey = $apiKey;
  }

  /**
   * Get the API base URL for the provider.
   *
   * @return string
   *   The API base URL for the provider.
   */
  abstract protected function getApiBaseUrl(): string;

  /**
   * Converts the API response to an array of Article objects.
   *
   * @param array $articles
   *   The list of articles from the API response.
   *
   * @return array
   *   The list of articles.
   */
  abstract protected function mapResponseToArrayOfArticles(array $articles): array;

}
