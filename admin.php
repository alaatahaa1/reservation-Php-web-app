<?php include 'db_connect2.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page - Reservations</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Custom styles for admin page */
    .card {
      margin-bottom: 20px;
    }
    /* Adjustments for smaller screens */
    @media (max-width: 768px) {
      .table-responsive {
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h1 class="text-center">الأدمن  - حجوزات</h1>
    </div>
  </div>

  <div class="row mb-3">
    <!-- Filter options -->
    <div class="col-md-4 col-lg-3 mb-2">
      <input type="text" class="form-control" id="searchInput" placeholder="Search by Name">
    </div>
    <div class="col-md-4 col-lg-3 mb-2">
      <select class="form-control" id="placeFilter">
        <option value="">Filter by Place</option>
        <?php
        // Fetch distinct places from the database
        $sql = "SELECT DISTINCT place FROM reservations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['place']; ?>"><?php echo $row['place']; ?></option>
            <?php
          }
        }
        ?>
      </select>
    </div>
    <div class="col-md-4 col-lg-3 mb-2">
      <input type="date" class="form-control" id="dateFilter">
    </div>
    <div class="col-md-4 col-lg-3 mb-2">
      <!-- Delete selected button -->
      <form id="deleteSelectedForm" method="post" style="display: inline;">
        <button type="submit" class="btn btn-danger btn-block">Delete Selected</button>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered" id="reservationTable">
          <thead>
            <tr>
              <th>
                <input type="checkbox" id="selectAllCheckbox">
              </th>
              <th>ID</th>
              <th>الأسم الكامل</th>
              <th>رقم الهاتف</th>
              <th>البرنامج</th>
              <th>موعد الرحلة</th>
              <th>مجموع السعر</th>
              <th>المقاعد</th>
              <th>عدد المقاعد المحجوزة</th> <!-- New column for total seats -->
              <th>تحديد</th>
              <th>تعديل</th>
              
            </tr>
          </thead>
          <tbody>
            <!-- Table rows will be dynamically generated here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-md-12 text-center">
      <!-- Button to edit all reservations -->
      <a href="edit_all_reservations.php" class="btn btn-warning">Edit All</a>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // Function to fetch and display reservations based on filters
    function fetchReservations() {
        var searchText = $("#searchInput").val().toLowerCase();
        var placeFilter = $("#placeFilter").val().toLowerCase();
        var dateFilter = $("#dateFilter").val();

        $.ajax({
            url: "fetch_reservations.php",
            method: "POST",
            data: { searchText: searchText, placeFilter: placeFilter, dateFilter: dateFilter },
            success: function(response) {
                $("#reservationTable tbody").html(response);
            }
        });
    }

    // Initial fetch of reservations
    fetchReservations();

    // Select All checkbox functionality
    $("#selectAllCheckbox").change(function() {
        $(".select-checkbox").prop("checked", $(this).prop("checked"));
    });

    // Function to handle form submission for deleting selected reservations
    $("#deleteSelectedForm").submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var selectedIds = $("input[name='selectedIds[]']:checked").map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert("Please select at least one reservation to delete.");
            return;
        }

        if (confirm("Are you sure you want to delete selected reservations?")) {
            $.post("delete_selected_reservations.php", { ids: selectedIds }, function(response) {
                alert(response);
                fetchReservations(); // Reload the reservations after deletion
            });
        }
    });

    // Function to handle change event for filters
    $("#searchInput, #placeFilter, #dateFilter").on("keyup change", function() {
        fetchReservations();
    });
});

//made by alaa taha 
</script>

</body>





</html>
