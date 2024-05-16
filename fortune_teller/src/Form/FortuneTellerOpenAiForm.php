<?php

namespace Drupal\fortune_teller\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form to configure settings for the Drupalai module.
 */
class FortuneTellerOpenAiForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['fortune_teller.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fortune_teller_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('fortune_teller.settings');
    $form['api_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('API Settings'),
    ];

    $form['api_settings']['openai_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OpenAI API Key'),
      '#default_value' => $config->get('openai_api_key') ?? '',
      '#description' => $this->t('Enter the API key for OpenAI.'),
    ];

    $form['api_settings']['chat_endpoint'] = [
        '#type' => 'textfield',
        '#title' => $this->t('OpenAI Endpoint'),
        '#default_value' => $config->get('chat_endpoint') ?? '',
        '#description' => $this->t('Enter the OpenAI endpoint for the request.'),
      ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('fortune_teller.settings')
    ->set('openai_api_key', $form_state->getValue('openai_api_key'))
    ->set('chat_endpoint', $form_state->getValue('chat_endpoint'))
    ->save();
    parent::submitForm($form, $form_state);
  }

}
