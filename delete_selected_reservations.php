<?php
include 'db_connect2.php';

// Check if reservation IDs are provided in the POST request
if(isset($_POST['ids'])) {
    $reservation_ids = $_POST['ids'];

    // Prepare SQL statement to delete selected reservations
    $sql = "DELETE FROM reservations WHERE id IN (".implode(',', array_map('intval', $reservation_ids)).")";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Reservations deleted successfully
        echo "Selected reservations deleted successfully.";
    } else {
        // Failed to delete reservations
        echo "Error deleting selected reservations: " . $conn->error;
    }
} else {
    // No reservation IDs provided in the POST request
    echo "No reservation IDs provided.";
}

// Close database connection
$conn->close();
?>
