<?php
include './backend/auth.php';
ini_set('display_errors', 1);
// error_reporting(E_ALL);

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'Insert') {

  $start_date = $_POST['start_date'];
  $finish_date = $_POST['finish_date'];
  $total_days = $_POST['total_days'];
  $product_name = $_POST['created_produ_name'];
  $totalman_total = $_POST['totalman_total'];
  $manpower_coast = $_POST['manpower_coast'];
  $raw_type = $_POST['raw_type'];
  $weightof_material = $_POST['weightof_material'];
  $amountof_material = $_POST['amountof_material'];
  $overhead_coast = $_POST['overhead_coast'];
  $other_coast = $_POST['other_coast'];
  $total_amount = $_POST['total_amount'];

  if (!empty($start_date) && !empty($finish_date) && !empty($raw_type)) {
    $sql = "INSERT INTO completed_prod_coast(
        entry_date,
        finish_date,
        product_name,
        total_days,
        raw_material_type,
        manpower_coast,
        totalman_total,
        weightof_material,
        amountof_material,
        overhead_coast,
        other_coast,
        total_amount
      ) VALUES (
        '$start_date',
        '$finish_date',
        '$product_name',
        '$total_days',
        '$raw_type',
        '$manpower_coast',
        '$totalman_total',
        '$weightof_material',
        '$amountof_material',
        '$overhead_coast',
        '$other_coast',
        '$total_amount'
      )";

    if ($conn->query($sql) === TRUE) {

      $current_stock = mysqli_query($conn, "SELECT * from raw_material where raw_material_type='$raw_type'");
      $stock = mysqli_fetch_assoc($current_stock);
      // $stock = $current_stock->fetch_assoc();
      $total_stock = $stock['material_without_van'];
      $available_stock = $stock['available_stock'];
      // print_r($current_stock);


      if ($available_stock > 0) {
        $new_stock = $available_stock - $weightof_material;
      } else {
        $new_stock = $total_stock - $weightof_material;
      }

      // Use prepared statement for security
      $stmt = $conn->prepare("UPDATE raw_material SET available_stock = ? WHERE raw_material_type = ?");
      $stmt->bind_param("ds", $new_stock, $raw_type); // d = double/float, s = string
      $stmt->execute();


      // echo $stmt;
      print_r($stmt);
      $stmt->close();

      if ($stmt) {
        // exit;
        $_SESSION['submitted'] = true;
        $successMessage = "Form submitted successfully!";
      }

      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      $errorMessage = "Error: " . $conn->error;
    }
  } else {
    $errorMessage = "Please fill in all required fields.";
    header("Location: product_coast.php" . $_SERVER['PHP_SELF']);
    exit();
  }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'Update') {
  $row_id = $_POST['row_id'];
  $start_date = $_POST['start_date'];
  $finish_date = $_POST['finish_date'];
  $totalman_total = $_POST['totalman_total'];
  $manpower_coast = $_POST['manpower_coast'];
  $raw_type = $_POST['raw_type'];
  $weightof_material = $_POST['weightof_material'];
  $amountof_material = $_POST['amountof_material'];
  $other_coast = $_POST['other_coast'];
  $total_amount = $_POST['total_amount'];

  if (!empty($row_id) && !empty($start_date) && !empty($raw_type)) {
    $update_sql = "UPDATE raw_material SET 
      entry_date = '$start_date',
      name_material = '$raw_type',
      raw_material_type = '$raw_type',
      van_wise = '$manpower_coast',
      without_van = '$totalman_total',
      weight_material = '$weightof_material',
      bill_no = '$other_coast',
      total_amount = '$total_amount'
      WHERE id = $row_id";

    if ($conn->query($update_sql) === TRUE) {

      $successMessage = "Record updated successfully!";
      header("Location: product_coast.php" . $_SERVER['PHP_SELF']);
      exit();
    } else {
      $errorMessage = "Error updating record: " . $conn->error;
    }
  } else {
    $errorMessage = "Please fill in all required fields.";
    header("Location: product_coast.php" . $_SERVER['PHP_SELF']);
    exit();
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="./src/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .content-wrapper {
      /* background-color: #fff; */
    }

    .content-wrapper {
      background-color: #fff;
    }

    form {
      display: block;
      padding-top: 10px;
      margin-top: 30px;
      margin-bottom: 30px;
      border-radius: 10px;
      background-color: rgb(235 235 235);
    }

    .form-row {
      padding: 20px;
      margin: 20px;
    }

    .form-button {
      margin: 30px;
    }

    #myTable_wrapper {
      padding: 10px 15px;
    }

    .dt-buttons {
      margin: 15px 0px;
    }

    .form-inline {
      background: #fff;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include './header.php'; ?>
    <div class="content-wrapper">
      <section class="content">

        <!-- Show success or error messages -->
        <?php
        // if (!empty($successMessage)) {
        //   echo "<h4 style='color: green;'>$successMessage</h4>";
        // }

        // if (!empty($errorMessage)) {
        //   echo "<h4 style='color: red;'>$errorMessage</h4>";
        // }
        ?>


        <?php if (!empty($successMessage)) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php endif; ?>

        <div class="col-md-12" id="error_section"></div>
        <div class="container-fluid">
          <form action="" method="POST" class="p-4 bg-light rounded shadow-sm">
            <div class="row">
              <div class="form-group col-md-3">
                <label for="start_date">Product Create Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
              </div>
              <div class="form-group col-md-3">
                <label for="finish_date">Product Completion Date</label>
                <input type="date" class="form-control" id="finish_date" name="finish_date" onchange="totalDayCount()">
              </div>
              <div class="form-group col-md-2">
                <label for="totalman_total">Total Days</label>
                <input type="number" class="form-control" id="total_days" name="total_days" placeholder="days">
              </div>


              <div class="form-group col-md-2">
                <label for="totalman_total"> No. of Manpower Used</label>
                <input type="number" class="form-control" id="totalman_total" name="totalman_total" placeholder="e.g. 15">
              </div>
              <div class="form-group col-md-2">
                <label for="manpower_coast">Direct Labour Cost</label>
                <input type="number" step="0.01" class="form-control" id="manpower_coast" name="manpower_coast" placeholder="e.g. 12000">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-3">
                <label for="raw_type">Raw Material Type</label>
                <select class="form-control" id="raw_type" name="raw_type" required>
                  <option value="">Select Material</option>
                  <option value="Building Structure">Building Structure</option>
                  <option value="Iron sheet">Iron sheet</option>
                  <option value="Duct">Iron Angles</option>
                  <option value="Pipes">Pipes</option>
                  <option value="Filtters">Filtters</option>
                  <option value="Hopper">Hopper</option>
                  <option value="Others">Others</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="weightof_material">Created Product Name</label>
                <input type="text" step="0.01" class="form-control" id="created_produ_name" name="created_produ_name">
              </div>
              <div class="form-group col-md-3">
                <label for="weightof_material">Total Weight of Material Used (kg)</label>
                <input type="number" step="0.01" class="form-control" id="weightof_material" name="weightof_material">
              </div>
              <div class="form-group col-md-3">
                <label for="amountof_material">Direct Material Coast (₹)</label>
                <input type="number" step="0.01" class="form-control" id="amountof_material" name="amountof_material" onkeyup="totalOfProduct()">
              </div>
            </div>


            <div class="row">
              <div class="form-group col-md-2">
                <label for="other_coast">Overhead Coast (₹)</label>
                <input type="number" step="0.01" class="form-control" id="overhead_coast" name="overhead_coast" onkeyup="totalOfProduct()">
              </div>
              <div class="form-group col-md-2">
                <label for="other_coast">Other Costs (₹)</label>
                <input type="number" step="0.01" class="form-control" id="other_coast" name="other_coast" onkeyup="totalOfProduct()">
              </div>
              <div class="form-group col-md-4">
                <label for="total_amount">Total Manufacturing Cost ( )</label>
                <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" required>
              </div>
            </div>

            <script>
              function totalOfProduct() {
                var manpower_coast = Number(document.getElementById('manpower_coast').value);
                var other_coast = Number(document.getElementById('other_coast').value);
                var amountof_material = Number(document.getElementById('amountof_material').value);
                var overhead_coast = Number(document.getElementById('overhead_coast').value);

                document.getElementById('total_amount').value = manpower_coast + amountof_material + other_coast + overhead_coast;
              }
            </script>
            <!-- Hidden Field -->
            <input type="hidden" name="action" value="Insert">

            <div class="text-right mt-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </section>

      <table class="table table-bordered" id="myTable">
        <thead>
          <tr>
            <th>SL.No</th>
            <th>Product Start Date</th>
            <th>Product Name</th>
            <th>Raw Material Used</th>
            <th>Raw Material Weight</th>

            <th>Weight Of Product</th>
            <th>Total Completion Day</th>
            <th>Total Manpower Used</th>
            <th>Manpower Coast</th>
            <th>Other Coast</th>
            <th>Total Amount Of Product</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `completed_prod_coast` WHERE 1";
          $result = $conn->query($sql);

          while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['entry_date']; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['raw_material_type']; ?></td>
              <td><?php echo $row['weightof_material']; ?></td>
              <td><?php echo $row['weightof_material']; ?></td>
              <td><?php echo $row['total_days']; ?></td>
              <td><?php echo $row['totalman_total']; ?></td>
              <td><?php echo $row['manpower_coast']; ?></td>
              <td><?php echo $row['other_coast']; ?></td>
              <td><?php echo $row['total_amount']; ?></td>
              <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <!-- <form action="" id="Id" role="form" method="POST" style="display:inline;">
                  <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">
                  <button type="button" name="delete" id="delete" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form> -->

                <form class="delete-form" method="POST" style="display:inline;">
                  <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">
                  <input type="hidden" name="action" value="delete_coast_row">
                  <button type="button" class="btn btn-danger btn-sm delete-btn">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>

              </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="" class="update-form" method="POST" enctype="multipart/form-data">
                      <!-- <input type="hidden" name="row_id" value="<?php echo $row['id']; ?>"> -->

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" value="<?php echo $row['entry_date']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name Of The Supplier</label>
                            <input type="text" class="form-control" name="name_supplier" value="<?php echo $row['name_supplier']; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name Of The Material</label>
                            <input type="text" class="form-control" name="name_material" value="<?php echo $row['name_material']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Van wise Material</label>
                            <input type="text" class="form-control" name="van_wise" value="<?php echo $row['van_wise']; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Without Van Material</label>
                            <input type="text" class="form-control" name="without_van" value="<?php echo $row['without_van']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Weight Of Material</label>
                            <input type="text" class="form-control" name="weight_material" value="<?php echo $row['weight_material']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Bill No</label>
                            <input type="text" class="form-control" name="bill_no" value="<?php echo $row['bill_no']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Total Amount Of Material</label>
                            <input type="text" class="form-control" name="total_amount" value="<?php echo $row['total_amount']; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="button" name="submit" class="btn btn-primary btn-update">Update</button> -->
                        <input type="hidden" name="action" value="Update">
                        <input type="hidden" name="row_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="form_update" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </tbody>
      </table>


      <?php include './footer.php'; ?>
    </div>

    <!-- JS Dependencies -->
    <script src="./src/js/jquery.min.js"></script>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


    <script>
      function totalDayCount() {
        // Get the values from input fields
        var stDate = document.getElementById('start_date').value;
        var ctDate = document.getElementById('finish_date').value;
        console.log(stDate);
        // Convert the date strings into Date objects
        var startDate = new Date(stDate);
        var finishDate = new Date(ctDate);
        var today = new Date();

        console.log(startDate);
        // Clear the time portion for accurate day difference
        startDate.setHours(0, 0, 0, 0);
        finishDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        // Calculate total days between start and finish date
        var totalDays = Math.round((finishDate - startDate) / (1000 * 60 * 60 * 24));

        // Calculate days from today to finish date
        var daysFromToday = Math.round((finishDate - today) / (1000 * 60 * 60 * 24));

        // Output results
        console.log("Total days from start to finish:", totalDays);
        console.log("Days remaining from today to finish:", daysFromToday);

        // Optional: display the result in the HTML
        document.getElementById('total_days').value = totalDays;
        // document.getElementById('days_from_today_output').innerText = "From today: " + daysFromToday;
      }
    </script>


    <script>
      $(document).ready(function() {
        // Initialize DataTable with export buttons
        const table = $('#myTable').DataTable({
          dom: 'Bfrtip',
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Edit button click handler

        // $('#myTable').on('click', '.editBtn', function() {
        //   const row = $(this).closest('tr');
        //   const rowData = table.row(row).data();

        //   // Simulating new data input
        //   const newName = prompt("Enter new name:", rowData[1]);
        //   const newEmail = prompt("Enter new email:", rowData[2]);
        //   const newPhone = prompt("Enter new phone:", rowData[3]);
        //   const newAddress = prompt("Enter new address:", rowData[4]);
        //   const newCity = prompt("Enter new city:", rowData[5]);
        //   const newCountry = prompt("Enter new country:", rowData[6]);
        //   const newZip = prompt("Enter new ZIP:", rowData[7]);

        //   if (newName && newEmail && newPhone && newAddress && newCity && newCountry && newZip) {
        //     table.row(row).data([rowData[0], newName, newEmail, newPhone, newAddress, newCity, newCountry, newZip, rowData[8]]).draw();
        //   }
        // });

        // Delete button click handler
        // $('#myTable').on('click', '.deleteBtn', function() {
        //   const row = $(this).closest('tr');
        //   table.row(row).remove().draw();
        // });
      });
    </script>



    <script>
      $(document).ready(function() {
        $('.delete-btn').click(function(e) {
          e.preventDefault();

          if (!confirm("Are you sure you want to delete this entry?")) return;

          const form = $(this).closest('.delete-form');
          const formData = form.serialize();

          $.ajax({
            url: 'delete_raw.php',
            type: 'POST',
            data: formData,
            success: function(response) {
              // Optionally remove the row or reload the page
              form.closest('tr').remove();
              $('#error_section').html('<div class="alert alert-success">' + response + '<button type="button" class="close" data-dismiss="alert">&times;</button> </div>');
            },
            error: function() {
              $('#error_section').html('<div class="alert alert-danger">Error occurred while deleting. <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
          });
        });
      });
    </script>


</body>

</html>