<?php
// Include database connection
include 'db_connect2.php';

// Retrieve filter criteria from AJAX request
$searchText = $_POST['searchText'] ?? '';
$placeFilter = $_POST['placeFilter'] ?? '';
$dateFilter = $_POST['dateFilter'] ?? '';

// Construct SQL query based on filter criteria
$sql = "SELECT *, LENGTH(selectedSeats) - LENGTH(REPLACE(selectedSeats, ',', '')) + 1 AS totalSeats FROM reservations WHERE 1";

// Apply search filter
if (!empty($searchText)) {
    $sql .= " AND fullName LIKE '%$searchText%'";
}

// Apply place filter
if (!empty($placeFilter)) {
    $sql .= " AND place = '$placeFilter'";
}

// Apply date filter
if (!empty($dateFilter)) {
    $sql .= " AND travelDate = '$dateFilter'";
}

// Execute the query
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Loop through each row and generate table rows
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr data-place="<?php echo $row['place']; ?>">
            <td>
                <!-- Checkbox to select reservation -->
                <input type="checkbox" name="selectedIds[]" class="select-checkbox" value="<?php echo $row['id']; ?>">
            </td>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['fullName']; ?></td>
            <td><?php echo $row['phoneNumber']; ?></td>
            <td><?php echo $row['place']; ?></td>
            <td><?php echo $row['travelDate']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['selectedSeats']; ?></td>
            <td><?php echo $row['totalSeats']; ?></td> <!-- Display total seats reserved -->
            <td>
                <!-- Checkbox to select reservation -->
                <input type="checkbox" name="selectedIds[]" class="select-checkbox" value="<?php echo $row['id']; ?>">
            </td>
            <td>
                <!-- Button to edit reservation -->
                <a href="edit_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">تعديل</a>
            </td>
           
        </tr>
        <?php
    }
} else {
    // If no rows found, display a message
    ?>
    <tr>
        <td colspan="12">No reservations found.</td>
    </tr>
    <?php
}

// Close database connection
$conn->close();


//made by alaa taha 
?>
