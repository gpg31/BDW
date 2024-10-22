<?php
session_start();
if (!isset($_SESSION['donor_id'])) {
    header("Location: donor_login.html");
    exit();
}

$donor_id = $_SESSION['donor_id'];

// Get form data
$name = htmlspecialchars(trim($_POST['name']));
$age = intval($_POST['age']);
$blood_type = htmlspecialchars(trim($_POST['blood_type']));
$location = htmlspecialchars(trim($_POST['location']));
$medical_status = htmlspecialchars(trim($_POST['medical_status']));

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update donor information
$sql = "UPDATE users SET name=?, age=?, blood_type=?, location=?, medical_status=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssi", $name, $age, $blood_type, $location, $medical_status, $donor_id);

if ($stmt->execute()) {
    header("Location: donor_dashboard.php?update=success");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
