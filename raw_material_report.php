  <?php
  // session_start(); 
  include './backend/auth.php';
  // include './backend/connect.php';
  // include './update_raw.php';

  $total_material_coast = 0;
  $total_rawmaterial_coast = 0;
  $total_transport_coast = 0;

  $all_pay = mysqli_query($conn, "SELECT * FROM `raw_material`");
  $all_pay_row = mysqli_num_rows($all_pay);



  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'Update') {
    $row_id = $_POST['row_id'];
    $entry_date = $_POST['date'];
    $name_supplier = $_POST['name_supplier'];
    $name_material = $_POST['name_material'];
    $van_wise = $_POST['van_wise'];
    $without_van = $_POST['without_van'];
    $weight_material = $_POST['weight_material'];
    $bill_no = $_POST['bill_no'];
    $total_amount = $_POST['total_amount'];

    if (!empty($row_id) && !empty($name_supplier)) {
      $update_sql = "UPDATE raw_material SET 
        entry_date = '$entry_date',
        name_supplier = '$name_supplier',
        name_material = '$name_material',
        van_wise = '$van_wise',
        van_weight = '$without_van',
        material_without_van = '$weight_material',
        bill_no = '$bill_no',
        total_amount = '$total_amount'
        WHERE id = $row_id";

      if ($conn->query($update_sql) === TRUE) {
        $successMessage = "Record updated successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
      } else {
        $errorMessage = "Error updating record: " . $conn->error;
      }
    } else {
      $errorMessage = "Please fill in all required fields.";
      header("Location: " . $_SERVER['PHP_SELF']);
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
        padding: 0 10px;
      }

      form {
        display: block;
        /* padding-top: 10px; */
        /* margin-top: 30px;
        margin-bottom: 30px; */
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
      <?php include('./header.php'); ?>
      <div class="content-wrapper">
        <div class="ndt-header-section m-4">
          <form class="form-horizontal" role="form" name="view_payments" id="view_payments" method="POST" action="raw_material_report.php" enctype="multipart/form-data">
            <div class="form-row">
              <!-- Raw Material Type -->
              <div class="form-group col-md-3">
                <label for="raw_material_type">Raw Material Type</label>
                <select class="form-control" id="raw_material_type" name="raw_material_type">
                  <?php
                  $session_query = "SELECT `raw_material_type` FROM `raw_material`";
                  $session_result = mysqli_query($conn, $session_query) or die(mysqli_error());
                  echo "<option value='All'>All</option>";
                  while ($session_rows = $session_result->fetch_assoc()) {
                    $sessionName = $session_rows['raw_material_type'];
                    echo "<option value='$sessionName'>$sessionName</option>";
                  }
                  ?>
                </select>
                <script>
                  <?php if (isset($_POST['raw_material_type'])) { ?>
                    document.getElementById('raw_material_type').value = "<?php echo $_POST['raw_material_type']; ?>";
                  <?php } ?>
                </script>
              </div>

              <!-- From Date -->
              <div class="form-group col-md-3">
                <label for="from_date">From</label>
                <input type="date" class="form-control" id="from_date" name="from_date" />
                <script>
                  <?php if (isset($_POST['from_date'])) { ?>
                    document.getElementById('from_date').value = "<?php echo $_POST['from_date']; ?>";
                  <?php } ?>
                </script>
              </div>

              <!-- To Date -->
              <div class="form-group col-md-3">
                <label for="to_date">To</label>
                <input type="date" class="form-control" id="to_date" name="to_date" />
                <script>
                  <?php if (isset($_POST['to_date'])) { ?>
                    document.getElementById('to_date').value = "<?php echo $_POST['to_date']; ?>";
                  <?php } ?>
                </script>
              </div>

              <!-- Submit Button -->
              <div class="form-group col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" type="submit" name="checkDateWisePayments" id="checkDateWisePayments">
                  Search
                </button>
              </div>
            </div>
          </form>
        </div>


        <table class="table table-bordered" id="myTable">
          <thead>
            <tr>
            <tr>
              <th>SL.No</th>
              <th>Bill No</th>
              <th>Date</th>
              <th>Name of The Supplier</th>
              <th>Name Of The Material</th>
              <th>Van Wise Material</th>
              <th>Without Van Material</th>

              <th>Transport Charge</th>
              <th>Total Amount Of Material</th>
              <th>Paid</th>
              <th>Dues</th>
              <th>Actions</th>
            </tr>
            </tr>
          </thead>
          <tbody>

            <?php
            if (isset($_POST['checkDateWisePayments'])) {
              $from_date = $_POST['from_date'] ?? '';
              $to_date = $_POST['to_date'] ?? '';
              $raw_material_type = $_POST['raw_material_type'] ?? 'All';

              $query = "SELECT * FROM `raw_material` WHERE 1";

              if ($raw_material_type != 'All') {
                $query .= " AND raw_material_type = '" . mysqli_real_escape_string($conn, $raw_material_type) . "'";
              }

              if (!empty($from_date) && !empty($to_date)) {
                $query .= " AND entry_date BETWEEN '$from_date' AND '$to_date'";
              }

              $result = mysqli_query($conn, $query);
            } else {
              $result = mysqli_query($conn, "SELECT * FROM `raw_material`");
            }
            ?>


            <?php
            // $sql = "SELECT * FROM `raw_material` WHERE 1";
            // $result = $conn->query($sql);
            if ($result != '') {
            ?>
              <?php
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['van_wise']; ?></td>
                  <td><?php echo $row['entry_date']; ?></td>
                  <td><?php echo $row['name_supplier']; ?></td>
                  <td><?php echo $row['name_material']; ?></td>

                  <td><?php echo $row['material_without_van']; ?></td>

                  <td><?php echo $row['bill_no']; ?></td>
                  <td><?php echo $row['transport_charge'];
                      $total_transport_coast += intval($row['transport_charge']);
                      ?></td>
                  <td><?php echo $row['material_amt'];
                      $total_rawmaterial_coast += intval($row['material_amt']);
                      ?></td>
                  <td><?= $row['payment_paid']; ?></td>
                  <td><?= $row['payment_dues']; ?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <form class="delete-form" method="POST" style="display:inline;">
                      <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">
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
                                <label>Weight Of Van</label>
                                <input type="text" class="form-control" name="without_van" value="<?php echo $row['van_weight']; ?>" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Weight Of Material</label>
                                <input type="text" class="form-control" name="weight_material" value="<?php echo $row['material_without_van']; ?>" required>
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
              <?php
              }
              ?>
            <?php } ?>

          </tbody>
          <tfoot>
            <tr style="font-weight: bold; background-color: #f8f9fa; text-align: center;">
              <td colspan="3" style="color: #007bff;">
                Total Purchase Amount: ₹<?php echo number_format($total_rawmaterial_coast, 2); ?>
              </td>
              <td colspan="3" style="color: #28a745;">
                Total Transport Cost: ₹<?php echo number_format($total_transport_coast, 2); ?>
              </td>
              <td colspan="3" style="color: #dc3545;">
                Total Raw Material Cost: ₹<?php echo number_format($total_transport_coast + $total_rawmaterial_coast, 2); ?>
              </td>
            </tr>
          </tfoot>
        </table>

      </div>


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
      $(document).ready(function() {
        // Initialize DataTable with export buttons
        const table = $('#myTable').DataTable({
          dom: 'Bfrtip',
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Edit button click handler
        $('#myTable').on('click', '.editBtn', function() {
          const row = $(this).closest('tr');
          const rowData = table.row(row).data();

          // Simulating new data input
          const newName = prompt("Enter new name:", rowData[1]);
          const newEmail = prompt("Enter new email:", rowData[2]);
          const newPhone = prompt("Enter new phone:", rowData[3]);
          const newAddress = prompt("Enter new address:", rowData[4]);
          const newCity = prompt("Enter new city:", rowData[5]);
          const newCountry = prompt("Enter new country:", rowData[6]);
          const newZip = prompt("Enter new ZIP:", rowData[7]);

          if (newName && newEmail && newPhone && newAddress && newCity && newCountry && newZip) {
            table.row(row).data([rowData[0], newName, newEmail, newPhone, newAddress, newCity, newCountry, newZip, rowData[8]]).draw();
          }
        });

        // Delete button click handler
        $('#myTable').on('click', '.deleteBtn', function() {
          const row = $(this).closest('tr');
          table.row(row).remove().draw();
        });
      });
    </script>
    <script>
      $(function() {
        $('#raw_material').submit()
      })




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
              $('#error_section').html('<div class="alert alert-success">' + response + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            },
            error: function() {
              $('#error_section').html('<div class="alert alert-danger">Error occurred while deleting.  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
          });
        });
      });
    </script>

  </body>

  </html>
  <?php
  //  include('tracker.php');
  // include('footer.php');

  ?>