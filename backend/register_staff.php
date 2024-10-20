<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $hospital_id = htmlspecialchars(trim($_POST['hospital_id']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($name) && !empty($hospital_id) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO hospitalstaffs (name, hospital_id, email, password) VALUES (?, ?, ?, 'hospital_staff', ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $hospital_id);

        if ($stmt->execute()) {
            header("Location: success.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: All fields are required!";
    }
}

$conn->close();
?>

