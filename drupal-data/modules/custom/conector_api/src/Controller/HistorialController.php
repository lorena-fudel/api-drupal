<?php

namespace Drupal\conector_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\RequestException;

class HistorialController extends ControllerBase {

  public function mostrar() {
    // 1. Recuperar el token de la sesión (el mismo nombre que usas en LoginForm)
    $token = \Drupal::service('session')->get('mi_token_api');

    if (!$token) {
      return [
        '#markup' => $this->t('No tienes un token válido. Por favor, <a href="/api/entrar">inicia sesión</a>.'),
      ];
    }

    $client = \Drupal::httpClient();

    try {
      // 2. Llamada a la API
      $response = $client->get('http://api:3000/files/ver-historial', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept' => 'application/json',
        ],
      ]);

      // 3. EXTRAER EL CONTENIDO CORRECTAMENTE
      // Usamos (string) para convertir el stream de Guzzle en texto plano
      $contenido = (string) $response->getBody();

    return [
  '#type' => 'markup',
  '#markup' => '<h2>Contenido de hola.txt:</h2><pre>' . $contenido . '</pre>',
  '#cache' => [
    'max-age' => 0, // Esto obliga a Drupal a recargar de la API siempre
  ],
];

    } catch (RequestException $e) {
      // Si la API devuelve error (401, 403, 404), lo capturamos aquí
      return [
        '#markup' => $this->t('Error de la API: @message', ['@message' => $e->getMessage()]),
      ];
    } catch (\Exception $e) {
      // Cualquier otro error de PHP
      return [
        '#markup' => $this->t('Error inesperado: @message', ['@message' => $e->getMessage()]),
      ];
    }
  }
}