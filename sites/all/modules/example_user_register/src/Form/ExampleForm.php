<?php

namespace Drupal\example_user_register\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

/**
 * Implements an example form.
 */
class ExampleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'example_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	$form['name'] = [
		'#type' => 'textfield',
		'#title' => $this->t('Họ tên'),
		'#required' => true,
	];
	$form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Số điện thoại'),
	  '#required' => true,
	  '#height' => 507.7,
	  
    ];
	$form['email'] = [
		'#type' => 'email',
		'#title' => $this->t('Email'),
		
	];
	$form['year_old'] = [
  '#type' => 'select',
  '#title' => $this
    ->t('Độ tuổi'),
  '#options' => [
	'Select' => $this->t('Chọn'),
    '10-20' => [
		'10' => $this->t('10'),
		'11' => $this->t('11'),
		'12' => $this->t('12'),
		'13' => $this->t('13'),
		'14' => $this->t('14'),
		'15' => $this->t('15'),
		'16' => $this->t('16'),
		'17' => $this->t('17'),
		'18' => $this->t('18'),
		'19' => $this->t('19'),
		'20' => $this->t('20'),
	],
    '21-30' => [
		'21' => $this->t('21'),
		'22' => $this->t('22'),
		'23' => $this->t('23'),
		'24' => $this->t('24'),
		'25' => $this->t('25'),
		'26' => $this->t('26'),
		'27' => $this->t('27'),
		'28' => $this->t('28'),
		'29' => $this->t('29'),
		'30' => $this->t('30'),
	],
    '31-50' => [
		'31' => $this->t('31'),
		'32' => $this->t('32'),
		'33' => $this->t('33'),
		'34' => $this->t('34'),
		'35' => $this->t('35'),
		'36' => $this->t('36'),
		'37' => $this->t('37'),
		'38' => $this->t('38'),
		'39' => $this->t('39'),
		'40' => $this->t('40'),
		'41' => $this->t('41'),
		'42' => $this->t('42'),
		'43' => $this->t('43'),
		'44' => $this->t('44'),
		'45' => $this->t('45'),
		'46' => $this->t('46'),
		'47' => $this->t('47'),
		'48' => $this->t('48'),
		'49' => $this->t('49'),
		'50' => $this->t('50'),
	],
  ],
];
	$form['description'] = array(
  '#type' => 'textarea',
  '#title' => $this
    ->t('Mô tả bản thân'),
);
    $form['save'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
	  
	$email = $form_state->getValue('email');
	$pattern_email = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@kyanon+(\.digital)$/';
	$phone = $form_state->getValue('phone_number');
	$pattern_phone = '/^[03|05|07|08|09]+[0-9]{8}$/';
	$year_old = $form_state->getValue('year_old');
	if($email == '')
	{
		$form_state->setErrorByName('email',$this->t('Email không được để trống'));
	}
	if(!preg_match($pattern_email, $email)) {
      $form_state->setErrorByName('email', $this->t('Email không đúng định dạng'));
    }
	if($year_old == 'Select')
	{
		$form_state->setErrorByName('year_old', $this->t('Tuổi không được để trống'));
	}
	if($year_old < 18)
	{
		$form_state->setErrorByName('year_old', $this->t('Bạn chưa đủ tuổi!!!'));
	}
	if(!preg_match($pattern_phone, $phone)) {
      $form_state->setErrorByName('phone_number', $this->t('Số điện thoại không đúng định dạng'));
    }
}
  public static	 function validatePattern(array &$form, FormStateInterface $form_state, &$complete_form) {
 
}
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	$post = $form_state->getValues();
	$query = \Drupal::database();
	$txn = $query->startTransaction();
	try
	{
		unset($post['save'],$post['form_build_id'],$post['form_token'],$post['form_id'],$post['op']);
		$a = $query->condition('name',$form_state->getValue('name'),'<>');
		$result = $query->insert('register')
		->fields($post)
		->execute();
		$this->messenger()->addStatus($this->t('Đăng ký user thành công'));
	}
	catch(Exception $e)
	{
		// Something went wrong somewhere, so roll back now.
		$txn->rollBack();
		// Log the exception to watchdog.
		\Drupal::logger('type')->error($e->getMessage());
	}
  
  }

}