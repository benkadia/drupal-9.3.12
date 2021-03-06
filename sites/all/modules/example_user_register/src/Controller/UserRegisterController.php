<?php 
namespace Drupal\example_user_register\Controller;
use Drupal\Core\Controller\ControllerBase;

class UserRegisterController extends ControllerBase
{
	public function example()
	{
		$form = \Drupal::formBuilder()->getForm('Drupal\example_user_register\Form\ExampleForm');
		$renderForm = \Drupal::service('renderer')->render($form);
		return [
			#'#theme' => 'example',
			
			#'#items' => $form,
			'type' => 'markup',
			'#markup' => $renderForm,
			'#title' => 'Custom WebForm Module',
		];
	}
}