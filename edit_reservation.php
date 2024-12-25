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
if(isset($_GET['id'])) {
    $reservation_id = sanitize_input($_GET['id']);
    
    // Fetch reservation details from the database based on the ID
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if reservation exists
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Display the reservation details in a form for editing
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Reservation</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Reservation</h2>
                <form action="update_reservation.php" method="post">
                    <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo sanitize_input($row['fullName']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" value="<?php echo sanitize_input($row['phoneNumber']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="place">Place:</label>
                        <input type="text" class="form-control" id="place" name="place" value="<?php echo sanitize_input($row['place']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="travelDate">Travel Date:</label>
                        <input type="date" class="form-control" id="travelDate" name="travelDate" value="<?php echo sanitize_input($row['travelDate']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo sanitize_input($row['price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="selectedSeats">Selected Seats:</label>
                        <input type="text" class="form-control" id="selectedSeats" name="selectedSeats" value="<?php echo sanitize_input($row['selectedSeats']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // No reservation found with the provided ID
        echo "No reservation found with ID: " . $reservation_id;
    }
} else {
    // No reservation ID provided in the URL
    echo "Reservation ID not provided.";
}
?>
