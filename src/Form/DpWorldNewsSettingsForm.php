<?php

namespace Drupal\dp_world_news\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure world news module.
 */
class DpWorldNewsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      'dp_world_news.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'dp_world_news_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('dp_world_news.settings');

    $form['news_api'] = [
      '#markup' => $this->t('News API'),
    ];

    $form['news_api_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('news_api.api_key'),
      '#maxlength' => 255,
    ];

    $form['news_data'] = [
      '#markup' => $this->t('Newsdata'),
    ];

    $form['news_data_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('news_data.api_key'),
      '#maxlength' => 255,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('dp_world_news.settings')
      ->set('news_api.api_key', $form_state->getValue('news_api_api_key'))
      ->set('news_data.api_key', $form_state->getValue('news_data_api_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
