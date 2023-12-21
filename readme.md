# Instrucciones para ejecutar el proyecto

## Requisitos previos

Asegúrate de tener PHP instalado en tu sistema. (version PHP 8.3.0)

### macOS

1. Puedes instalar PHP en macOS utilizando Homebrew con el siguiente comando:
    ```bash
    brew install php
    ```

### Windows

1. Descarga e instala PHP desde el sitio web oficial: [PHP para Windows](https://windows.php.net/download/).

2. Después de la instalación, asegúrate de habilitar la extensión `sqlite3` en el archivo `php.ini`.
   Este proyecto utiliza una base de datos SQLite

## Pasos para ejecutar el proyecto

1. Abre una terminal y navega al directorio del proyecto.

2. Ejecuta el siguiente comando para crear y poblar la base de datos:

    ```bash
    php php/poblar_db.php
    ```

3. Ejecuta el siguiente comando para iniciar el servidor PHP local:

    ```bash
    php -S localhost:8000
    ```

4. Accede al proyecto en tu navegador ingresando la siguiente URL:
    ```
    http://localhost:8000
    ```

¡Listo! Ahora deberías tener el proyecto en funcionamiento.
