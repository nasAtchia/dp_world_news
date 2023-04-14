<?php

namespace Drupal\dp_world_news;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use GuzzleHttp\ClientInterface;

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
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * NewsProviderFactory constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The factory for configuration objects.
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP Client instance.
   */
  public function __construct(ConfigFactoryInterface $configFactory, ClientInterface $httpClient) {
    $this->configFactory = $configFactory;
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public function provider($providerKey): NewsProviderInterface {
    $providerKeys = array_keys(self::PROVIDERS);

    if (!in_array($providerKey, $providerKeys)) {
      throw new \InvalidArgumentException($this->getNewsProviderNotFoundErrorMessage($providerKey));
    }

    $providerClass = self::PROVIDERS[$providerKey] . 'Provider';
    $providerClassPath = '\Drupal\dp_world_news\Provider\\' . $providerClass;

    if (!class_exists($providerClassPath)) {
      throw new \InvalidArgumentException($this->getNewsProviderNotFoundErrorMessage($providerKey));
    }

    $providerApiKey = $this->getApiKeyForNewsProvider($providerKey);

    if (!$providerApiKey) {
      throw new \InvalidArgumentException($this->t('Missing API key for @provider.', [
        '@provider' => $providerKey,
      ]));
    }

    return new $providerClassPath($this->httpClient, $providerApiKey);
  }

  /**
   * Gets the error message when a news provider cannot be found.
   *
   * @param string $providerKey
   *   The news provider key.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The translated error message.
   */
  private function getNewsProviderNotFoundErrorMessage(string $providerKey): TranslatableMarkup {
    return $this->t('The @provider provider cannot be found.', [
      '@provider' => $providerKey,
    ]);
  }

  /**
   * Gets the API key for a news provider.
   *
   * @param string $providerKey
   *   The news provider key.
   *
   * @return string|null
   *   The API key.
   */
  private function getApiKeyForNewsProvider(string $providerKey): ?string {
    $configKey = $providerKey . '.api_key';
    return $this->configFactory->get('dp_world_news.settings')->get($configKey);
  }

}
