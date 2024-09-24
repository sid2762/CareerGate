<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <title>Home Page</title>
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>
    <h1 class="text-center my-5">
        Welcome To The Placement Drive Service
    </h1>
    <div class="container ">
    <div class="row my-15">
        <div class="col">
            <a href="registration.php" style="all:unset; cursor: pointer;">
                <h3 class="text-center bg-info text-light p-3" style="border-radius:15px;">Register</h3>
            </a>
        </div>
        <div class="col">
            <a href="login.php" style="all:unset; cursor:pointer;">
                <h3 class="text-center bg-info text-light p-3" style="border-radius:15px;">Login</h3>
            </a>
        </div>
    </div>
    </div>
</body>
</html>