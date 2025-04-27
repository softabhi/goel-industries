<?php
include './backend/connect.php'; // Make sure $conn is initialized here

// Enable error reporting (for development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    print_r($_POST);


    $id = isset($_POST['Id']) ? intval($_POST['Id']) : 0;
    $entry_date = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
    $name_supplier = mysqli_real_escape_string($conn, $_POST['name_supplier'] ?? '');
    $name_material = mysqli_real_escape_string($conn, $_POST['name_material'] ?? '');
    $van_wise = mysqli_real_escape_string($conn, $_POST['van_wise'] ?? '');
    $without_van = mysqli_real_escape_string($conn, $_POST['without_van'] ?? '');
    $weight_material = mysqli_real_escape_string($conn, $_POST['weight_material'] ?? '');
    $bill_no = mysqli_real_escape_string($conn, $_POST['bill_no'] ?? '');
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount'] ?? '');
       echo $id;
       echo $entry_date;
       echo $name_supplier;
       exit;
    // Check for required fields
    if ($id > 0 && $entry_date && $name_supplier) {
        $sql = "UPDATE raw_material SET 
                    entry_date = '$entry_date',
                    name_supplier = '$name_supplier',
                    name_material = '$name_material',
                    van_wise = '$van_wise',
                    without_van = '$without_van',
                    weight_material = '$weight_material',
                    bill_no = '$bill_no',
                    total_amount = '$total_amount'
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Updated successfully.";
        } else {
            http_response_code(500);
            echo "Error updating record: " . $conn->error;
        }
    } else {
        http_response_code(400);
        echo "Invalid input. Please fill all required fields.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}

exit;
?>
