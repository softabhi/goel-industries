<?php
include './backend/auth.php';
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// include './insert_raw.php';
// include './update_raw.php';
// include './delete_raw.php';

// exit;
$successMessage = '';
$errorMessage = '';
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
            /* padding-top: 10px;
      margin-top: 30px;
      margin-bottom: 30px;
      border-radius: 10px; */
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
        <div class="content-wrapper p-3">
            <div class="ndt-header-section mb-4">
                <section class="content">

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
            </div>
        </div>
        <?php include './footer.php'; ?>
</body>

</html>