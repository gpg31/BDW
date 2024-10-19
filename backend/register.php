<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "blood_donation";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from POST request
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $blood_type = htmlspecialchars(trim($_POST['blood_type']));
    $location = htmlspecialchars(trim($_POST['location']));

    // Validate that all fields are filled
    if (!empty($name) && !empty($email) && !empty($password) && !empty($blood_type) && !empty($location)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL statement to insert user data
        $sql = "INSERT INTO users (name, email, password, role, location, blood_type) VALUES (?, ?, ?, 'donor', ?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $location, $blood_type);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: success.html");
            exit();
        } else {
            echo "<h2>Error: " . $stmt->error . "</h2>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<h2>Error: All fields are required!</h2>";
    }
}

// Close the database connection
$conn->close();
<<<<<<< HEAD
?>
=======
?>
>>>>>>> f82e4fa1ec9c0cfe5721c62a5b54cc0503021c59
