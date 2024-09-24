<?php
session_start(); 

if (isset($_SESSION['admin-logged-in']) && $_SESSION['admin-logged-in'] === true) {
    header("Location: admin_dashboard.php"); // Redirect to admin dashboard
    exit(); 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration and Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-card {
            width: 100%;
        }
    </style> -->
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>
    <div class="container my-5">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" class="form-group">
                <label for="uname">Username</label>
                <input type="text" name="username" class="form-control" required>

                <label for="pswd">Password</label>
                <input type="password" name="pswd" class="form-control" required>

                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>
    </div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'comp/_dbconnect.php';

    // Capture form data safely
    $uname = mysqli_real_escape_string($conn, $_POST["username"]);
    $pswd = mysqli_real_escape_string($conn, $_POST["pswd"]);

    // SQL query to check if admin exists
    $sql = "SELECT * FROM `admins` WHERE `username`='$uname' AND `password`='$pswd'";
    $result = mysqli_query($conn, $sql);

    // Check if the user exists
    if (mysqli_num_rows($result) == 1) {
        // Set session or perform login action
        session_start();
        $_SESSION['admin-logged-in'] = true;
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $admin;
        // Redirect to avoid form resubmission
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "<script>alert('Invalid credentials. Please try again.');</script>";
    }
}
?>
</html>
