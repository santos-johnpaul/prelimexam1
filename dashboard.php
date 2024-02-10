dashboard.php
<?php
// Include the template content
ob_start();

require_once 'config/db.php';

include('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;




?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    
    
    <title>LMS</title>
</head>
<body>

<!-- Image view under the modal -->
<div class="mt-3">
 
<div class="logo-container">
<h1 class="logo-title"><b>Logo</b></h1>
    <?php
    // Fetch the image URL from the database
    $sql = "SELECT pic FROM logo";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imageURL = 'assets/img/' . $row['pic'];
            echo '<img src="' . $imageURL . '" alt="Logo Image" class="img-fluid">';
        } else {
            echo 'No image found.';
        }
    } else {
        echo 'Error in SQL query: ' . $conn->error;
    }
    ?>
    <br>
    <br>
    <br>
<!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Update
</button>
</div>

<br>
<!-- Button to trigger the modal -->
<div class="dashboard-container">
 
    <br>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="config/logo.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Choose File</label>
                            <input type="file" class="form-control" id="fileInput" name="fileInput" onchange="updateImageView(this)" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <h3>School Profile</h3>
        </div>
        <div class="profile-content">
            <?php
            // Fetch school profile data from the database
            $conn = connectToDatabase();
            $sql = "SELECT * FROM school_profile LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form action="config/school.php" method="post">
                    <div class="mb-3">
                        <label for="schoolName" class="form-label">School Name</label>
                        <input type="text" class="form-control" id="schoolName" name="schoolName" placeholder="Enter school name" value="<?php echo $row['school_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter school address" required><?php echo $row['address']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter contact number" value="<?php echo $row['contact_number']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </form>
                <?php
            } else {
                echo 'No school profile data found.';
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>

<!-- Button to trigger the modal -->
<!-- Button to trigger the modal -->
<!-- Button to trigger the modal -->
<!-- Button to trigger the modal -->
<div class="cover-container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#coverModal">
        Update
    </button>
    <h3>COVER PAGE</h3>

    <!-- Modal -->
    <div class="modal fade" id="coverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="config/cover.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Choose File</label>
                            <input type="file" class="form-control" id="fileInput" name="fileInput" onchange="updateImageView(this)">
                        </div>
                        <button type="submit" class="btn btn-primary" name="upload">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <table class="table">
            <thead>
                <tr>
       
                    <th scope="col">Picture</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="fileTableBody">
                <!-- File information will be dynamically added here -->
                <?php
                // Fetch data from your database and loop through the results
                $conn = connectToDatabase();
                $sql = "SELECT id, picture_path FROM cover";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        
                        echo '<td><img src="photos/' . $row["picture_path"] . '" alt="' . $row["picture_path"] . '" width="100" height="100"></td>';

                        echo '<td>';
                        echo '<form action="config/cover.php" method="post" style="display: inline;">';
                        echo '<input type="hidden" name="deleteId" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="btn btn-danger">Delete</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No data found</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>




<div>
    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cards">
        Add
    </button>
    <h3>Card and Images</h3>
    <!-- Modal -->
    <div class="modal fade" id="cards" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" action="config/alumni.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="fileInput" class="form-label">Choose File</label>
        <input type="file" class="form-control" id="fileInput" name="fileInput" onchange="updateImageView(this)">
    </div>
    <div class="mb-3">
        <label for="insertTitle" class="form-label">Insert Title</label>
        <input type="text" class="form-control" id="insertTitle" name="insertTitle" placeholder="Insert Title">
    </div>
    <div class="mb-3">
        <label for="insertCaption" class="form-label">Insert Caption</label>
        <input type="text" class="form-control" id="insertCaption" name="insertCaption" placeholder="Insert Caption">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table to display card information -->
<div class="container mt-3">
    <?php
    $conn = connectToDatabase();
    $sql = "SELECT id, image_path, title, caption FROM cards";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <!-- Card for each row -->
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="photos/<?php echo $row['image_path']; ?>" alt="<?php echo $row['image_path']; ?>" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo $row['caption']; ?></p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>

                            <!-- Delete form -->
                            <form method="post" action="config/alumni.php" class="d-inline">
                                <input type="hidden" name="deleteId" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Card Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for editing -->
                            <form method="post" action="config/alumni.php" enctype="multipart/form-data">
                                <input type="hidden" name="editId" value="<?php echo $row['id']; ?>">

                                <div class="mb-3">
                                    <label for="editFileInput" class="form-label">Choose File</label>
                                    <input type="file" class="form-control" id="editFileInput" name="editFileInput" onchange="updateImageView(this)">
                                </div>

                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="editTitle" name="editTitle" value="<?php echo $row['title']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="editCaption" class="form-label">Caption</label>
                                    <input type="text" class="form-control" id="editCaption" name="editCaption" value="<?php echo $row['caption']; ?>">
                                </div>

                                <!-- Add other form elements as needed -->

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
    } else {
        echo '<div class="alert alert-info" role="alert">No data found</div>';
    }
    $conn->close();
    ?>
</div>

<h2>Content GRID</h2>
  <div class="row">
    <!-- Add New Card Form -->
    <div class="column">
        <div class="card">
            <form action="config/content.php" method="POST" class="my-form">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title">
                <label for="caption">Caption:</label>
                <input type="text" id="caption" name="caption">
                <label for="size">Size:</label>
                <input type="text" id="size" name="size">
                <label for="color">Color:</label>
                <input type="color" id="color" name="color">
                <br>
                <br>
                <input type="submit" name="add_card" value="Add Card">
            </form>
        </div>
    </div>

    <!-- Display Cards -->
    <?php
   $conn = connectToDatabase();

   // Retrieve and display the data
   $sql = "SELECT * FROM grid_data";
   $result = $conn->query($sql);
   
    if ($result->num_rows > 0) {
        // Display form for each card
        while ($row = $result->fetch_assoc()) {
            echo "<div class='column'>";
            echo "<div class='card'>";
            echo "<form action='config/content.php' method='POST'>";
            echo "<input type='hidden' name='card_id' value='" . $row['id'] . "'>";
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='title' value='" . $row['title'] . "'><br>";
            echo "<label for='caption'>Caption:</label>";
            echo "<textarea name='caption'>" . $row["caption"] . "</textarea><br>";
            echo "<label for='size'>Size:</label>";
            echo "<input type='number' id='size' name='size' value='" . $row['size'] . "' max='5'><br>";
            echo "<label for='color'>Color:</label>";
            echo "<input type='color' id='color' name='color' value='" . $row['background_color'] . "'><br>";
            echo "<input type='submit' name='update_card' value='Update' style='margin-right: 10px;'><input type='submit' name='delete_card' value='Delete'>";
            echo "</form>";

            // Form for delete button

            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "No cards found.";
    }
    ?>
</div>

</body>
</html>

<style>
.logo-container {
        text-align: center;
        padding: 40px; /* Adjust the padding as needed */
        background-color: #ffffff; /* Set background color */
        border-radius: 10px; /* Optional: Add rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
    }

    .logo-container img {
        max-width: 50%;
        height: auto;
    }
    .logo-title {
    margin-bottom: 10px; /* Adjust margin as needed */
    text-align: left;
}

.dashboard-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.modal-content {
    /* Add styles for the modal content */
}

.profile-container {
    margin-top: 20px;
    /* Add styles for the profile container */
}

.profile-header h3 {
    /* Add styles for the profile header */
}

.profile-content form {
    /* Add styles for the profile form */
}

.cover-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.modal-content {
    /* Add styles for the modal content */
}

.table {
    /* Add styles for the table */
}

/* Add more styles as needed */

</style>