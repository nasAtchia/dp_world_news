<?php

namespace Drupal\Tests\dp_world_news\Unit;

use Drupal\dp_world_news\NewsProviderFactory;
use Drupal\Tests\UnitTestCase;

/**
 * Tests the NewsProviderFactory class.
 *
 * @coversDefaultClass \Drupal\dp_world_news\NewsProviderFactory
 *
 * @group dp_world_news
 */
class NewsProviderFactoryTest extends UnitTestCase {

  /**
   * The config mock.
   *
   * @var \Drupal\Core\Config\Config|\PHPUnit\Framework\MockObject\MockObject
   */
  private $config;

  /**
   * The config factory mock.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface|\PHPUnit\Framework\MockObject\MockObject
   */
  private $configFactory;

  /**
   * The HTTP client mock.
   *
   * @var \GuzzleHttp\ClientInterface|\PHPUnit\Framework\MockObject\MockObject
   */
  private $httpClient;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->configFactory = $this->createMock('Drupal\Core\Config\ConfigFactoryInterface');
    $this->config = $this->createMock('Drupal\Core\Config\Config');
    $this->httpClient = $this->createMock('GuzzleHttp\ClientInterface');
  }

  /**
   * Tests the provider method with a valid provider key.
   *
   * @covers ::provider
   *
   * @dataProvider providerTestCases
   */
  public function testProviderWithValidProviderKey($providerKey, $expectedProviderClassName): void {
    $this->config->expects($this->once())
      ->method('get')
      ->with($providerKey . '.api_key')
      ->willReturn('api_key');

    $this->configFactory->expects($this->once())
      ->method('get')
      ->with('dp_world_news.settings')
      ->willReturn($this->config);

    $factory = new NewsProviderFactory($this->configFactory, $this->httpClient);

    $provider = $factory->provider($providerKey);

    $this->assertInstanceOf('\Drupal\dp_world_news\Provider\\' . $expectedProviderClassName . 'Provider', $provider);
  }

  /**
   * Provides test cases for the testProvider method.
   *
   * @return array[]
   *   A list of available news providers.
   */
  public function providerTestCases(): array {
    return [
      ['news_api', 'NewsApi'],
      ['news_data', 'NewsData'],
    ];
  }

  /**
   * Tests the provider method with an invalid provider key.
   *
   * @covers ::provider
   */
  public function testProviderWithInvalidProviderKey(): void {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('The invalid_provider provider cannot be found.');

    $factory = new NewsProviderFactory($this->configFactory, $this->httpClient);
    $factory->setStringTranslation($this->getStringTranslationStub());

    $factory->provider('invalid_provider');
  }

  /**
   * Tests the provider method with a missing API key.
   *
   * @covers ::provider
   */
  public function testProviderWithValidProviderKeyButMissingApiKey(): void {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Missing API key for news_api.');

    $this->config->expects($this->once())
      ->method('get')
      ->with('news_api.api_key')
      ->willReturn(NULL);

    $this->configFactory->expects($this->once())
      ->method('get')
      ->with('dp_world_news.settings')
      ->willReturn($this->config);

    $factory = new NewsProviderFactory($this->configFactory, $this->httpClient);
    $factory->setStringTranslation($this->getStringTranslationStub());

    $factory->provider('news_api');
  }

}
