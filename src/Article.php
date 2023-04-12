<?php

namespace Drupal\dp_world_news;

/**
 * Defines the class for an article object.
 */
class Article implements ArticleInterface {
  /**
   * The content of the article.
   *
   * @var string|null
   */
  public $content;

  /**
   * The description of the article.
   *
   * @var string|null
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
   * @var string|null
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
   * @var string|null
   */
  public $title;

  /**
   * The direct URL to the article.
   *
   * @var string|null
   */
  public $url;

  /**
   * Article constructor.
   *
   * @param string|null $content
   *   The content of the article.
   * @param string|null $description
   *   The description of the article.
   * @param string|null $imageUrl
   *   The URL to a relevant image for the article.
   * @param string|null $publishedAt
   *   The published date of the article.
   * @param string|null $source
   *   The name of the source of this article came from.
   * @param string|null $title
   *   The title of the article.
   * @param string|null $url
   *   The direct URL to the article.
   */
  public function __construct(?string $content, ?string $description, ?string $imageUrl, ?string $publishedAt, ?string $source, ?string $title, ?string $url) {
    $this->content = $content;
    $this->description = $description;
    $this->imageUrl = $imageUrl;
    $this->publishedAt = $publishedAt;
    $this->source = $source;
    $this->title = $title;
    $this->url = $url;
  }

  /**
   * {@inheritdoc}
   */
  public function getContent(): ?string {
    return $this->content;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function getImageUrl(): ?string {
    return $this->imageUrl;
  }

  /**
   * {@inheritdoc}
   */
  public function getPublishedAt(): string {
    return $this->publishedAt;
  }

  /**
   * {@inheritdoc}
   */
  public function getSource(): ?string {
    return $this->source;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl(): string {
    return $this->url;
  }

}
