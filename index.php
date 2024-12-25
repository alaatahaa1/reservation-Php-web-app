<?php
include 'db_conn.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>نوروز للسفر والسياحة</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
      background-image: url('pics/14.jpg');
      background-size: cover;
      background-position: center;
      margin: 0;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }
    .bus-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 5px;
    }
    .seat {
      background-color: #ffd700;
      color: #000;
      padding: 10px;
      cursor: pointer;
      border-radius: 10px;
      text-align: center;
    }
    .selected {
      background-color: #000;
      color: #ffd700;
    }
    .reserved {
      background-color: #ff0000;
      color: #fff;
      cursor: not-allowed;
    }
    .card {
      background-color: #f8f9fa;
      color: #000;
    }
    .btn-primary {
      background-color: #000;
      border-color: #ffd700;
      color: #ffd700;
    }
    .btn-primary:hover {
      background-color: #ffd700;
      color: #000;
    }
    .container {
      flex: 1;
      text-align: right;
      font-weight: bolder;
    }
    footer {
      position: relative;
      width: 100%;
      overflow: hidden;
      background: linear-gradient(90deg, #000 50%, #ffd700 50%);
      text-align: center;
      color: #fff;
      padding: 10px 0;
    }
    footer .white-text {
      color: #fff;
    }
    footer .black-text {
      color: #000;
    }
    /* Additional CSS for the Arabic text "والسياحة" */
    footer .arabic-text {
      color: #fff;
    }
    .bg-dark-green {
      background-color: #0b4f30;
    }
    .custom-yellow {
      color: #FFEF00;
    }
    .brdr {
      border-radius: 25px;
      border-style: solid;
      border-color: rgba(255, 255, 255, 0.5);
      height: 60px;
    }
    /* Custom CSS for Alert Box */
    .alert-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
    }
    .alert-box {
      background-color: #ffffff;
      border: 1px solid #ccc;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      width: 100%;
      text-align: center;
      font-size: 18px;
    }
    .half-transparent-card {
      background-color: rgba(255, 255, 255, 0.5);
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    /* Updated styles for the header */
    header {
      background-color: #000;
      color: #fff;
      padding: 10px;
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .fading-text {
      font-weight: bold;
      font-size: 24px;
      animation: fadeInOut 10s infinite;
    }
    /* Updated styles for the articles section */
    .articles-section {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  flex-wrap: wrap;
  margin-top: 20px;
}

.article {
  flex: 0 1 30%;
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: opacity 0.5s ease, transform 0.5s ease;
  opacity: 0;
  transform: translateY(20px);
  text-align: center;
}

.article img {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 10px;
}

.article h3 {
  font-size: 1.2rem;
  margin-bottom: 10px;
}

.article p {
  font-size: 1rem;
  line-height: 1.6;
  color: #333;
}

.article.active {
  opacity: 1;
  transform: translateY(0);
}


  </style>
</head>
<body>

<header>
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <img src="now.jpg" alt="img" class="img-fluid mb-0 fading-text " style="max-width: 100px; height: auto;">
      <p class="text-center mb-0 custom-yellow  ", style:italic> نوروز</p>
      <p class="text-center mb-0 custom-yellow "> للسفر والسياحة</p>
    </div>
  </header>



<div class="container mt-5 mb-5 ">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card half-transparent-card">
        <div class="card-body">
          <h2 class="card-title text-center brdr">معلومات الحجز</h2>
          <form id="reservationForm" method="post">
            <div class="form-group">
              <label   for="fullName">الأسم الثلاثي</label>
              <input type="text" class="form-control" id="fullName" name="fullName" required>
            </div>
            <div class="form-group">
              <label for="phoneNumber">رقم الهاتف (+964)</label>
              <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group">
              <label for="place">البرنامج</label>
              <select class="form-control" id="place" name="place" required>
                <option value="ايران">ايران</option>
                <option value="اربيل">اربيل</option>
                <option value="دهوك">دهوك</option>
                <option value="السليمانية">السليمانية</option>
              </select>
            </div>
            <div class="form-group">
              <label for="travelDate">تاريخ الرحلة</label>
              <input type="date" class="form-control" id="travelDate" name="travelDate" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
              <label for="price">السعر   (IQD)</label>
              <input type="text" class="form-control" id="price" name="price" value="15000" readonly>
            </div>
            <button type="button" class="btn btn-primary btn-block" id="showSeatsBtn">المقاعد</button>
            <div class="bus-grid" style="display: none;">
              <div class="text-center" style="grid-column: span 4;">الأمام</div>
              <?php for ($row = 1; $row <= 12; $row++) { ?>
                  <?php for ($column = 1; $column <= 4; $column++) { ?>
                      <?php 
                          $seatNumber = ($row - 1) * 4 + $column;
                          $seatClass = 'seat';
                      ?>
                      <div class="<?php echo $seatClass; ?>" data-seat="<?php echo $seatNumber; ?>">مقعد <?php echo $seatNumber; ?></div>
                  <?php } ?>
              <?php } ?>
              <div class="text-center" style="grid-column: span 4;">الخلف</div>
            </div>
            <input type="hidden" name="selectedSeats[]" id="selectedSeatsInput" value="">
            <button type="submit" class="btn btn-primary btn-block mt-3" id="reserveBtn" disabled>حجز</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Articles Section -->
<section class="articles-section">
  <div class="article">
    <img src="pics/13.jpg" alt="Article 1">
    <h3>عنوان المقال الأول</h3>
    <p>نص المقال الأول يمكن أن يكون هنا. يمكنك وضع محتوى المقال الخاص بك هنا.</p>
  </div>
  <div class="article">
    <img src="pics/10_2.jpg" alt="Article 2">
    <h3>عنوان المقال الثاني</h3>
    <p>نص المقال الثاني يمكن أن يكون هنا. يمكنك وضع محتوى المقال الخاص بك هنا.</p>
  </div>
  <div class="article">
    <img src="pics/12.png" alt="Article 3">
    <h3>عنوان المقال الثالث</h3>
    <p>نص المقال الثالث يمكن أن يكون هنا. يمكنك وضع محتوى المقال الخاص بك هنا.</p>
  </div>
</section>


<footer>
  
  <div class="container">
    <p class="text-center">
      <span class="white-text">&copy; <?php echo date('Y'); ?></span>
      <span class="black-text">شركة نوروز للسفر</span>
      <span class="arabic-text">و السياحة  </span>
    </p>
  </div>
</footer>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {


  var articles = $(".article");
var windowHeight = $(window).height();

$(window).on("scroll", function() {
  var scrollTop = $(this).scrollTop();

  articles.each(function() {
    var articleHeight = $(this).outerHeight();
    var offsetTop = $(this).offset().top;
    var offsetBottom = offsetTop + articleHeight;

    // Calculate the middle of the article
    var articleMiddle = offsetTop + articleHeight / 2;

    // Calculate the middle of the viewport
    var viewportMiddle = scrollTop + windowHeight / 2;

    // Calculate the distance between the middle of the article and the middle of the viewport
    var distanceToMiddle = Math.abs(articleMiddle - viewportMiddle);

    // Calculate the scroll offset to trigger the animation
    var scrollOffset = windowHeight * 0.4;

    // Check if the article is in the viewport and within the scroll offset
    if (distanceToMiddle < windowHeight * 0.4) {
      $(this).addClass("active");
    } else {
      $(this).removeClass("active");
    }
  });
});


    var previousSelectedSeats = [];
    var basePrice = 15000;

    // Array of background images
    var backgroundImages = [
        'pics/2_6.jpg',
        'pics/10_2.jpg',
        'pics/unnamed.jpg'
        ,'pics/4_4.jpg'
       ,'pics/12.png',
        'pics/13.jpg',
        'pics/14.jpg' ,'pics/DgAyRhhW0AEJZ98.jpg'
    ];

    var currentBgIndex = 0;

    function preloadImages(imageArray) {
        var loadedImages = 0;
        var images = [];
        for (var i = 0; i < imageArray.length; i++) {
            images[i] = new Image();
            images[i].src = imageArray[i];
            images[i].onload = function() {
                loadedImages++;
                if (loadedImages == imageArray.length) {
                    changeBackgroundImage();
                }
            };
        }
    }

   /* function changeBackgroundImage() {
        $('body').css('background-image', 'url(' + backgroundImages[currentBgIndex] + ')');
        currentBgIndex = (currentBgIndex + 1) % backgroundImages.length;
        // Automatically change background every 10 seconds
        setTimeout(changeBackgroundImage, 10000);
    }*/




    // Call the function initially to set the first background image
preloadImages(backgroundImages);


    function checkIfSeatsSelected() {
        var selectedSeats = $(".seat.selected").length;
        var totalPrice = basePrice * selectedSeats;
        $("#price").val(totalPrice);

        if (selectedSeats > 0) {
            $("#reserveBtn").prop("disabled", false);
        } else {
            $("#reserveBtn").prop("disabled", true);
        }
    }

    $(".seat").click(function() {
        $(this).toggleClass("selected");
        checkIfSeatsSelected();
    });

    $("#showSeatsBtn").click(function() {
        previousSelectedSeats = $(".seat.selected").map(function() {
            return $(this).data("seat");
        }).get();
        $(".bus-grid").toggle();
    });

    $("#showSeatsBtn").on('hide.bs.collapse', function() {
        $(".seat").removeClass("selected");
        previousSelectedSeats.forEach(function(seat) {
            $(".seat[data-seat='" + seat + "']").addClass("selected");
        });
    });

    $("#reservationForm").submit(function(event) {
        if ($(".seat.selected").length === 0) {
            showAlert("يرجى تحديد مقعد واحد على الأقل.");
            event.preventDefault();
        } else {
            var selectedSeats = $(".seat.selected").length;
            var totalPrice = basePrice * selectedSeats;
            $("#price").val(totalPrice);

            var selectedSeatNumbers = $(".seat.selected").map(function() {
                return $(this).data("seat");
            }).get();
            $("#selectedSeatsInput").val(selectedSeatNumbers.join(','));
        }
    });

    function showAlert(message) {
        var alertBox = '<div class="alert-container"><div class="alert-box">' + message + '</div></div>';
        $("body").append(alertBox);
        setTimeout(function() {
            $(".alert-container").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Automatically change background every 3 seconds

    // Display message if it's set
    var message = "<?php echo $message; ?>";
    if (message) {
        showAlert(message);
    }
});
//made by alaa taha 
</script>

</body>
</html>
