# MS-BASE-LARAVEL ![PHP Version Support](https://img.shields.io/badge/php-%5E8.1-blue) ![docker build](https://img.shields.io/badge/docker%20build-passing-green)


## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

## Pre-requisitos 📋

Obligatorio si no se usa docker:

- php 8.1
- php-ext-gd
- php-ext-pdo_mysql
- php-ext-json
- composer 2

Para usar docker

- docker
- docker-compose
- make (opcional)
- xdebug (opcional)

## Instalación 🔧

### Paso 1: Configura las credenciales

Dentro de la carpeta **laravel** crea un archivo con el nombre **.env** que contenga el mismo contendido del archivo **.env.example**, luego personaliza el **.env**.

### Paso 2: Usando Docker y Docker Compose
Verifica que tengas instalado el servicio de **Docker** y **Docker Compose** en tu maquina local, de no ser asi por favor diríjase al siguiente enlace y sigue los pasos que allí se describen.

[Instalación de Docker](https://docs.docker.com/get-docker/)

[Instalación de Docker Compose (solo en el caso de linux)](https://docs.docker.com/compose/install/)

#### Archivo Make

_En la raíz del proyecto se encuentra un archivo make para facilitar el trabajo con docker el cual contiene los siguientes comandos:_

```sh
api_redeban$ make
usage: make [target]

targets:
    help          Muestra este mensaje de ayuda
    run           Arranca los contenedores
    stop          Detiene los contenedores
    restart       Reinicia los contenedores
    composer      Instala las dependencias por composer
    sh            Ingresa al contenedor por su terminal bash
    log           Muestra el log del contenedor
```

_Solo basta ejecutar desde nuestra terminal dentro de la carpeta del proyecto los siguientes comandos:_

Crea y arranca el contenedor de docker

```sh
make run
```

Instala todas las dependencias

```sh
make composer
```

#### Docker Compose

_Para correr el proyecto con docker-compose sin el archivo make hay que correr los siguientes comandos:_

Crea una red llamada management si aun no la tienes

```sh
docker network create management
```

Crea y arranca el contenedor de docker

Linux

```sh
U_ID=$(id -u) IP_DEBUG=172.17.0.1 docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env up -d --build
```

Mac

```sh
U_ID=$(id -u) IP_DEBUG=host.docker.internal docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env up -d --build
```

Windows

```sh
U_ID=1000 IP_DEBUG=host.docker.internal docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env up -d --build
```

Instala todas las dependencias

```sh
docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env exec php-apache composer install --prefer-dist
```

### Paso 3: Usando solo php
_Ingresa a la carpeta **rest_lumen** de nuestro proyecto y ejecuta los siguientes comandos:_

Instala todas las dependencias

```sh
composer install --prefer-dist
```

Levantar servidor de desarrollo

```sh
php -S localhost:8059 -t public/
```

### Paso 4: Comprobar Instalación

_Para comprobar que la instalación se realizo de manera correcta ingresa al proyecto a través del siguiente enlace [http://localhost:8072/ping](http://localhost:8059/ping) y veras un mensaje de notificación._

## Configuración XDebug ⚙️
### PhpStorm
Abrir la configuración y crear un servidor con los siguientes parámetros `File -> Settings -> PHP -> Servers`

![server](https://multimedia-epayco-test.s3.amazonaws.com/docs/phpstorm_conex.png)

Agregar una nueva configuración para debug en `Run -> Edit configurations -> PHP Remote Debug`

![remote debug](https://multimedia-epayco-test.s3.amazonaws.com/docs/phpstorm_debug.png)

Selecciona la nueva configuración en el panel debug

![panel](https://multimedia-epayco-test.s3.amazonaws.com/docs/phpstorm_panel.jpg)

### VSCode
Instala la extension [PHP Debug](https://github.com/felixfbecker/vscode-php-debug) y modifica el archivo PHP Debug ```launch.json```.

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Docker Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "pathMappings":{
                "/var/www/app":"${workspaceFolder}/rest_lumen"
            }
        }
    ]
}
```
## Uso

### Endpoints Principales

####  Login
**POST** `/api/login`

- **Body:**

```json
{
    "email": "admin@admin.com",
    "password": "admin"
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Token generated successfully",
    "data": "2|NknGu1fRCKQRxI3M1JTDsL23MLx1iWLfDeVSi4KZ5a21fa77"
}
```
- **Respuesta 400:**

```json
{
    "success": false,
    "message": "Invalid credentials",
    "data": []
}
```

####  Logout
**POST** `/api/logout`

- **Body:**

```Authorization Bearer Token
{
    "2|NknGu1fRCKQRxI3M1JTDsL23MLx1iWLfDeVSi4KZ5a21fa77"
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Logged out successfully",
    "data": []
}
```

#### Gets list of all users
**GET** `/api/users`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Users consulted successfully",
    "data": []
}
```
- **Respuesta 403:**

```json
{
    "success": false,
    "message": "unauthorized",
    "data": []
}
```

#### Get user
**GET** `/api/users/1`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "User consulted successfully",
    "data": []
}
```
- **Respuesta 403:**

```json
{
    "success": false,
    "message": "unauthorized",
    "data": []
}
```

#### Create user
**POST** `/api/users`

- **Body:**

```json
{
    "name": "test",
    "email": "test@gmail.com",
    "password": "12345678",
    "birth_date": "1998-05-07",
    "gender": "male",
    "dni": "2540225111",
    "country": "Venezuela",
    "phone": "4155112541",
    "address": "Yaracuy",
    "role": "admin"
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "User created successfully",
    "data": []
}
```
- **Respuesta 403:**

```json
{
    "success": false,
    "message": "unauthorized",
    "data": []
}
```

- **Respuesta 400:**

```json
{
    "success": false,
    "message": "Role not found",
    "data": []
}
```

#### Update user
**PUT** `/api/users/1`

- **Body:**

```json
{
    "name": "test test",
    "email": "test@test.com",
    "password": "12345678",
    "birth_date": "1998-05-07",
    "gender": "male",
    "dni": "25402251111",
    "country": "Venezuela",
    "phone": "4155112541",
    "address": "Yaracuy",
    "role": "admin"
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "User updated successfully",
    "data": []
}
```
- **Respuesta 403:**

```json
{
    "success": false,
    "message": "unauthorized",
    "data": []
}
```

- **Respuesta 400:**

```json
{
    "success": false,
    "message": "Role not found",
    "data": []
}
```

#### Delete user
**DELETE** `/api/users/1`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "User deleted successfully",
    "data": []
}
```
- **Respuesta 403:**

```json
{
    "success": false,
    "message": "unauthorized",
    "data": []
}
```

#### Gets list of all roles
**GET** `/api/roles`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Roles consulted successfully",
    "data": []
}
```

#### Get role
**GET** `/api/roles/1`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Role consulted successfully",
    "data": []
}
```

- **Respuesta 400:**

```json
{
    "success": false,
    "message": "Role not found",
    "data": []
}
```

#### Create role
**POST** `/api/roles`

- **Body:**

```json
{
    "name": "create",
    "permissions": ["create_user"]
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Role created successfully",
    "data": []
}
```

#### Update role
**PUT** `/api/roles/1`

- **Body:**

```json
{
    "permissions": ["view_user", "create_user"]
}
```

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Role updated successfully",
    "data": []
}
```

#### Delete role
**DELETE** `/api/roles/1`

- **Respuesta 200:**

```json
{
    "success": true,
    "message": "Role deleted successfully",
    "data": []
}
```
- **Respuesta 400:**

```json
{
    "success": false,
    "message": "The role cannot be deleted because it has associated users",
    "data": []
}
```



### Generador
php artisan new:service "servicio/metodo"

### Pruebas unitarias
Ejecutar con ./vendor/bin/pest