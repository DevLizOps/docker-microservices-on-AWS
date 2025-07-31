## Versión en Español

- [Click here for the English version](../README.md)

# Arquitectura de Microservicios con Docker en AWS

> Microservicios con Docker, PHP y MySQL

Este proyecto muestra una arquitectura simple de microservicios desplegada con Docker en una instancia EC2 de AWS. Incluye un formulario web que guarda datos en una base de datos MySQL y publica un mensaje a un tópico de AWS SNS.

## 📁 Estructura del Proyecto

````
docker-microservices-on-aws
├── html/
│   ├── composer.json        # Archivo de definición de dependencias
│   ├── index.html           # Formulario del front-end
│   └── submit.php           # Controlador del formulario
├── php/
│   └── Dockerfile           # Imagen Docker para PHP
├── mysql\_data/             # Ignorada: volumen para MySQL
├── create\_table.sql        # Script para inicializar la base de datos
├── docker-compose.yml       # Orquestación de contenedores
│
````

> [!NOTE]
> `mysql_data/` es usada como volumen persistente para la base de datos. Es ignorada en la subida al repositorio.

## 🧰 Requisitos

- Cuenta de AWS
- Instancia EC2 (Amazon Linux 2 o compatible)
- Docker instalado
- Docker Compose v1.29.2 o superior
- Rol IAM con política `AmazonSNSFullAccess`

## 🚀 Descripción General

1. El usuario envía un formulario desde `index.html`
2. El archivo `submit.php`:
   - Guarda los datos en la tabla `form_data` (MySQL)
   - Publica un mensaje en un tópico SNS de AWS
3. Los datos pueden consultarse con **phpMyAdmin** (puerto 8080)

## 🛠 Guía de Instalación

### 🔹 Paso 1 – Instalar Docker

```bash
sudo yum update -y                      # Actualiza los paquetes instalados en tu instancia
sudo yum install -y docker              # Instala Docker
sudo service docker start               # Arranca el servicio Docker
sudo usermod -a -G docker $(whoami)     # Añade al usuario al grupo Docker
sudo yum install -y python3-pip         # Instala el administrador de paquetes pip de Python 3
````

### 🔹 Paso 2 – Instalar Docker Compose

```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose     # Da permisos de ejecución al binario descargado
docker-compose --version                        # Para comprobar la correcta instalación de Docker Compose
```

### 🔹 Paso 3 – Crear un Tópico SNS

Crea un tópico SNS en la consola de AWS y suscríbete (ej. vía email).

> [!WARNING]
> Recuerda reemplazar el ARN en `html/submit.php` por el ARN real del tópico.

### 🔹 Paso 4 – Asignar Rol IAM

En tu instancia EC2:

- Ve a **Acciones > Seguridad > Modificar rol de IAM**
- Asigna un rol con la política **AmazonSNSFullAccess**

### 🔹 Paso 5 – Configurar el Grupo de Seguridad

Asegúrate de permitir estos puertos:

- HTTP (80)
- SSH (22)
- MySQL (3306)
- phpMyAdmin (8080)

### 🔹 Paso 6 – Levantar la Infraestructura

Desde la raíz del proyecto:

```bash
docker-compose up
```

### 🔹 Paso 7 – Probar la Aplicación

- Abre la IP pública de tu instancia en el navegador
- Rellena el formulario y envíalo
- Verifica que el mensaje llegue a SNS

### 🔹 Paso 8 – Consultar Datos en phpMyAdmin

Accede a:

```
http://TU_IP_PUBLICA:8080
```

Credenciales:

- **Usuario**: `root`
- **Contraseña**: `example_password`

Tabla: `form_data`

## 🧠 Consejos Extra

- Puedes ejecutar `create_table.sql` directamente en MySQL si lo necesitas
- Considera agregar notificaciones por correo, Slack o integraciones con Lambda

