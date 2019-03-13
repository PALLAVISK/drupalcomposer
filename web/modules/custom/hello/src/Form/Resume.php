<?php
namespace Drupal\hello\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Resume extends FormBase {
  protected $loggerFactory;

  public function __construct(LoggerChannelFactory $loggerFactory) {
    $this->loggerFactory = $loggerFactory->get('resume_data');
  }
  public static function create(ContainerInterface $container){
    return new static ($container->get('logger.factory'));
  }
 
  public function getFormId() {
    return 'resume_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Name:'),
      '#required' => TRUE,
    );

    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      '#required' => TRUE,
    );
    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => t('Female'),
        'male' => t('Male'),
      ),
    );
    $form['candidate_confirmation'] = array (
      '#type' => 'radios',
      '#title' => ('Are you above 18 years old?'),
      '#options' => array(
        'Yes' =>t('Yes'),
        'No' =>t('No')
      ),
    );
    $form['candidate_copy'] = array(
      '#type' => 'checkbox',
      '#title' => t('Send me a copy of the application.'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('candidate_number')) < 10) {
      $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));
    //  foreach ($form_state->getValues() as $key => $value) {
    //    drupal_set_message($key . ': ' . $value);
    //  }
    $name=$form_state->getValue('candidate_name');
    $this->loggerFactory->notice('First  name :' . $form_state->getValue('candidate_name') . '  DOB :' . $form_state->getValue('candidate_dob'));
    $this->messenger()->addMessage($this->t('Hello '. $name));
  }
}


