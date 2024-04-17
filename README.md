# MicroserviciosDocker

> Microservicios con docker, php y mysql

Este es un ejemplo de implementación de microservicios con docker en AWS. Para desplegarlo, será necesario **tener una cuenta en AWS**.

### ¿En qué consiste la aplicación?

Se trata de un front-end con un formulario, del que se manda una petición a un fichero submit.php con peticiones a un tópico SNS de AWS y una base de datos de SQL. Por otro lado, tenemos un intérprete de esa base de datos, que es phpMyAdmin.

Siga los siguientes pasos para para poder desplegar toda la infraestructura:


**PASO 1:** instale docker con los siguientes comandos:
  
  - Actualice los paquetes instalados en su instancia.

```
sudo yum update -y
```

  - Instale docker.

```
sudo yum install -y docker
```

  - Arranque el servicio docker
     
```
sudo service docker start
```

  - Añada su usuario al grupo docker
  
```
sudo usermod -a -G docker $(whoami)
```

  - Instale el administrador de paquetes de pyhton3

```
sudo yum install -y python3-pip
```

**PASO 2:** instale la versión 3.9 de docker-compose.

  - Descargue el binario para instalar docker-compose.

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

  - Dé permisos de ejecución al archivo binario.

```
sudo chmod +x /usr/local/bin/docker-compose
```

  - Si quiere, puede comprobar que docker-compose se haya instalado correctamente:

```
docker-compose --version
```

**PASO 3:** cree un tópico SNS y suscríbase a él por el medio que desee.

> [!WARNING]
> Debe cambiar el ARN del fichero submit.php por el ARN de su tópico.

**PASO 4:** cree un rol en su instancia (acciones > seguridad > modificar rol de IAM) y asocie a ese rol la política SNSFullAccess mediante el servicio IAM.

**PASO 5:** configure los ajustes de seguridad de su instancia permitiendo el tráfico HTTP y SSH, además de los puertos 3036 y 8080.

**PASO 5:** despliegue la infraestructura con el siguiente comando:

```
sudo docker-compose up
```

**PASO 6:** para probar la aplicación, acceda a la IP de su instancia, rellene el formulario y envíelo.

**PASO 7:** puede acceder al intérprete de esos datos con phpMyAdmin accediendo al puerto 8080 de su instancia (http://su_ip_publica:8080), que le mostrará el registro de la tabla del formulario. Puede acceder con el usuario 'root' y la contraseña 'example_password'. La tabla se llama 'form_data'.
