<?php
// Database connection (replace with your actual connection details)
include 'comp/_dbconnect.php';

if (!isset($_GET['comp_id'])) {
    echo "
        <script>
            alert('ID of company is not set');
            window.location.href = 'admin_dashboard.php';
        </script>
    ";
    exit();
}

$comp_id = $_GET['comp_id'];

// Query to fetch student details from the 'students' table using 'student_id' from the 'applications' table
$query = "
    SELECT s.fname, s.email, s.phone, s.branch, s.year
    FROM students s 
    INNER JOIN applications a ON s.sno = a.stu_id 
    WHERE a.comp_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $comp_id);
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
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
    <title>Details of Students</title>
</head>
<body>
    <?php include 'comp/_navbar.php'; ?>
    
    <h1>Details of Students for Company ID: <?php echo $comp_id; ?></h1>

    <!-- Table to display student details -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Branch</th>
                <th>Year</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['fname']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['phone']; ?></td>
                        <td><?php echo $student['branch']; ?></td>
                        <td><?php echo $student['year']; ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No students have applied for this company yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Button to download CSV -->
    <form action="download_csv.php" method="GET">
        <input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>">
        <button type="submit">Download CSV</button>
    </form>
</body>
</html>
