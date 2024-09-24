<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'comp/_dbconnect.php';

    $fnameErr = $lnameErr = $unameErr = $emailErr = $pswdErr = $cpswdErr = $rollnoErr = $phoneErr = $skillsErr = $addressErr = "";
    $errors = [];

    // Validate and sanitize inputs
    function sanitize_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $fname = sanitize_input($_POST['fname']);
    $lname = sanitize_input($_POST['lname']);
    $uname = sanitize_input($_POST['uname']);
    $email = sanitize_input($_POST['email']);
    $pswd = sanitize_input($_POST['pswd']);
    $cpswd = sanitize_input($_POST['cpswd']);
    $rollno = sanitize_input($_POST['rollno']);
    $phone = sanitize_input($_POST['phone']);
    $skills = isset($_POST['languages']) ? implode(", ", $_POST['languages']) : "";
    $address = sanitize_input($_POST['address']);
    $year = sanitize_input($_POST['year']);
    $gender = sanitize_input($_POST['gender']);
    $branch = sanitize_input($_POST['branch']);
    $achievements = sanitize_input($_POST['achievements']);
    $github = sanitize_input($_POST['github']);
    $linkedin = sanitize_input($_POST['linkedin']);
    $leetcode = sanitize_input($_POST['leetcode']);
    $gfg = sanitize_input($_POST['gfg']);
    $hackerrank = sanitize_input($_POST['hackerrank']);

    // Error checking
    if (empty($fname)) {
        $fnameErr = "First Name is required";
        $errors[] = $fnameErr;
    }
    if (empty($lname)) {
        $lnameErr = "Last Name is required";
        $errors[] = $lnameErr;
    }
    if (empty($uname)) {
        $unameErr = "Username is required";
        $errors[] = $unameErr;
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Valid email is required";
        $errors[] = $emailErr;
    }
    if (empty($pswd) || strlen($pswd) < 8) {
        $pswdErr = "Password must be at least 6 characters long";
        $errors[] = $pswdErr;
    }
    if ($pswd !== $cpswd) {
        $cpswdErr = "Passwords do not match";
        $errors[] = $cpswdErr;
    }
    if (empty($rollno)) {
        $rollnoErr = "Enrollment Number is required";
        $errors[] = $rollnoErr;
    }
    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
        $phoneErr = "A valid 10-digit phone number is required";
        $errors[] = $phoneErr;
    }

    $valid = "SELECT uname FROM students WHERE uname = '$uname'";
    $result = mysqli_query($conn, $valid);

    if (mysqli_num_rows($result) > 0) {
        $unameErr = "Username already exists";
        $errors[] = $unameErr;
    }

    if (empty($errors)) {
        $pwd = password_hash($pswd, PASSWORD_BCRYPT);
        $sql = "INSERT INTO `students` (`fname`, `lname`, `rollno`, `phone`, `uname`, `email`, `email_verified`, `password`, `address`, `year`, `gender`, `branch`, `achievements`, `skills`, `github`, `linkedin`, `leetcode`, `gfg`, `created_at`) VALUES ('$fname', '$lname', '$rollno', '$phone', '$uname', '$email', '', '$pwd', '$address', '$year', '$gender', '$branch', '$achievements', '$skills', '$github', '$linkedin', '$leetcode', '$gfg', CURRENT_TIMESTAMP)";
        if (mysqli_query($conn, $sql)) {

            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
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

    <title>Register Yourself</title>
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>
    <h1 class="text-center my-5">
        Register Yourself To Us
    </h1>
    <div class="container mt-5 mb-5">
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
            <div class="row my-2">
                <div class="col">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" class="form-control" placeholder="Enter your first name">
                    <small class="text-danger"><?php echo $fnameErr;?></small>
                </div>
                <div class="col">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" class="form-control" placeholder="Enter your last name">
                    <small class="text-danger"><?php echo $lnameErr;?></small>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="rollno">Enrollment Number :</label>
                    <input type="text" id="rollno" name="rollno" class="form-control" placeholder="Enter your Enrollment Number">
                    <small class="text-danger"><?php echo $rollnoErr;?></small>
                </div>
                <div class="col">
                    <label for="phone">Phone :</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your Phone Number">
                    <small class="text-danger"><?php echo $phoneErr;?></small>
                </div>
            </div>

            <!-- Year Selection -->
            <div class="row my-2">
                <div class="col">
                    <h5>Select Year</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="year1" name="year" value="1">Year 1
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="year2" name="year" value="2">Year 2
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="year3" name="year" value="3">Year 3
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="year4" name="year" value="4">Year 4
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="year5" name="year" value="5">Year 5
                    </div>
                </div>
            </div>

            <!-- Gender Selection -->
            <div class="row my-2">
                <div class="col">
                    <h5>Select Gender</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="male" name="gender" value="Male">Male
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="female" name="gender" value="Female">Female
                    </div>
                </div>
            </div>

            <!-- Branch Selection -->
            <div class="row my-2">
                <div class="col">
                    <h5>Select Branch</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="cse" name="branch" value="CSE">CSE
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="cse-aiml" name="branch" value="CSE (AIML)">CSE (AIML)
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="tt" name="branch" value="TT">TT
                    </div>
                </div>
            </div>

            <!-- Username and Email -->
            <div class="row my-2">
                <div class="col">
                    <label for="uname">Username :</label>
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Enter your username">
                    <small class="text-danger"><?php echo $unameErr;?></small>
                </div>
                <div class="col">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                    <small class="text-danger"><?php echo $emailErr;?></small>
                </div>
            </div>

            <!-- Password and Confirm Password -->
            <div class="row my-2">
                <div class="col">
                    <label for="pswd">Password :</label>
                    <input type="password" id="pswd" name="pswd" class="form-control" placeholder="Enter your password">
                    <small class="text-danger"><?php echo $pswdErr;?></small>
                </div>
                <div class="col">
                    <label for="cpswd">Confirm Password :</label>
                    <input type="password" id="cpswd" name="cpswd" class="form-control" placeholder="Confirm your password">
                    <small class="text-danger"><?php echo $cpswdErr;?></small>
                </div>
            </div>

            <!-- Address -->
            <div class="row my-2">
                <div class="col">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" class="form-control" placeholder="Enter your address"></textarea>
                    <small class="text-danger"><?php echo $addressErr;?></small>
                </div>
            </div>

            <!-- Achievements -->
            <div class="row my-2">
                <div class="col">
                    <label for="achievements">Achievements:</label>
                    <textarea id="achievements" name="achievements" rows="4" class="form-control" placeholder="Mention your achievements"></textarea>
                </div>
            </div>

            <!-- Skills -->
            <div class="row my-2">
                <div class="col">
                    <h5>Select Languages You Know</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" id="cpp" value="C++">C++
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" id="java" value="Java">Java
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" id="python" value="Python">Python
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" id="javascript" value="JavaScript">JavaScript
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="row my-2">
                <div class="col">
                    <label for="github">GitHub Profile :</label>
                    <input type="url" id="github" name="github" class="form-control" placeholder="Enter your GitHub profile URL">
                </div>
                <div class="col">
                    <label for="linkedin">LinkedIn Profile :</label>
                    <input type="url" id="linkedin" name="linkedin" class="form-control" placeholder="Enter your LinkedIn profile URL">
                </div>
            </div>

            <!-- Other Competitive Programming Handles -->
            <div class="row my-2">
                <div class="col">
                    <label for="leetcode">LeetCode Handle :</label>
                    <input type="text" id="leetcode" name="leetcode" class="form-control" placeholder="Enter your LeetCode handle">
                </div>
                <div class="col">
                    <label for="gfg">GeeksforGeeks Handle :</label>
                    <input type="text" id="gfg" name="gfg" class="form-control" placeholder="Enter your GFG handle">
                </div>
                <div class="col">
                    <label for="hackerrank">HackerRank Handle :</label>
                    <input type="text" id="hackerrank" name="hackerrank" class="form-control" placeholder="Enter your HackerRank handle">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Register</button>
        </form>
    </div>
    <?php include 'comp/_footer.php'; ?>
</body>
</html>
