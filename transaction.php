<?php
require 'function.php';
require 'cek.php';

function updateStatus($connection, $status)
{
    $transactionId = $_POST['transaction_id'];

    $approveTransaction = mysqli_query($connection, "UPDATE transaction SET status = '$status' WHERE id = '$transactionId'");
    if ($approveTransaction) {
        header('location:transaction.php');
    } else {
        echo 'Failed to update data';
    }
}

if (isset($_POST['approve_transaction'])) {
    updateStatus($conn, 'approved');
} else if (isset($_POST['reject_transaction'])) {
    updateStatus($conn, 'rejected');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jglow Tyara Cimahi Tengah</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3 ">Jglow Tyara Cimahi Tengah</sup>
                </div>

            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Item -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Item</span></a>
            </li>


            <!-- Nav Item - Item Stock Log -->
            <li class="nav-item active">
                <a class="nav-link" href="itemstocklog.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Item Stock Log</span></a>
            </li>

            <!-- Nav Item - Transaction -->
            <li class="nav-item active">
                <a class="nav-link" href="transaction.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Transaction</span></a>
            </li>



            <!-- Nav Item - Katalog Produk -->
            <li class="nav-item active">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>User</span></a>
            </li>

            <!-- Nav Item - Logout -->
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Logout</span></a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="mb-4 p-3">
                    </div>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Sales Result</div>
                                            <?php
                                            $getQuantitySales = mysqli_query($conn, "SELECT transaction_detail.item_id, transaction_detail.quantity, item.reseller_price FROM transaction_detail INNER JOIN transaction ON transaction.id = transaction_detail.transaction_id INNER JOIN item ON item.id = transaction_detail.item_id WHERE transaction.status = 'approved'");
                                            while ($row = mysqli_fetch_array($getQuantitySales)) {
                                                $price[] = ($row['quantity'] * $row['reseller_price']);
                                            }
                                            ?>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp<?= number_format(array_sum($price), 0, ',', '.'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                                    class="fas fa-download fa-sm text-white-50"></i> Download Data</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Proof Payment</th>
                                            <th>Transaction Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getTransactions = mysqli_query($conn, "SELECT transaction.id, user.name, transaction.status, transaction.proof_payment, transaction.created_at FROM transaction INNER JOIN user ON transaction.user_id = user.id ORDER BY transaction.id DESC");
                                        while ($data = mysqli_fetch_array($getTransactions)) {
                                            $transactionId = $data['id'];
                                            $userName = $data['name'];
                                            $status = $data['status'];
                                            $proofPayment = $data['proof_payment'];
                                            $transactionDate = $data['created_at'];
                                        ?>
                                            <tr>
                                                <td><?= $userName; ?></td>
                                                <td>
                                                    <?php
                                                    if ($status == 'approved') {
                                                    ?>
                                                        <span class="btn btn-success"><?= $status; ?></span>
                                                    <?php
                                                    } else if ($status == 'rejected') {
                                                    ?>
                                                        <span class="btn btn-danger"><?= $status; ?></span>
                                                    <?php
                                                    } else if ($status == 'review') {
                                                    ?>
                                                        <span class="btn btn-warning"><?= $status; ?></span>
                                                    <?php
                                                    } else { ?>
                                                        <span class="btn btn-secondary"><?= $status; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($proofPayment)) {
                                                    ?>
                                                        <img src="http://127.0.0.1:8000/<?= $proofPayment; ?>" alt="Proof Payment" width="100" height="100">
                                                    <?php
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $transactionDate; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal<?= $transactionId; ?>"><i class="fa fa-eye"></i></button>
                                                    <!-- View Modal -->
                                                    <div class="modal fade" id="viewModal<?= $transactionId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">View Transaction</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Add the view details here -->
                                                                    <div class="form-group">
                                                                        <label>User Name:</label>
                                                                        <label class="form-control"><?= $userName; ?></label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Transaction Date:</label>
                                                                        <label class="form-control"><?= $transactionDate; ?></label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Status:</label>
                                                                        <label class="form-control"><?= $status; ?></label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Transaction Detail</label>
                                                                        <table class="table-responsive">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Item Name</th>
                                                                                    <th>Quantity</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $number = 1;
                                                                                $getTransactionsDetail = mysqli_query($conn, "SELECT item.name, transaction_detail.quantity FROM transaction_detail INNER JOIN item ON transaction_detail.item_id = item.id WHERE transaction_detail.transaction_id = '$transactionId' ORDER BY transaction_detail.id DESC");
                                                                                while ($data = mysqli_fetch_array($getTransactionsDetail)) {
                                                                                    $itemName = $data['name'];
                                                                                    $quantity = $data['quantity'];
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $number++; ?></td>
                                                                                        <td><?= $itemName; ?></td>
                                                                                        <td><?= $quantity; ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Proof of Payment:</label><br>
                                                                        <label>
                                                                            <?php
                                                                            if (!empty($proofPayment)) {
                                                                            ?>
                                                                                <img src="http://127.0.0.1:8000/<?= $proofPayment; ?>" alt="" width="300" height="300">
                                                                            <?php
                                                                            } else {
                                                                                echo '-';
                                                                            }
                                                                            ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($status != 'approved') {
                                                    ?>
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal<?= $transactionId; ?>"><i class="fa fa-check" title="Approve"></i></button>
                                                        <!-- Approve Modal -->
                                                        <div class="modal fade" id="approveModal<?= $transactionId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Approve Transaction</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to approve this transaction?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post" action="">
                                                                            <input type="hidden" name="transaction_id" value="<?= $transactionId; ?>">
                                                                            <button type="submit" name="approve_transaction" class="btn btn-success">Approve</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php
                                                    if ($status != 'rejected') {
                                                    ?>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal<?= $transactionId; ?>"><i class="fa fa-times" title="Reject"></i></button>
                                                        <!-- Reject Modal -->
                                                        <div class="modal fade" id="rejectModal<?= $transactionId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Reject Transaction</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to reject this transaction?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post" action="">
                                                                            <input type="hidden" name="transaction_id" value="<?= $transactionId; ?>">
                                                                            <button type="submit" name="reject_transaction" class="btn btn-danger">Reject</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>