<?php

namespace Drupal\dp_world_news;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\dp_world_news\Exception\NewsProviderNotFoundException;
use GuzzleHttp\Client;

/**
 * Defines the class for the news provider object factory.
 */
class NewsProviderFactory implements NewsProviderFactoryInterface {

  use StringTranslationTrait;

  /**
   * The available news providers.
   *
   * @var array
   */
  public const PROVIDERS = [
    'news_api' => 'NewsApi',
    'news_data' => 'NewsData',
  ];

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
    $providerKeys = array_keys(self::PROVIDERS);

    if (!in_array($providerKey, $providerKeys)) {
      throw new NewsProviderNotFoundException($this->getNewsProviderNotFoundErrorMessage($providerKey));
    }

    $providerClass = self::PROVIDERS[$providerKey] . 'Provider';
    $providerClassPath = '\Drupal\dp_world_news\Provider\\' . $providerClass;

    if (!class_exists($providerClassPath)) {
      throw new NewsProviderNotFoundException($this->getNewsProviderNotFoundErrorMessage($providerKey));
    }

    return new $providerClassPath($this->httpClient, 'd3f7801657d942c7a2748f68ebe54f3c');
  }

  /**
   * Gets the error message when a news provider cannot be found.
   *
   * @param string $providerKey
   *   The news provider key.
   *
   * @return string
   *   The error message.
   */
  private function getNewsProviderNotFoundErrorMessage(string $providerKey): string {
    return $this->t('The @provider provider cannot be found.', [
      '@provider' => $providerKey,
    ]);
  }

}
