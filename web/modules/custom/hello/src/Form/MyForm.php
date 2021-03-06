<?php
namespace Drupal\hello\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class MyForm extends ConfigFormBase {

  public function getFormId() {
 
    return 'simple_config_form';
 
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
 
    $config = $this->config('simple.settings');
 
    $form['email'] = array(
 
      '#type' => 'textfield',
 
      '#title' => $this->t('Email'),
 
      '#default_value' => $config->get('simple.email'),
 
      '#required' => TRUE,
 
    );
    $form['name'] = array(
 
      '#type' => 'textfield',
 
      '#title' => $this->t('name'),
 
      '#default_value' => $config->get('simple.name'),
 
      '#required' => TRUE,
 
    );
 
    
    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
 
    $node_type_titles = array();
 
    foreach ($node_types as $machine_name => $val) {
 
      $node_type_titles[$machine_name] = $val->label();
 
    }
 
    $form['node_types'] = array(
 
      '#type' => 'checkboxes',
 
      '#title' => $this->t('Node Types'),
 
      '#options' => $node_type_titles,
 
      '#default_value' => $config->get('simple.node_types'),
 
    );
 
    return $form;
 
  }
 
  /**
 
   * {@inheritdoc}
 
   */
 
  public function submitForm(array &$form, FormStateInterface $form_state) {
 
    $config = $this->config('simple.settings');
 
    $config->set('simple.email', $form_state->getValue('email'));
 
    $config->set('simple.node_types', $form_state->getValue('node_types'));
 
    $config->save();
 
    return parent::submitForm($form, $form_state);
 
  }
  protected function getEditableConfigNames() {
 
    return [
 
      'simple.settings',
 
    ];
 
  }
 
}