<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$database = "nowroz";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get reserved seats for the selected travel date and place
function getReservedSeats($chosenDate, $place, $conn) {
    $reservedSeats = array(); // Initialize an array to store reserved seat numbers

    // Fetch reserved seats for the chosen date and place from the database
    $query = "SELECT selectedSeats FROM reservations WHERE travelDate = ? AND place = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $chosenDate, $place);
    $stmt->execute();
    $result = $stmt->get_result();

    // Add reserved seat numbers to the array
    while ($row = $result->fetch_assoc()) {
        $reservedSeats[] = $row['selectedSeats'];
    }

    // Close statement
    $stmt->close();

    return $reservedSeats;
}

// Function to implode an array with commas
function implode_array_with_commas($array) {
    if (is_array($array)) {
        return implode(',', $array);
    } else {
        return ''; // or handle the error as needed
    }
}

$message = ''; // Initialize the message variable

// Only handle POST requests if this file is included in a file where $_POST data is expected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fullName']) && isset($_POST['phoneNumber']) && isset($_POST['place']) && isset($_POST['travelDate']) && isset($_POST['price'])) {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $place = $_POST['place'];
    $travelDate = $_POST['travelDate'];
    $price = $_POST['price'];
    // Retrieve 'selectedSeats' from the form data or set default value to an empty string
    $selectedSeats = isset($_POST['selectedSeats']) ? implode_array_with_commas($_POST['selectedSeats']) : '';

    // Check if the selected seats are available
    $reservedSeats = getReservedSeats($travelDate, $place, $conn);
    $selectedSeatsArray = explode(',', $selectedSeats);
    $available = true;
    foreach ($selectedSeatsArray as $seat) {
        if (in_array($seat, $reservedSeats)) {
            $available = false;
            break;
        }
    }

    if ($available) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO reservations (fullName, phoneNumber, place, travelDate, price, selectedSeats) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullName, $phoneNumber, $place, $travelDate, $price, $selectedSeats);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Success
            $message = "تم الحجز!";
        } else {
            // Error
            $message = "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Seats are not available
        $message = "احد المقاعد المحددة محجوز الرجاء اختيار مقعد اخر ";
    }
}

// Close connection
$conn->close();
?>