<?php
session_start();
if (!isset($_SESSION['admin-logged-in']) || $_SESSION['admin-logged-in'] != true) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'comp/_dbconnect.php';
    
    if (!$conn) {
        echo "
        <script>
            alert('Failed to connect to the database.');
            window.location.href = 'admin_dashboard.php';
        </script>
        ";
        exit(); 
    }

    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO `posts` (`company_name`, `title`, `description`, `created_at`) 
            VALUES ('$company', '$title', '$desc', CURRENT_TIMESTAMP);";
    
    if (mysqli_query($conn, $sql)) {
        echo "
        <script>
            alert('Post has been created successfully');
            window.location.href = 'admin_dashboard.php';
        </script>
        ";
    } else {
        $error_message = mysqli_error($conn); 
        echo "
        <script>
            alert('Post could not be created. Error: $error_message');
            window.location.href = 'admin_dashboard.php';
        </script>
        ";
    }

    mysqli_close($conn);
}
?>
