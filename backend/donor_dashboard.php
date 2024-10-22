<?php
session_start(); // Start the session

// Check if the donor is logged in
if (!isset($_SESSION['donor_id'])) {
    // If not logged in, redirect to login page
    header("Location: donor_login.html");
    exit();
}

// Database connection (replace credentials as needed)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch donor information based on session user ID
$donor_id = $_SESSION['donor_id']; 
$sql = "SELECT name, age, blood_type, location, medical_status FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$stmt->bind_result($name, $age, $blood_type, $location, $medical_status);
$stmt->fetch();
$stmt->close();

// Fetch donation statistics
$sql_donations = "SELECT COUNT(*) as total_donations, MAX(donation_date) as last_donation_date FROM donations WHERE donor_id=?";
$stmt = $conn->prepare($sql_donations);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$stmt->bind_result($total_donations, $last_donation_date);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($name); ?></h1>
    </header>

    <section class="dashboard">
        <div class="profile-box">
            <h2>Your Profile</h2>

            <div class="donation-stats">
                <p><strong>Total Donations:</strong> <?php echo $total_donations; ?></p>
                <p><strong>Last Donation Date:</strong> <?php echo $last_donation_date ? $last_donation_date : 'No donations yet'; ?></p>
            </div>

            <form action="update_profile.php" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required>

                <label for="blood_type">Blood Type:</label>
                <select id="blood_type" name="blood_type" required>
                    <option value="A+" <?php if($blood_type == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if($blood_type == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if($blood_type == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if($blood_type == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if($blood_type == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if($blood_type == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if($blood_type == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if($blood_type == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required>

                <label for="medical_status">Medical Surveillance:</label>
                <textarea id="medical_status" name="medical_status"><?php echo htmlspecialchars($medical_status); ?></textarea>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Blood Donation. All rights reserved.</p>
    </footer>
</body>
</html>
