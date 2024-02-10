<?php
require_once 'config/db.php';

// Image Slider section
$connImageSlider = connectToDatabase();
$coverImagesQuery = "SELECT picture_path FROM cover";
$coverImagesResult = $connImageSlider->query($coverImagesQuery);

// Cards section
$connCards = connectToDatabase();
$sqlCards = "SELECT image_path, title, caption FROM cards";
$resultCards = $connCards->query($sqlCards);

// Grid section
$connGrid = connectToDatabase();
$sqlGrid = "SELECT * FROM grid_data";
$resultGrid = $connGrid->query($sqlGrid);

// Check if any section has data
if ($coverImagesResult->num_rows > 0 || $resultCards->num_rows > 0 || $resultGrid->num_rows > 0) {
    ?>
    <!-- Your existing HTML and PHP code for the Image Slider, Cards, and Grid sections -->
    <!-- ... -->

<?php
} else {
    // Display global "Under Construction" message
    echo '<div class="alert alert-info mt-3">Under Construction</div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>

<header class="d-flex justify-content-center align-items-center">
    <!-- Logo -->
    <div class="logo">
        <?php
        $conn = connectToDatabase();
        $logoQuery = "SELECT pic FROM logo LIMIT 1"; // Assuming you have only one logo
        $logoResult = $conn->query($logoQuery);

        if ($logoResult->num_rows > 0) {
            $logoRow = $logoResult->fetch_assoc();
            $logoPath = $logoRow['pic'];

            // Display the logo with responsive image class
            echo '<img src="assets/img/' . $logoPath . '" alt="Logo" class="img-fluid">';

        } else {
            // Display a default logo or handle accordingly
            echo '<img src="default-logo.png" alt="Default Logo" class="img-fluid">';
        }

        $conn->close();
        ?>
    </div>

    <!-- Navbar -->
    <nav>
        <div>
            <a href="#">Home</a>
            <a href="#">Contact US</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#enrollModal">Enroll Now</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </div>
    </nav>
</header>

<!-- Rest of your HTML content -->

<!-- Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>


<!-- Image Slider -->
<div id="imageSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
            // Include your database connection file
            

            // Fetch cover images from the database
            $conn = connectToDatabase();
            $coverImagesQuery = "SELECT picture_path FROM cover";
            $coverImagesResult = $conn->query($coverImagesQuery);

            if ($coverImagesResult->num_rows > 0) {
                $active = true; // To set the first image as active

                while ($coverImageRow = $coverImagesResult->fetch_assoc()) {
                    $imagePath = $coverImageRow['picture_path'];

                    // Check if the file exists
                    $imageFullPath = 'photos/' . $imagePath;

                    if (file_exists($imageFullPath)) {
                        // Display each cover image as a carousel item
                        echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                        echo '<img src="' . $imageFullPath . '" alt="Cover Image" class="d-block w-100">';
                        echo '</div>';

                        $active = false; // Set to false after the first iteration
                    } else {
                        // Handle the case where the file doesn't exist
                        echo '<div class="alert alert-warning">Image not found: ' . $imageFullPath . '</div>';
                    }
                }
            } else {
                // Display a default image or handle accordingly
                echo '<div class="carousel-item active">';
                echo '<img src="default-cover-image.jpg" class="d-block w-100" alt="Default Cover Image">';
                echo '</div>';
            }

            $conn->close();
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php
$conn = connectToDatabase();
$sql = "SELECT image_path, title, caption FROM cards";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <!-- Container outside the loop -->
    <div class="container-fluid card-container">
        <div class="row">
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <!-- Image with Description for each row -->
                <div class="col-md-4">
                    <div class="card">
                        <!-- Replace "your-image.jpg" with the actual image path from your database -->
                        <img src="photos/<?php echo $row['image_path']; ?>" alt="Image with Description" class="img-fluid rounded" style="max-width: 100%; height: 2in;">
                        <div class="card-body">
                            <b><h2 class="card-title"><?php echo $row['title']; ?></h2></b>
                            <p class="card-text"><?php echo $row['caption']; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else {
    echo 'No data available.';
}
?>
<div class="container mt-4 d-flex flex-wrap">

<?php
  $conn = connectToDatabase();

  // Retrieve and display the data
  $sql = "SELECT * FROM grid_data";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Display form for each card
    while ($row = $result->fetch_assoc()) {
      echo "<div class='col-md-4'>";
      echo "<div class='card d-flex flex-grow-1' style='background-color: " . $row['background_color'] . ";'>";
      
      // Dynamically set font size based on the 'size' property
      echo "<p class='fw-bold' style='font-size: " . $row['size'] . "mm;'>" . $row['title'] . "</p>";
      echo "<p style='font-size: " . $row['size'] . "mm;'>" . $row['caption'] . "</p>";
  
      echo "</div>";
      echo "</div>";
    }
  } else {
    // Handle case when no cards are found
    echo "No cards found.";
  }
?>

</div>


 

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="config/login.php">
                        <label for="username">Username:</label>
                        <input type="text" name="username" required><br>

                        <label for="password">Password:</label>
                        <input type="password" name="password" required><br>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Enroll Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollModalLabel">Enroll Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your enrollment form here -->
              
                <form method="post" action="config/enroll.php">
                <p><b>I. Create your Student Portal Account</b></p>
                    <label for="username">Username:</label>
                    <input type="text" name="username" required><input type="text" name="sformat" value="@student" readonly><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required><br>

                    <label for="email">Email Address</label>
                    <input type="email" name="email" required><br>

                   

                    <!-- Add more fields as needed -->
                    <p><b>II. Education</b></p>
                    <label for="elem">Elementary</label>
                    <input type="text" name="elem" required><br>

                    <button type="submit" class="btn btn-primary">Enroll</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Other HTML content -->

<nav>
    <div>
        <a href="#">Home</a>
        <a href="#">Contact US</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#enrollModal">Enroll Now</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
    </div>
</nav>

<!-- Other HTML content -->

    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <?php
            $conn = connectToDatabase();
            $sql = "SELECT school_name, address, contact_number FROM school_profile";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<img src="assets/img/tt.png" alt="School Logo" width="30" height="30" style="float: left; margin-right: 10px;"><p>School Name: ' . $row['school_name'] . '</p>';
                echo '<img src="assets/img/location.png" alt="School Logo" width="30" height="30" style="float: left; margin-right: 10px;"><p>Address: ' . $row['address'] . '</p>';
                echo '<img src="assets/img/add-contact.png" alt="School Logo" width="30" height="30" style="float: left; margin-right: 10px;"><p>Contact Number: ' . $row['contact_number'] . '</p>';
            } else {
                echo 'No school profile data available.';
            }

            $conn->close();
            ?>
        </div>
  
    </footer>


</body>
</html>
<style>
  <style>
     body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .card {
      border-radius: 10px;
      box-shadow: 10px 8px 10px rgba(0, 0, 0, 0.1);
      padding: 15px;
      margin-bottom: 15px;
    }
    .card-container {
      margin-top: 5%;
    }

    .card {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card img {
      width: 100%;
      height: auto;
    }

    .card-body {
      padding: 20px;
    }
    .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-height: 100px; /* Adjust the height as needed */
            margin-right: 50px; /* Add margin to separate the logo from the navbar links */
        }

        /* Align the logo in the footer */
        .footer .logo {
            margin-right: 0; /* Remove margin to align the logo to the left in the footer */
        }
  </style>