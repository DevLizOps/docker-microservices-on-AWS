<?php
require 'vendor/autoload.php';
 
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
 
    // Replace 'your-sns-topic-arn' with the ARN of your SNS topic
    $snsTopicArn = 'arn:aws:sns:us-east-1:XXXXX:test';
 
    // Initialize SNS client
    $snsClient = new SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1' // Replace with your desired AWS region
    ]);
 
    // Create message to send to SNS topic
    $messageToSend = json_encode([
        'email' => $email,
        'name' => $name,
        'message' => $message
    ]);
 
    try {
        // Publish message to SNS topic
        $snsClient->publish([
            'TopicArn' => $snsTopicArn,
            'Message' => $messageToSend
        ]);
 
        // Insertar datos del formulario en la base de datos MySQL
        $mysqli = new mysqli("mysql", "my_user", "my_password", "my_database");
 
        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
 
        // Prepare and bind
        $stmt = $mysqli->prepare("INSERT INTO form_data (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
 
        // Execute query
        $stmt->execute();
 
        echo "Message sent successfully."; 
    } catch (AwsException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?> 
