<?php

namespace Drupal\dp_world_news;

/**
 * Defines the interface for an article object.
 */
interface ArticleInterface {

  /**
   * Gets the content of the article.
   *
   * @return string
   *   The content of the article.
   */
  public function getContent(): string;

  /**
   * Gets the description of the article.
   *
   * @return string
   *   The description of the article.
   */
  public function getDescription(): string;

  /**
   * Gets the URL to a relevant image for the article.
   *
   * @return string|null
   *   The URL to a relevant image for the article.
   */
  public function getImageUrl(): ?string;

  /**
   * Gets the published date of the article.
   *
   * @return string
   *   The published date of the article.
   */
  public function getPublishedAt(): string;

  /**
   * Gets the name of the source of this article came from.
   *
   * @return string|null
   *   The name of the source of this article came from.
   */
  public function getSource(): ?string;

  /**
   * Gets the title of the article.
   *
   * @return string
   *   The title of the article.
   */
  public function getTitle(): string;

  /**
   * Gets the direct URL to the article.
   *
   * @return string
   *   The direct URL to the article.
   */
  public function getUrl(): string;

}
