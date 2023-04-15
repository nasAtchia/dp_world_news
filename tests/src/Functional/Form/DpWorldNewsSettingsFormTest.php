<?php

namespace Drupal\Tests\dp_world_news\Functional\Form;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the DpWorldNewsSettingsForm class.
 *
 * @group dp_world_news
 */
class DpWorldNewsSettingsFormTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'dp_world_news',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * A simple user.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->user = $this->drupalCreateUser([
      'administer site configuration',
    ]);
  }

  /**
   * Tests the form.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   * @throws \Behat\Mink\Exception\ResponseTextException
   */
  public function testSettingsForm(): void {
    // Login.
    $this->drupalLogin($this->user);

    // Access the config page.
    $this->drupalGet('/admin/config/content/world-news');
    $this->assertSession()->statusCodeEquals(200);

    // Test the form elements exist and have defaults.
    $this->assertSession()->fieldValueEquals(
      'news_api_api_key',
      '',
    );
    $this->assertSession()->fieldValueEquals(
      'news_data_api_key',
      '',
    );

    // Test form submission.
    $this->submitForm(
      [
        'news_api_api_key' => 'api_key',
        'news_data_api_key' => 'api_key',
      ],
      t('Save configuration')
    );
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('The configuration options have been saved.');

    // Test the new values are there.
    $this->drupalGet('/admin/config/content/world-news');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldValueEquals(
      'news_api_api_key',
      'api_key',
    );
    $this->assertSession()->fieldValueEquals(
      'news_data_api_key',
      'api_key',
    );
  }

}
