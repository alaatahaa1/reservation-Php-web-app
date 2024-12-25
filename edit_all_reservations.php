<?php
include 'db_connect2.php';

// Fetch all reservations from the database
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $reservations = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reservations = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit All Reservations</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
  <h1 class="text-center">Edit All Reservations</h1>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Phone Number</th>
          <th>Place</th>
          <th>Travel Date</th>
          <th>Price</th>
          <th>Selected Seats</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $reservation): ?>
        <tr>
          <td><?php echo $reservation['id']; ?></td>
          <td><?php echo $reservation['fullName']; ?></td>
          <td><?php echo $reservation['phoneNumber']; ?></td>
          <td><?php echo $reservation['place']; ?></td>
          <td><?php echo $reservation['travelDate']; ?></td>
          <td><?php echo $reservation['price']; ?></td>
          <td><?php echo $reservation['selectedSeats']; ?></td>
          <td>
            <a href="edit_reservation.php?id=<?php echo $reservation['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="text-center">
      <a href="#" class="btn btn-warning" onclick="editAll()">Edit All</a>
    </div>
  </div>
</div>

<script>
function editAll() {
    // Redirect to the edit all page
    window.location.href = "edit_all_reservations.php";
}
</script>

</body>
</html>
