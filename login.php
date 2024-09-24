

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <?php include 'comp/_navbar.php';?>
    <h1 class="text-center my-5">
        Log in your Account
    </h1>
    <div class="container mt-5 mb-5">
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <label for="uname" class="my-2">Enter your Usernmae :</label>
            <input type="text" id="uname" name="uname" class="form-control">
            <label for="pswd" class="my-2">Enter your Password :</label>
            <input type="password" id="pswd" name="pswd" class="form-control">
            <button type="submit" class="btn btn-primary my-5">Log in</button>
        </form>
    </div>
</body>
</html>
<?php

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    require 'comp/_dbconnect.php';
    $uname = $_POST["uname"];
    $pswd = $_POST["pswd"];

    $sql = "SELECT * FROM students WHERE uname = '$uname'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)==0) {
        echo "<script>alert('User does not exists');</script>";
    }else{
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        if (password_verify($pswd, $hashed_password)) {
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['user']=$row;
            header("location: user-profile.php");
        }else{
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
}

?>