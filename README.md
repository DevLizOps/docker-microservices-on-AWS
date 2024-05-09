# Microservicios con Docker en AWS

> Microservicios con docker, php y mysql

Este es un ejemplo de implementación de microservicios con docker en AWS. Para desplegarlo, será necesario **tener una cuenta en AWS**.


### ¿En qué consiste la aplicación?

Se trata de un front-end con un formulario, del que se manda una petición a un fichero submit.php con peticiones a un tópico SNS de AWS y una base de datos de SQL. Por otro lado, tenemos un intérprete de esa base de datos, que es phpMyAdmin.

Siga los siguientes pasos para para poder desplegar toda la infraestructura:

### **PASO 1:**

Instale docker con los siguientes comandos:
  
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

### **PASO 2:**

Instale la versión 3.9 de docker-compose.

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

### **PASO 3:**

Cree un tópico SNS y suscríbase a él por el medio que desee.

> [!WARNING]
> Debe cambiar el arn del fichero submit.php por el arn de su tópico.

### **PASO 4:**

Cree un rol en su instancia (acciones > seguridad > modificar rol de IAM) y asocie a ese rol la política SNSFullAccess mediante el servicio IAM.

### **PASO 5:**

Configure los ajustes de seguridad de su instancia permitiendo el tráfico HTTP y SSH, además de los puertos 3036 y 8080.

### **PASO 6:**

Despliegue la infraestructura con el siguiente comando:

```
sudo docker-compose up
```

### **PASO 7:**

Para probar la aplicación, acceda a la IP de su instancia, rellene el formulario y envíelo.

### **PASO 8:**

Puede acceder al intérprete de esos datos con phpMyAdmin accediendo al puerto 8080 de su instancia (http://su_ip_publica:8080), que le mostrará el registro de la tabla del formulario. Puede acceder con el usuario 'root' y la contraseña 'example_password'. La tabla se llama 'form_data'.

# Microservices Architecture using Docker on AWS

> Microservices with Docker, PHP, and MySQL

This is an example of microservices implementation with Docker on AWS. To deploy it, you'll need to **have an AWS account**.

### What's this application about?

It's a front-end with a form, from which a request is sent to a submit.php file with requests to an AWS SNS topic and a SQL database. On the other hand, we have an interpreter of that database, which is phpMyAdmin.

Follow the steps below to deploy the entire infrastructure:

### **STEP 1:**

Install Docker with the following commands:

  - Update the installed packages on your instance.

```
sudo yum update -y
```

  - Install Docker.

```
sudo yum install -y docker
```

  - Start the Docker service.

```
sudo service docker start
```

  - Add your user to the Docker group.

```
sudo usermod -a -G docker $(whoami)
```

  - Install the Python 3 package manager.

```
sudo yum install -y python3-pip
````

### **STEP 2:**

Install version 3.9 of Docker Compose.

  - Download the binary to install Docker Compose.

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

Give execution permissions to the binary file.

````
sudo chmod +x /usr/local/bin/docker-compose
````

Optionally, you can check if Docker Compose has been installed correctly:

```
docker-compose --version
```

### **STEP 3:**

Create an SNS topic and subscribe to it through the desired medium.

> [!WARNING]
> You must change the ARN of the submit.php file to the ARN of your topic.

### **STEP 4:**

Create a role on your instance (actions > security > modify IAM role) and associate that role with the SNSFullAccess policy through the IAM service.

### **STEP 5:**

Configure the security settings of your instance allowing HTTP and SSH traffic, as well as ports 3036 and 8080.

### **STEP 6:**

Deploy the infrastructure with the following command:

```
sudo docker-compose up
```

### **STEP 7:**

To test the application, access the IP of your instance, fill out the form, and submit it.

### **STEP 8:**

You can access the interpreter of that data with phpMyAdmin by accessing port 8080 of your instance (http://your_public_ip:8080), which will show you the record of the form_data table. You can access with the username 'root' and the password 'example_password'. The table is called 'form_data'.
