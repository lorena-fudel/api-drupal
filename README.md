# API REST Segura - Registro Histórico y Perfiles

Este proyecto es una API Backend desarrollada en **Node.js** y **Express**, diseñada bajo una arquitectura modular y desplegada mediante **Docker**.

## 🚀 Características Principales
- **Seguridad**: Autenticación mediante JSON Web Tokens (JWT).
- **Arquitectura**: Patrón de Controladores para escalabilidad.
- **Persistencia**: Sistema de registro de logs con marcas de tiempo en archivos planos (.txt).
- **Entorno**: Contenerización completa con Docker y Hot-Reload mediante Nodemon.

## 📂 Estructura del Proyecto
- `/controllers`: Lógica de negocio (Autenticación y Archivos).
- `/middlewares`: Filtros de seguridad (Verificación de Token).
- `/routes`: Definición de endpoints segmentados por funcionalidad.
- `app.js`: Punto de entrada y configuración del servidor.

## 🛠️ Instrucciones de Despliegue
1. Asegúrese de tener instalado **Docker** y **Docker Compose**.
2. Ejecute el siguiente comando en la raíz del proyecto:
   ```bash
   docker-compose up --build

Lorena 2º DAW → Prácticas de empresa 4/2/2026