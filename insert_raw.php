<?php
include './backend/connect.php';
include './backend/crud_operation.php';
if (isset($_POST["submit"])) {
  $Date = $_POST['Date'];
  $name_supplier = $_POST['name_supplier'];
  $name_material = $_POST['name_material'];
  $van_wise= $_POST['van_wise'];
  $without_van = $_POST['without_van'];
  $weight_material = $_POST['weight_material'];
  $bill_no  = $_POST['bill_no'];
  $total_amount= $_POST['total_amount'];
 $sql = "INSERT INTO raw_material(Date,name_supplier,name_material,van_wise,without_van,weight_material,bill_no,total_amount) 
            VALUES ('$Date','$name_supplier','$name_material', '$van_wise','$without_van','$weight_material','$bill_no','$total_amount')";

    $conn->query($sql);

  }

