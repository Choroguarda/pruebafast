# Sistema de Tracking de Envíos — API (Laravel 12)

API REST para gestionar el ciclo de vida de envíos y notificar a sistemas externos cuando cambia el estado de un paquete.

# Tecnologías utilizadas

* Laravel 12
* PHP 8.2.12 
* SQLite
* Queue Jobs de Laravel
* Cache de Laravel

# Instalación del proyecto

1. Clonar el repositorio

2. Instalar dependencias

3. Crear archivo de entorno (copiar el .env.example)

4. Ejecutar migraciones - php artisan migrate

5. Implementar WEBHOOK_URL en el .env
    Esta URL es donde el sistema enviará notificaciones cuando cambie el estado de un paquete.

    Para pruebas se utilizo:

    https://webhook.site

    Pasos:

    * Ir a:
    https://webhook.site

    * Copiar tu URL única, por ejemplo:
    https://webhook.site/xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx

    * Colocarla en el `.env`

    WEBHOOK_URL=https://webhook.site/id-de-la-pagina

    Después, cada vez que un paquete cambie de estado, se enviará automáticamente un POST a esa URL.
    En webhook.site podrás ver el request recibido.

6. Ejecutar el job para poder ver las notificaciones asincronas  php artisan queue:work

7. Levantar el proyecto - php artisan serve

La API quedará disponible en: http://127.0.0.1:8000 por defecto

8. Ejecutar Tests

    Se implementaron tests para validar los siguientes funcionamientos.

    Ejemplos:

    * Creación de envíos
    * Cambio de estado
    * Validación de webhook

    Para ejecutar tests:

    -php artisan test

9. Para poder ejecutar la actualizacion de parte del conductor, es necesario generar la firma, para esto utilizar siguiente comando, cambiando los datos,
por los paquetes creados en la BD

   * php -r "echo 'sha256=' . hash_hmac('sha256', json_encode(['tracking_code'=>'EJE-111','status'=>'delivered','timestamp'=>'2024-03-10T15:30:00Z']), 'SecurePassword123');"
   * Esto dara un codigo similar a esto sha256=1cb14215a92d0241bb9dd7098e9dc17d22fbe650b0280c77d9f054ba2bade0ec
   * Luego en Postman colocar en la url  http://127.0.0.1:8000/api/webhooks/carrier el siguiente body 
   {"tracking_code": "EJE-1115",
    "status": "delivered",
    "timestamp": "2024-03-10T15:30:00Z",
    "signature": "sha256=1cb14215a92d0241bb9dd7098e9dc17d22fbe650b0280c77d9f054ba2bade0ec"}

# Endpoints

* Crear un paquete (POST)
http://127.0.0.1:8000/api/packets

* Actualizar el estado del paquete paquete (PUT)         
http://127.0.0.1:8000/api/packets/{id}/status

* Obtener lista de paquetes (GET)
http://127.0.0.1:8000/api/packets

* Obtener un paquete por estado (GET)
http://127.0.0.1:8000/api/packets?status={tipo_estado}

* Obtener un paquete especifico por id (GET)
http://127.0.0.1:8000/api/packets/{id}

* Actualizar estado del paquete a traves del conductor(POST)
http://127.0.0.1:8000/api/webhooks/carrier


# Autor

Prueba técnica desarrollada por: <Dario Alejandro Guarda Ovando>
