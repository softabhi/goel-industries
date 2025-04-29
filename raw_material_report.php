<?php
// session_start(); 
include './backend/auth.php';
include './backend/connect.php';
include './update_raw.php';

$all_pay = mysqli_query($conn, "SELECT * FROM `raw_material`");
$all_pay_row = mysqli_num_rows($all_pay);

// $find_TotalAmount_result = mysqli_query($conn, "SELECT sum(amount) as Total_Amount from `raw_material`");
// $find_TotalAmount_row = mysqli_fetch_array($find_TotalAmount_result, MYSQLI_ASSOC);
// $TotalAmount = $find_TotalAmount_row['Total_Amount'];


// if(isset($_POST['btn_verification'])){

// $name=$_POST['stu_name'];
// $pay_type=$_POST['pay_type'];
// $email=$_POST['email'];
// $txid=$_POST['txid'];
// $studentId=$_POST['student_id'];
// $buyNow_id = $_POST['buyNow_id'];
// $status= '1';


//  $btn_approve = $_POST['btn_verification'];
//  $action = $txid.''. $btn_approve;

//     $sql = "UPDATE raw_material SET txid='$txid',status='$status' WHERE id=$buyNow_id AND pay_type='$pay_type'";
//     if(mysqli_query($conn,$sql))
//                 {
//                     $update_success = "Application No : ".$studentId." is verified with transactionId : ".$txid;

//                             $to=$email;
//                 		    $subject='Registration';
//                 		    $message="Dear ".$name."\n"."We have received your payment, now you can download your prospectus and fill your admission form"."\n"."\n"."\n"."\n"."Thanks & Regards"."\n"."Jamshedpur Womens College";


//                             $headers = "From: no-reply@jsrwomensintercollege.in";
//                               mail($to, $subject, $message, $headers);

//                     header("Location: view_payments.php?update_success=".$update_success);

//                 }
//             else
//                 {
//                     $error_update_success="Something went wrong,correct your input & then try again.";
//                     header("Location: payment.php?error_update_success=".$error_update_success);
//                 }

// }
//   if(isset($_GET['edit_success']))
//     {
//         $edit_success = $_GET['edit_success'];

//     }
//  if(isset($_GET['user_id']))
// if (isset($_GET['user_id']) || ($_GET['edit_success'])) {
//     $user_id = $_GET['user_id'];
//     $edit_success = $_GET['edit_success'];
// }

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
  <?php include('./header.php'); ?>


  <div class="content-wrapper">
    <form class="form-horizontal" role="form" name="view_payments" id="view_payments" method="POST" action="raw_material_report.php" enctype="multipart/form-data">


      <div class="form-group row">
        <div class="col-md-2">
          <label>Raw Material Type</label>

          <select class="form-control" id="raw_material_type" name="raw_material_type">

            <?php
            $session_query = "SELECT `raw_material_type` FROM `raw_material`";
            $session_result = mysqli_query($conn, $session_query) or die(mysqli_error());
            echo "<option  value='All'>All</option>";
            while ($session_rows = $session_result->fetch_assoc()) {
              $sessionName = $session_rows['raw_material_type'];
              echo "<option  value='$sessionName'>$sessionName</option>";
            }
            ?>
          </select>
          <script type="text/javascript">
            <?php
            if (isset($_POST['raw_material_type'])) {
            ?>
              document.getElementById('raw_material_type').value = "<?php echo $_POST['raw_material_type']; ?>";
            <?php }
            ?>
          </script>

        </div>

        <div class="col-md-3">
          <label class=" control-label col-form-label">From</label>

          <input type="date" class="form-control" id="from_date" name="from_date" />
          <script type="text/javascript">
            <?php
            if (isset($_POST['from_date'])) {
            ?>
              document.getElementById('from_date').value = "<?php echo $_POST['from_date']; ?>";
            <?php } else {
            ?>
              document.getElementById('from_date').value = "";
            <?php } ?>
          </script>
        </div>

        <div class="col-md-3">
          <label class=" control-label col-form-label">To</label>

          <input type="date" class="form-control" id="to_date" name="to_date" />
          <script type="text/javascript">
            <?php
            if (isset($_POST['to_date'])) {
            ?>
              document.getElementById('to_date').value = "<?php echo $_POST['to_date']; ?>";
            <?php } else {
            ?>
              document.getElementById('to_date').value = "";
            <?php } ?>
          </script>
        </div>
        <div class="col-md-2 text-right">
          <button style="position: relative;bottom: -32px;left: -22px;" class="btn btn-primary" type="submit" name="checkDateWisePayments" id="checkDateWisePayments" class="">Search</button>
        </div>
    </form>


    <table class="table table-bordered" id="myTable">
      <thead>
        <tr>
          <th>SL.No</th>
          <th>Date</th>
          <th>Name of The Supplier</th>
          <th>Name Of The Material</th>
          <th>Van Wise Material</th>
          <th>Without Van Material</th>
          <th>Weight Of Material</th>
          <th>Bill No</th>
          <th>Total Amount Of Material</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php
        if (isset($_POST['checkDateWisePayments'])) {
          $from_date = $_POST['from_date'];
          $to_date = $_POST['to_date'];
          $raw_material_type = $_POST['raw_material_type'];
          // $session = $_POST['session'];
          if (($from_date != '') && ($to_date != '')) {



            if ($raw_material_type == 'All') {
              $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
            
            } else {
              $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
            }
          } else {
            if (($raw_material_type != 'All')) {

              $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE  `raw_material_type`='$raw_material_type'");
              // } else if ($course != 'All') {
              //   $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
              // } else if ($session != 'All') {
              //   $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
              // } else {
              //   $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
              // }
            }
          }
        } else {
          $result = mysqli_query($conn, "SELECT * FROM `raw_material` WHERE 1");
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
              <td><?php echo $row['entry_date']; ?></td>
              <td><?php echo $row['name_supplier']; ?></td>
              <td><?php echo $row['name_material']; ?></td>
              <td><?php echo $row['van_wise']; ?></td>
              <td><?php echo $row['without_van']; ?></td>
              <td><?php echo $row['weight_material']; ?></td>
              <td><?php echo $row['bill_no']; ?></td>
              <td><?php echo $row['total_amount']; ?></td>
              <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <form action="" method="POST" style="display:inline;">
                  <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php
          }
          ?>
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
                  <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="Id" value="<?php echo $row['id']; ?>">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date</label>
                          <input type="text" class="form-control" name="Date" value="<?php echo $row['Date']; ?>" required>
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
                      <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>
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
  </script>

</body>

</html>
<?php
//  include('tracker.php');
// include('footer.php');

?>