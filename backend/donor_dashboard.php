
<?php

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['donor_id'])) {
    // Redirect to login if not logged in
    header("Location: ../public/donor_login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch donor data based on session donor_id
$donor_id = $_SESSION['donor_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();

if (!$donor) {
    // If no user data is found, redirect to login
    header("Location: ../public/donor_login.html");
    exit();
}

// Fetch donation statistics (Total Donations and Last Donation Date)
$sql_donations = "SELECT SUM(quantity) AS total_donations, MAX(donation_date) AS last_donation_date FROM donations WHERE user_id = ?";
$stmt_donations = $conn->prepare($sql_donations);
$stmt_donations->bind_param("i", $donor_id);
$stmt_donations->execute();
$result_donations = $stmt_donations->get_result();
$donation_stats = $result_donations->fetch_assoc();

$total_donations = $donation_stats['total_donations'] ?? 0; // Default to 0 if no donations
$last_donation_date = $donation_stats['last_donation_date'] ?? 'No donations yet'; // Handle null case


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Welcome <?php echo htmlspecialchars($donor['name']); ?>!</h1>
    </header>

    <section class="dashboard">
        <div class="profile-box">
            <h2>Your Profile</h2>

            <!-- Display Donation Statistics -->
            <div class="donation-stats">
                <p><strong>Total Donations:</strong> <?php echo $donation_stats['total_donations']; ?></p>
                <p><strong>Last Donation Date:</strong> <?php echo $donation_stats['last_donation_date']; ?></p>
            </div>

            <!-- Form to Update User Profile -->
            <form action="../backend/update_profile.php" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>" required>

                <label for="blood_type">Blood Type:</label>
                <select id="blood_type" name="blood_type" required>
                    <option value="A+" <?php if ($donor['blood_type'] == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if ($donor['blood_type'] == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if ($donor['blood_type'] == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if ($donor['blood_type'] == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if ($donor['blood_type'] == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if ($donor['blood_type'] == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if ($donor['blood_type'] == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if ($donor['blood_type'] == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($donor['location']); ?>" required>

                <label for="medical_status">Medical Surveillance:</label>
                <textarea id="medical_status" name="medical_status"><?php echo htmlspecialchars($donor['medical_status']); ?></textarea>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Blood Donation. All rights reserved.</p>
    </footer>
</body>
</html>
