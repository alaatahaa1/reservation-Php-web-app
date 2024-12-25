<?php
include 'db_connect2.php';

// Check if reservation ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
    // Retrieve reservation ID from the URL
    $reservation_id = $_GET['id'];

    // Retrieve form data
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $place = $_POST['place'];
    $travelDate = $_POST['travelDate'];
    $price = $_POST['price'];
    $selectedSeats = isset($_POST['selectedSeats']) ? $_POST['selectedSeats'] : '';

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

    // If selected seats are available, proceed with the update
    if ($available) {
        // Prepare SQL statement
        $stmt = $conn->prepare("UPDATE reservations SET fullName=?, phoneNumber=?, place=?, travelDate=?, price=?, selectedSeats=? WHERE id=?");
        $stmt->bind_param("ssssssi", $fullName, $phoneNumber, $place, $travelDate, $price, $selectedSeats, $reservation_id);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Success
            echo "Reservation updated successfully!";
        } else {
            // Error
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Seats are not available
        echo "One or more selected seats are already reserved. Please choose different seats.";
    }
} else {
    // Reservation ID not provided
    echo "Reservation ID not provided.";
}
?>
