<?php
// Database connection variables
$servername = "localhost";  // Change this if using a remote database
$username = "root";         // Your database username (default: 'root')
$password = "";             // Your database password (default: empty)
$dbname = "kinatwa_sacco";  // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $seat = isset($_POST['seat']) ? (int)$_POST['seat'] : 0;
    $route = isset($_POST['route']) ? $_POST['route'] : '';
    $time_of_day = '';  // We will derive the time of day based on the route
    $booking_date = isset($_POST['date']) ? $_POST['date'] : '';

    // Determine time of day based on route selection
    if (strpos($route, 'morning') !== false) {
        $time_of_day = 'Morning';
    } elseif (strpos($route, 'evening') !== false) {
        $time_of_day = 'Evening';
    }

    // Prepare the SQL query to insert the data
    $sql = "INSERT INTO bookings (seat, route, time_of_day, booking_date)
            VALUES (?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("isss", $seat, $route, $time_of_day, $booking_date);

        // Execute the query
        if ($stmt->execute()) {
            echo "Booking successful! 🎉";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
