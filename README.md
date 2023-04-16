# World News

This Drupal module fetches and displays the latest world news.

Current version: **1.0.0**

See [Changelog](CHANGELOG.md) for list of changes made in the module.

News can be fetched from the following provider:

1. [News API](https://newsapi.org/)
2. [NEWSDATA.IO](https://newsdata.io/)

## Requirements

Drupal 9.5 and later.

## Installation

This module is still in development mode. If you want to try it, download the source code
and move it under either the `modules/contrib` or the `modules/custom` directory in your Drupal project.

You can then enable the module via Drush: `drush en dp_world_news` or via the back office.

## Configuration

The API keys for the providers are configurable in the back office via the following URL: `{BASE_URL}/admin/config/content/world-news`

## Usage

There are two ways you can use the module to fetch the latest news from a provider:

### 1. Inject the service as a dependency

See the [TopHeadlinesBlock.php](src/Plugin/Block/TopHeadlinesBlock.php) for a complete example.

### 2. Call the service statically

For example:

```
$parameters = [
  'language' => 'en',
];

$articles = \Drupal::service('dp_world_news.provider.factory')->provider('news_api')->getLatestNews($parameters);
```

See the API documentation for each provider for more information on request parameters.

## Top Headlines Block

You can utilize the Top Headlines block to showcase a preview of the most recent global news.
