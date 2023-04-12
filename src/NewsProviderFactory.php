<?php

namespace Drupal\dp_world_news;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\dp_world_news\Exception\NewsProviderNotFoundException;
use Drupal\dp_world_news\Provider\NewsAPIProvider;
use GuzzleHttp\Client;

/**
 * Defines the class for the news provider object factory.
 */
class NewsProviderFactory implements NewsProviderFactoryInterface {

  use StringTranslationTrait;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The HTTP Client instance.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * NewsProviderFactory constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The factory for configuration objects.
   * @param \GuzzleHttp\Client $httpClient
   *   The HTTP Client instance.
   */
  public function __construct(ConfigFactoryInterface $configFactory, Client $httpClient) {
    $this->configFactory = $configFactory;
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public function provider($providerKey): NewsProviderInterface {
    if ($providerKey === 'news_api') {
      return new NewsAPIProvider($this->httpClient, 'd3f7801657d942c7a2748f68ebe54f3c');
    }
    else {
      throw new NewsProviderNotFoundException($this->t('The @provider provider cannot be found.', [
        '@provider' => $providerKey,
      ]));
    }
  }

}
