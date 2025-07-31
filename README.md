## English Version

- [Haz clic aquí para la versión en Español](docs/README.es.md)

# Microservices Architecture with Docker on AWS

> Microservices with Docker, PHP, and MySQL

This project demonstrates a simple microservices architecture deployed with Docker on AWS EC2. It includes a web front-end form that stores submitted data in a MySQL database and publishes an event to an AWS SNS topic.

## 📁 Project Structure

```
docker-microservices-on-aws
├── html/
│   ├── composer.json        # Composer definition file
│   ├── index.html           # Front-end form
│   └── submit.php           # Form handler: saves data + sends SNS
├── php/
│   └── Dockerfile           # Docker image for PHP
├── mysql\_data/             # Ignored: Docker volume for MySQL
├── create\_table.sql        # SQL script to initialize DB
├── docker-compose.yml       # Docker orchestration
│
```

> [!NOTE]
> The `mysql_data/` folder is used for persisting MySQL data via Docker volume. It is excluded from version control.

## 🧰 Requirements

- AWS account
- EC2 instance (Amazon Linux 2 or similar)
- Docker installed
- Docker Compose v1.29.2 or later
- IAM role with `AmazonSNSFullAccess`

## 🚀 Application Overview

The application flow is as follows:

1. A user submits a form in the front-end (`index.html`).
2. The `submit.php` file:
   - Saves the data in a MySQL table (`form_data`)
   - Sends a message to an AWS SNS topic
3. Data can be viewed via **phpMyAdmin** (port 8080)

## 🛠 Installation Guide

### 🔹 Step 1 – Install Docker

Update your EC2 instance:

```bash
sudo yum update -y                      # Updates the installed packages on your instance
sudo yum install -y docker              # Install Docker
sudo service docker start               # Starts the Docker service
sudo usermod -a -G docker $(whoami)     # Adds user to the Docker group
sudo yum install -y python3-pip         # Installs pip, the Python 3 package manager
````

### 🔹 Step 2 – Install Docker Compose

```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose     # Gives execution permissions to the binary file
docker-compose --version                        # To check if Docker Compose has been installed correctly
```

### 🔹 Step 3 – Create SNS Topic

Create a topic in AWS SNS and subscribe an email or another service.

> [!WARNING]
> Make sure to replace the ARN in `html/submit.php` with your topic's ARN.

### 🔹 Step 4 – Attach IAM Role

On your EC2 instance:

- Go to **Actions > Security > Modify IAM Role**
- Attach a role with the **AmazonSNSFullAccess** policy

### 🔹 Step 5 – Configure Security Group

Open these ports in your EC2 Security Group:

- HTTP (port 80)
- SSH (port 22)
- MySQL (port 3306)
- phpMyAdmin (port 8080)

### 🔹 Step 6 – Run the Infrastructure

From the root of your project:

```bash
docker-compose up
```

### 🔹 Step 7 – Use the App

- Open your instance's public IP in the browser
- Fill out the form
- Check SNS for the published message

### 🔹 Step 8 – View Data via phpMyAdmin

Visit:

```
http://YOUR_PUBLIC_IP:8080
```

Use:

- **Username**: `root`
- **Password**: `example_password`

The table is called `form_data`.

## 🧠 Extra Tips

- To initialize the DB manually, you can connect to MySQL and run `create_table.sql`
- You can extend SNS integration to trigger Lambda functions or notify other systems
