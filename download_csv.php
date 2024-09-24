<?php
// Database connection (replace with your actual connection details)
include 'comp/_dbconnect.php';

if (!isset($_GET['comp_id'])) {
    echo "Company ID not provided.";
    exit();
}

$comp_id = $_GET['comp_id'];

// Query to fetch student details and generate CSV
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

// Prepare CSV headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students_' . $comp_id . '.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV column headers
fputcsv($output, ['Name', 'Email', 'Phone', 'Branch', 'Year']);

// Write each row of student data to CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);

$stmt->close();
$conn->close();
exit();
?>
