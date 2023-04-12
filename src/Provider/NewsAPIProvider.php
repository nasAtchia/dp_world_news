<?php

namespace Drupal\dp_world_news\Provider;

use Drupal\dp_world_news\Article;
use Drupal\dp_world_news\NewsProviderInterface;
use Drupal\dp_world_news\AbstractNewsProvider;
use GuzzleHttp\RequestOptions;

/**
 * Defines the class for the News API provider.
 */
class NewsAPIProvider extends AbstractNewsProvider implements NewsProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getArticles(array $parameters): array {
    $parameters['apiKey'] = $this->apiKey;

    $response = $this->httpClient->get($this->getApiBaseUrl() . '/top-headlines', [
      RequestOptions::QUERY => $parameters,
    ]);

    $responseBody = json_decode($response->getBody());

    if ($responseBody->articles) {
      $this->articles = $this->mapResponseToArrayOfArticles($responseBody->articles);
    }

    return $this->articles;
  }

  /**
   * {@inheritdoc}
   */
  protected function getApiBaseUrl(): string {
    return 'https://newsapi.org/v2';
  }

  /**
   * {@inheritdoc}
   */
  protected function mapResponseToArrayOfArticles(array $articles): array {
    return $this->articles = array_map(function ($article) {
      return new Article(
        $article->content ?? NULL,
        $article->description ?? NULL,
        $article->urlToImage ?? NULL,
        $article->publishedAt ?? NULL,
        $article->source ? $article->source->name : NULL,
        $article->title ?? NULL,
        $article->url ?? NULL,
      );
    }, $articles);
  }

}
