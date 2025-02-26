<?php
// Database connection details
$host = "localhost";  // Server name (default is localhost
$username ="root";   // Default username in XAMPP
$password = "";       // Default password is empty in XAMPP
$database = "colon"; // Change this to your database name

// Connect to MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//recive data from form
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST["email"];
    $password=$_POST["password"];

    //CHECK EMAIL EXIST IN DATABASE
    $sql="SELECT * FROM users WHERE email=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result=$stmt->get_result();

    //IF EMAIL FOUND
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
        echo "Login successful! Redirecting to home page...";
        echo "<script>setTimeout(() => { window.location.href = 'welcome.html'; }, 2000);</script>";
    } else {
        echo "Error: Invalid email or password";
    }
} else {
    echo "<script>alert('Email not found. Please sign up first.'); window.history.back();</script>";
}

// Close statement and connection
$stmt->close();
$conn->close();




}
?>