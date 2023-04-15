<?php

namespace Drupal\Tests\dp_world_news\Unit\Provider;

use Drupal\dp_world_news\Article;
use Drupal\dp_world_news\Provider\NewsDataProvider;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Psr7\Response;

/**
 * Tests the NewsDataProvider class.
 *
 * @coversDefaultClass \Drupal\dp_world_news\Provider\NewsDataProvider
 *
 * @group dp_world_news
 */
class NewsDataProviderTest extends UnitTestCase {

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

    $this->httpClient = $this->createMock('GuzzleHttp\ClientInterface');
  }

  /**
   * Test the getArticles() method.
   *
   * @covers ::getLatestNews
   */
  public function testGetArticles() {
    $response = new Response(200, [], json_encode([
      'results' => [
        [
          'title' => 'Test article 1',
          'description' => 'Test article 1 description.',
          'content' => 'Test article 1 content.',
          'link' => 'https://example.com/test-article-1',
          'image_url' => 'https://example.com/test-article-1-image.jpg',
          'pubDate' => '2023-01-01T12:00:00Z',
          'source_id' => 'Example News',
        ],
        [
          'title' => 'Test article 2',
          'description' => 'Test article 2 description.',
          'content' => NULL,
          'link' => 'https://example.com/test-article-2',
          'image_url' => NULL,
          'pubDate' => '2023-01-01T12:00:00Z',
          'source_id' => 'Example News',
        ],
      ],
    ]));

    $parameters = [
      'apikey' => 'api_key',
    ];

    $this->httpClient->expects($this->once())
      ->method('request')
      ->with('GET', 'https://newsdata.io/api/1/news',
        [
          'query' => $parameters,
        ]
      )
      ->willReturn($response);

    $provider = new NewsDataProvider($this->httpClient, 'api_key');
    $articles = $provider->getLatestNews($parameters);

    $this->assertIsArray($articles);
    $this->assertCount(2, $articles);

    $this->assertInstanceOf(Article::class, $articles[0]);
    $this->assertEquals('Test article 1', $articles[0]->getTitle());
    $this->assertEquals('Test article 1 description.', $articles[0]->getDescription());
    $this->assertEquals('Test article 1 content.', $articles[0]->getContent());
    $this->assertEquals('https://example.com/test-article-1', $articles[0]->getUrl());
    $this->assertEquals('https://example.com/test-article-1-image.jpg', $articles[0]->getImageUrl());
    $this->assertEquals('Example News', $articles[0]->getSource());
    $this->assertEquals('2023-01-01T12:00:00Z', $articles[0]->getPublishedAt());

    $this->assertInstanceOf(Article::class, $articles[1]);
    $this->assertEquals('Test article 2', $articles[1]->getTitle());
    $this->assertEquals('Test article 2 description.', $articles[1]->getDescription());
    $this->assertEquals(NULL, $articles[1]->getContent());
    $this->assertEquals('https://example.com/test-article-2', $articles[1]->getUrl());
    $this->assertEquals(NULL, $articles[1]->getImageUrl());
    $this->assertEquals('Example News', $articles[1]->getSource());
    $this->assertEquals('2023-01-01T12:00:00Z', $articles[1]->getPublishedAt());
  }

}
