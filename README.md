# World News

The World News Drupal module enables users to fetch and display the latest world news from [News API](https://newsapi.org/) and [NEWSDATA.IO](https://newsdata.io/) providers.

The current version of the module is `1.0.1`.
For a list of changes made in the module, please refer to the [Changelog](CHANGELOG.md).

## Requirements

The module requires Drupal `9.5` or later.

## Installation

The module is still in development mode.

To try the module, download the source code and move it to either the `modules/contrib` or `modules/custom` directory in your Drupal project.

You can then enable it via Drush: `drush en dp_world_news` or the back office.

## Configuration

The API keys for the providers are configurable in the back office via the following URL: `{BASE_URL}/admin/config/content/world-news`.

## Usage

The module can be used in two ways to fetch the latest news from a provider:

1. Inject the service as a dependency. Refer to [TopHeadlinesBlock.php](src/Plugin/Block/TopHeadlinesBlock.php) for an example.
2. Call the service statically. For example:

```
$parameters = ['language' => 'en',];
$articles = \Drupal::service('dp_world_news.provider.factory')->provider('news_api')->getLatestNews($parameters);
```

See the API documentation for each provider for more information on request parameters.

## Top Headlines Block

You can use the Top Headlines block to showcase a preview of the most recent global news. For guidance on implementing this block, a demo is available on the following repository: https://github.com/nasAtchia/clean-blog-drupal.

## Todo

1. Pagination from API response.
