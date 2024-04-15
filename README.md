# MicroserviciosDocker

> Microservicios con docker, php y mysql

Este es un ejemplo de implementación de microservicios con docker en AWS. Será necesario **tener una cuenta en AWS**, pues se usará como base para todas las instrucciones previas.

### ¿En qué consiste la aplicación?

Se trata de un front-end con un formulario, del que se manda una petición a un fichero submit.php con peticiones a un tópico SNS de AWS y una base de datos de SQL. Por otro lado, tenemos un intérprete de esa base de datos, que es phpMyAdmin.

Siga los siguientes pasos para para poder desplegar toda la infraestructura:

**CONFIGURACIONES PREVIAS:**

1. En su instancia EC2:
   
   a. Asegúrese de permitir el tráfico HTTP y SSH y de tener abiertos los ***puertos 3036 y 8080***.
   
   b. Cree una nueva clave de par de claves o utilice una existente para acceder a su instancia mediante SSH. Si sabe cómo hacerlo, solo continúe desde aquí al paso 1.

2. En Cloud9:
   
   Al crear un par de claves en su instancia, se descargará su clave pública. Cópiela y, en Cloud9, péguela en un nuevo archivo que guarde con extensión .pem (en el ejemplo tendrá el nombre ´clave´) y concédale permisos de ejecución:

   ```
   chmod 600 clave.pem
   ```

   Acceda a su instancia mediante SSH, con su clave, su usuario y su IP:

   ```
   ssh -i [clave.pem] [su_usuario_Cloud9]@[IP_de_su_EC2]
   ```
   
   Por ejemplo:

   ```
   ssh -i clave.pem ec2-user@3.92.212.115
   ```
   
**PASO 1:** instale docker.

```
sudo yum update -y
sudo yum install -y docker
sudo usermod -a -G docker $(whoami)
```

**PASO 2:** instale la versión 3.9 de docker-compose.

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

Si quiere, puede comprobar que docker-compose se haya instalado correctamente:

```
docker-compose --version
```

**PASO 3:** cree un tópico SNS y suscríbase a él por el medio que desee.

> [!WARNING]
> Debe cambiar el ARN del fichero submit.php por el ARN de su tópico.

**PASO 4:** cree un rol en su EC2 (acciones > seguridad > modificar rol de IAM) y asocie a ese rol la política SNSFullAccess mediante el servicio IAM.

**PASO 5:** despliegue la infraestructura con el siguiente comando:

```
sudo docker-compose up
```

**PASO 6:** para probar la aplicación, acceda a la IP de su instancia, rellene el formulario y envíelo.

**PASO 7:** puede acceder al intérprete de esos datos con phpMyAdmin accediendo al puerto 8080 de su instancia (http://su_ip_publica:8080), que le mostrará el registro de la tabla del formulario. Puede acceder con el usuario 'root' y la contraseña 'example_password'. La tabla se llama 'form_data'.
