<?php
include 'db_connect2.php';

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if reservation ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    // Retrieve reservation ID from the form
    $reservation_id = sanitize_input($_POST['reservation_id']);

    // Retrieve form data
    $fullName = sanitize_input($_POST['fullName']);
    $phoneNumber = sanitize_input($_POST['phoneNumber']);
    $place = sanitize_input($_POST['place']);
    $travelDate = sanitize_input($_POST['travelDate']);
    $price = sanitize_input($_POST['price']);
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
    // Reservation ID not provided or invalid request
    echo "Invalid request.";
}
?>
