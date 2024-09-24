<?php
session_start();
if (!isset($_SESSION['admin-logged-in']) || $_SESSION['admin-logged-in'] != true) {
    header("Location: admin_login.php");
    exit();
}

$admin = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            
            <!-- Post Creation Section -->
            <div class="col">
                <div class="bg-light p-4">
                    <h3>Manage Posts</h3>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#createPostModal">
                        Create Post
                    </button>

                    <!-- Modal for Creating Post -->
                    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="post_create.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Create Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fetch and Display Posts -->
                    <?php
                        require 'comp/_dbconnect.php';

                        if (!$conn) {
                            echo "<h2>Database could not be accessed.</h2>";
                        } else {
                            $list = "SELECT * FROM posts";
                            $isList = mysqli_query($conn, $list);

                            if ($isList && mysqli_num_rows($isList) > 0) {
                                echo '<table class="table mt-4 table-striped">';
                                echo '<thead><tr><th>Company Name</th><th>Title</th><th>Description</th><th>Details</th></tr></thead>';
                                echo '<tbody>';

                                while ($row = mysqli_fetch_assoc($isList)) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['company_name']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                    echo '<td><a href="details.php?comp_id=' . $row['sno'] . '" class="btn btn-info">Applicant Details</a></td>';
                                    echo '</tr>';
                                }

                                echo '</tbody></table>';
                            } else {
                                echo "<h2>No Posts Are There In The Database.</h2>";
                            }
                        }

                        mysqli_close($conn); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'comp/_footer.php';?>
</body>
</html>
