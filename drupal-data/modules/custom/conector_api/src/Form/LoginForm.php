<?php
namespace Drupal\conector_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Exception\RequestException;

class LoginForm extends FormBase {
  public function getFormId() {
    return 'conector_api_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['usuario'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Usuario de la API'),
      '#required' => TRUE,
    ];
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Contraseña'),
      '#required' => TRUE,
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Entrar al Sistema'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $client = \Drupal::httpClient();
    
    try {
      // 1. Obtener el Token
      $responseAuth = $client->get('http://api:3000/auth/login');
      $data = json_decode($responseAuth->getBody());
      $token = $data->token;
      
      // Guardar token en sesión
      \Drupal::service('session')->set('jwt_token', $token);

      // 2. ¡PASO CLAVE!: Llamar a la ruta que ESCRIBE en hola.txt
      // Usamos el token que acabamos de recibir
      $client->get('http://api:3000/files/hola', [
        'headers' => ['Authorization' => 'Bearer ' . $token]
      ]);

      \Drupal::messenger()->addStatus('Login correcto y archivo actualizado.');
      
      // 3. Redirigir al historial donde ya se verá el cambio
      $form_state->setRedirect('conector_api.historial');

    } catch (\Exception $e) {
      \Drupal::messenger()->addError('Error de comunicación con la API.');
    }
  }
}