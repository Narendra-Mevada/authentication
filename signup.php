

<?php
// Database connection details
$host = "localhost";  // Server name (default is localhost)
$username = "root";   // Default username in XAMPP
$password = "";       // Default password is empty in XAMPP
$database = "colon"; // Change this to your database name

// Connect to MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Encrypt the password (for security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Execute query
    if ($stmt->execute()) {
        echo "Registration successful! Redirecting to login page...";
        echo "<script>setTimeout(() => { window.location.href = 'login.html'; }, 2000);</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
