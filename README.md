# BackendApi Films2022

Es el septimo proyecto que realizo en [GeekHubs Academy](https://geekshubsacademy.com/), consiste en la realización de un Backend, utilizando MySql, Php, Laravel, Eloquent & Passport.

El deploy del backend se ha realizado en heroku: https://laravellfg.herokuapp.com/

### Organización

He realizado un trello para la organización de este proyecto:

![foto](/img/trello.PNG)

## Pre-requisitos 📋

Necesitaremos la instalación de un programa para realizar nuestro código, en este proyecto se ha utilizado [Visual studio code](https://code.visualstudio.com/Download/),

### Tecnologías utilizadas 🚀

El proyecto ha sido desarrollado utilizando las siguientes Tecnologías/Herramientas:

* Php
* Laravel
* Eloquent
* Passport
* Mysql
* Composer
* Mysql Workbench

## ¿Como desplegar el proyecto? 📋
Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo:

Clonarte el repositorio localmente:

> git clone url del repositorio
  
Instalar las depedencias necesarias:
  
> composer install
  
Rellenar las variables necesarias en estos archivos para iniciar el proyecto:
  
> env.example -> Rellenar campos DB_DATABASE, DB_USERNAME y DB_PASSWORD, una vez rellenado cambiar el nombre del archivo a .env
  
Creamos la base de datos siguiendo este breve tutorial utilizando Mysql Workbench:
  
https://codigosql.top/mysql/crear-base-de-datos/
  
Creamos las migraciones:
  
> php artisan migrate
  
Usamos los factories realizando los siguientes comandos en nuestro terminal (datos de prueba para nuestra base de datos):
  
> 1º php artisan tinker
> 2º User::factory()->count(10)->create()
> 3º Game::factory()->count(10)->create()

😊 Genial ya tenemos todo listo para poder llamar a los endpoints, ya podemos recibir y modificar datos 😊

## Modelo de la base de datos 🔧

El diagrama de nuestra base de datos:

![foto](/img/Diagrama.PNG)
  
## Endpoints 🛠️

El sistema puede realizar las siguientes acciones:

- CRUD Games
- CRUD Parties
- CRUD Users
- CRUD Messages
- Encriptación de ciertos campos mediante Bcryptjs
- Proceso de autenticación mediante uso de passport

Para ver mas detalladamente el funcionamiento de cada endpoints consultar el siguiente enlace:

https://documenter.getpostman.com/view/18402582/Uyr5myTq

## Autores ✒️

* **Cristian Santamaria** - *Realización del proyecto total*
