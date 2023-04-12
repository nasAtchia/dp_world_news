<?php

namespace Drupal\Tests\dp_world_news\Unit;

use Drupal\dp_world_news\Exception\NewsProviderNotFoundException;
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
    $this->httpClient = $this->createMock('GuzzleHttp\ClientInterface');
  }

  /**
   * Tests the provider method with a valid provider key.
   *
   * @dataProvider providerTestCases
   */
  public function testProviderWithValidProviderKey($providerKey, $expectedProviderClassName): void {
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
   */
  public function testProviderWithInvalidProviderKey(): void {
    $this->expectException(NewsProviderNotFoundException::class);
    $this->expectExceptionMessage('The invalid_provider provider cannot be found.');

    $factory = new NewsProviderFactory($this->configFactory, $this->httpClient);
    $factory->setStringTranslation($this->getStringTranslationStub());

    $factory->provider('invalid_provider');
  }

}
