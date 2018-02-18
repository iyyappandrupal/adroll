<?php
namespace Drupal\adroll\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class adrollSettingsForm extends ConfigFormBase {

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adroll_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'adroll.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('adroll.settings'); 
    $user_roles = user_role_names();
    // foreach ($user_roles as $key => $value) {
    //   $roles[] = $value;
    // }
    //kint($roles);
    //kint($config->get('adroll_target_roles'));die;
    $form['adroll_adv_id'] = array(
      '#type' => 'textfield',
      '#title' => t('ADV ID'),
      '#default_value' => $config->get('adroll_adv_id'),
      '#size' => 30,
      '#maxlength' => 30,
      '#required' => TRUE,
    );
    $form['adroll_pix_id'] = array(
      '#type' => 'textfield',
      '#title' => t('PIX ID'),
      '#default_value' => $config->get('adroll_pix_id'),
      '#size' => 30,
      '#maxlength' => 30,
      '#required' => TRUE,
    );
    $form['adroll_email'] = array(
      '#type' => 'textfield',
      '#title' => t('Adroll Email'),
      '#default_value' => $config->get('adroll_email'),
      '#size' => 30,
      '#maxlength' => 30,
    );    
    $form['roles'] = array(
      '#type' => 'fieldset',
      '#title' => t('User role tracking'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#description' => t('Define what user roles should be tracked by AdRoll. Leave empty to track for all roles'),
    );
    $form['roles']['adroll_target_roles'] = array(
      '#type' => 'checkboxes',
      '#options' => $user_roles,
      '#default_value' => $config->get('adroll_target_roles'),
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    //kint($form_state->getValue('adroll_target_roles'));die;
    $this->configFactory->getEditable('adroll.settings')
    // Set the submitted configuration setting
    ->set('adroll_adv_id', $form_state->getValue('adroll_adv_id'))
    // You can set multiple configurations at once by making
    // multiple calls to set()
    ->set('adroll_pix_id', $form_state->getValue('adroll_pix_id'))
    ->set('adroll_email', $form_state->getValue('adroll_email'))
    ->set('adroll_target_roles', $form_state->getValue('adroll_target_roles'))
    ->save();

    parent::submitForm($form, $form_state);
  }
}