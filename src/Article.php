<?php

namespace Drupal\dp_world_news;

/**
 * Defines the class for an article object.
 */
class Article implements ArticleInterface {
  /**
   * The content of the article.
   *
   * @var string
   */
  public $content;

  /**
   * The description of the article.
   *
   * @var string
   */
  public $description;

  /**
   * The URL to a relevant image for the article.
   *
   * @var string|null
   */
  public $imageUrl;

  /**
   * The published date of the article.
   *
   * @var string
   */
  public $publishedAt;

  /**
   * The name of the source of this article came from.
   *
   * @var string|null
   */
  public $source;

  /**
   * The title of the article.
   *
   * @var string
   */
  public $title;

  /**
   * The direct URL to the article.
   *
   * @var string
   */
  public $url;

  /**
   * Article constructor.
   *
   * @param string $content
   *   The content of the article.
   * @param string $description
   *   The small description of the article.
   * @param string|null $imageUrl
   *   The URL to a relevant image for the article.
   * @param string $publishedAt
   *   The published date of the article.
   * @param string|null $source
   *   The name of the source of this article came from.
   * @param string $title
   *   The title of the article.
   * @param string $url
   *   The direct URL to the article.
   */
  public function __construct(string $content, string $description, ?string $imageUrl, string $publishedAt, ?string $source, string $title, string $url) {
    $this->content = $content;
    $this->description = $description;
    $this->imageUrl = $imageUrl;
    $this->publishedAt = $publishedAt;
    $this->source = $source;
    $this->title = $title;
    $this->url = $url;
  }

  /**
   * Gets the content of the article.
   *
   * @return string
   *   The content of the article.
   */
  public function getContent(): string {
    return $this->content;
  }

  /**
   * Gets the small description of the article.
   *
   * @return string
   *   The small description of the article.
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * Gets the URL to a relevant image for the article.
   *
   * @return string|null
   *   The URL to a relevant image for the article.
   */
  public function getImageUrl(): ?string {
    return $this->imageUrl;
  }

  /**
   * Gets the published date of the article.
   *
   * @return string
   *   The published date of the article.
   */
  public function getPublishedAt(): string {
    return $this->publishedAt;
  }

  /**
   * Gets the name of the source of this article came from.
   *
   * @return string|null
   *   The name of the source of this article came from.
   */
  public function getSource(): ?string {
    return $this->source;
  }

  /**
   * Gets the title of the article.
   *
   * @return string
   *   The title of the article.
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Gets the direct URL to the article.
   *
   * @return string
   *   The direct URL to the article.
   */
  public function getUrl(): string {
    return $this->url;
  }

}
