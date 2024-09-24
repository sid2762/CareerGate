<?php
session_start();
require 'comp/_dbconnect.php';

if (!isset($_GET['comp_id']) || empty($_GET['comp_id'])) {
    echo "Error: No company ID provided.";
    exit();
}
$id = $_GET['comp_id'];

$sql = "SELECT * FROM posts WHERE sno = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $comp = mysqli_fetch_assoc($result);
} else {
    echo "Error while loading data of company";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['user']['sno'];
    $company_id = $id;
    $comp_name = $comp['company_name'];
    $apply_sql = "INSERT INTO applications (stu_id, comp_name, comp_id) VALUES ('$student_id', '$comp_name', '$company_id')";
    $apply_result = mysqli_query($conn, $apply_sql);

    if ($apply_result) {
        echo "Application successful!";
        header("location: view.php?comp_id=$id");
        exit();
    } else {
        echo "Error applying to the company";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>View Post Details</title>
</head>

<body>
    <?php include 'comp/_navbar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?php echo $comp['company_name']; ?></h2>
                <h2><?php echo $comp['title']; ?></h2>
                <p><?php echo $comp['description']; ?></p>
            </div>
            <div class="col">
                <!-- Apply form -->
                <form action="" method="POST">
                    <button type="submit" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<!-- 
hii I'm Siddharth
 -->