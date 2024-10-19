<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update with your database username
$password = "";     // Update with your database password
$dbname = "blood_donation"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user registration details
$sql = "SELECT name, blood_type, location, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="search.html">Search Blood Inventory</a></li>
                <li><a href="donor_dashboard.html">Donor Dashboard</a></li>
                <li><a href="recipient_dashboard.html">Recipient Dashboard</a></li>
                <li><a href="login.html" class="btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-section container">
        <h2>Manage Donors</h2>
        <table>
            <tr>
                <th>Donor Name</th>
                <th>Blood Type</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>

            <!-- PHP code to display the data from the database -->
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["blood_type"] . "</td>
                            <td>" . $row["location"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td><button>Edit</button> <button>Delete</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No donors found</td></tr>";
            }
            ?>
        </table>

        <h2>Manage Blood Inventory</h2>
        <table>
            <tr>
                <th>Blood Type</th>
                <th>Quantity Available</th>
                <th>Last Updated</th>
                <th>Action</th>
            </tr>
            <!-- Placeholder inventory data; you can similarly fetch from the database -->
            <tr>
                <td>O+</td>
                <td>20 Units</td>
                <td>2024-10-15</td>
                <td><button>Update</button></td>
            </tr>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 Blood Donation. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
<<<<<<< HEAD
?>
=======
?>

>>>>>>> f82e4fa1ec9c0cfe5721c62a5b54cc0503021c59
