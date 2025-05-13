<?php
include_once './backend/connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_coast_row') {
  $id = intval($_POST['Id']);

  if ($id > 0) {
    $sql = "DELETE FROM completed_prod_coast WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "Entry deleted successfully.";
    } else {
      echo "Error deleting entry: " . $conn->error;
    }
  } else {
    echo "Invalid ID.";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_material_row') {
  $id = intval($_POST['Id']);

  if ($id > 0) {
    $sql = "DELETE FROM raw_material WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "Entry deleted successfully.";
    } else {
      echo "Error deleting entry: " . $conn->error;
    }
  } else {
    echo "Invalid ID.";
  }
}
