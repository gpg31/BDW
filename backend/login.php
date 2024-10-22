<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    
    // Prepare the SQL statement to fetch user with the given email
    $sql = "SELECT id, email, password FROM users WHERE email = ? AND role = 'donor'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows == 1) {
        // Fetch the user's data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Login successful, redirect to donor dashboard
            $_SESSION['user_id'] = $user['id']; // Save user ID in session for future use
            header("Location: ../public/donor_dashboard.html");
            exit();
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "No donor found with this email!";
    }
    $stmt->close();
}

$conn->close();
?>
