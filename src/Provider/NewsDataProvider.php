<?php

namespace Drupal\dp_world_news\Provider;

use Drupal\dp_world_news\Article;
use Drupal\dp_world_news\NewsProviderInterface;
use Drupal\dp_world_news\AbstractNewsProvider;
use GuzzleHttp\RequestOptions;

/**
 * Defines the class for the News DATA provider.
 */
class NewsDataProvider extends AbstractNewsProvider implements NewsProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getLatestNews(array $parameters): array {
    $parameters['apikey'] = $this->apiKey;

    $response = $this->httpClient->request('GET', $this->getApiBaseUrl() . '/news', [
      RequestOptions::QUERY => $parameters,
    ]);

    $responseBody = json_decode($response->getBody());

    if ($responseBody->results) {
      $this->articles = $this->mapResponseToArrayOfArticles($responseBody->results);
    }

    return $this->articles;
  }

  /**
   * {@inheritdoc}
   */
  protected function getApiBaseUrl(): string {
    return 'https://newsdata.io/api/1';
  }

  /**
   * {@inheritdoc}
   */
  protected function mapResponseToArrayOfArticles(array $articles): array {
    return $this->articles = array_map(function ($article) {
      return new Article(
        $article->content ?? NULL,
        $article->description ?? NULL,
        $article->image_url ?? NULL,
        $article->pubDate ?? NULL,
        $article->source_id ?? NULL,
        $article->title,
        $article->link,
      );
    }, $articles);
  }

}
