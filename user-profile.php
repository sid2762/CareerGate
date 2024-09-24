<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile and Notifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <!-- User Profile Section -->
            <!-- <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <div style="width: 200px; height: 200px; margin: 0 auto; overflow: hidden;">
                            <img class="card-img-top rounded-circle" src="images/img5.png" alt="user profile" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h4 class="card-title mt-3"><?php echo $user['fname']." ".$user['lname']; ?></h4>
                        <p class="card-text">Student</p>
                        <p class="card-text">Email: <?php echo $user['email']; ?></p>
                        <a href="edit_profile.php" class="btn btn-light mt-2">Edit Profile</a>
                    </div>
                </div>
            </div> -->

            <!-- Notifications Section -->
            <div class="col">
                <div class="bg-light p-4">
                    <h3 class="text-center">Notifications</h3>

                    <!-- Fetch and Display Notifications -->
                    <?php
                        require 'comp/_dbconnect.php';

                        if (!$conn) {
                            echo "<h2>Database could not be accessed.</h2>";
                        } else {
                            
                            $posts = "SELECT * FROM posts";
                            $isPosts = mysqli_query($conn, $posts);
                            if ($isPosts && mysqli_num_rows($isPosts)>0) {
                                echo '<table class="table mt-4 table-hover ">';
                                echo '<thead><tr><th>Title</th><th>Description</th><th>Status</th><th>View</th></tr></thead>';
                                echo '<tbody>';
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($isPosts)) {
                                    echo '<tr>';
                                    echo '<td>'.$no.'</td>';
                                    $no++;
                                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                    // echo '<td>' . (!empty($row['attachment']) ? '<a href="uploads/' . htmlspecialchars($row['attachment']) . '">View Attachment</a>' : 'No attachment') . '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-primary" href="view.php?comp_id='.htmlspecialchars($row['sno']).'">';
                                    echo 'View';
                                    echo '</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                echo '</tbody></table>';
                            } else {
                                echo "<h4>No Notifications Available.</h4>";
                            }
                        }

                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




                                