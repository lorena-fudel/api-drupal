<?php
namespace Drupal\conector_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\RequestException;

class HistorialController extends ControllerBase {

  public function mostrar() {
    // 1. Recuperamos el token de la sesión
    $token = \Drupal::service('session')->get('jwt_token');

    if (!$token) {
      return [
        '#markup' => '<div class="messages messages--error">Error: No hay una sesión activa. Por favor, <a href="/api/entrar">logueate de nuevo</a>.</div>',
      ];
    }

    $client = \Drupal::httpClient();

    try {
      // 2. Llamamos a la API para leer el historial
      $response = $client->get('http://api:3000/files/ver-historial', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept' => 'text/plain',
        ],
      ]);

      $contenido = (string) $response->getBody();

      // 3. Devolvemos el contenido envuelto en etiquetas para que no se pierda el formato
      return [
                '#markup' => '
                  <div class="api-output">
                    <h2>📟 Terminal de Logs del Sistema</h2>
                    <pre>' . $contenido . '</pre>
                    <a href="/api/entrar" class="button">Ejecutar nueva entrada</a>
                  </div>',
                '#attached' => [
                  'library' => [
                    'conector_api/estilos-log', // Nombre del módulo / nombre de la librería
                  ],
                ],
                '#cache' => ['max-age' => 0],
              ];

    } catch (\Exception $e) {
      return [
        '#markup' => '<div class="messages messages--error">Error al conectar con la API: ' . $e->getMessage() . '</div>',
      ];
    }
  }
}