<?php
require 'function.php';
require 'cek.php';

if (isset($_POST['add_stock'])) {
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $insertData = mysqli_query($conn, "INSERT INTO item_stock_log (item_id, quantity, created_at) VALUES ('$itemId','$quantity',NOW())");

    if ($insertData) {
        $getItemStock = mysqli_query($conn, "SELECT * FROM item WHERE id = '$itemId'");
        $currentItemStock = mysqli_fetch_array($getItemStock)['quantity'];
        $newItemStock = $currentItemStock + $quantity;

        $updateItemStock = mysqli_query($conn, "UPDATE item SET quantity = '$newItemStock' WHERE id = '$itemId'");

        if ($updateItemStock) {
            header('location:itemstocklog.php');
        } else {
            echo 'Failed to update data';
        }
    } else {
        echo 'Failed to insert data';
    }
} else if (isset($_POST['edit_stock'])) {
    $itemId = $_POST['item_id'];
    $stockId = $_POST['stock_id'];
    $currentStock = $_POST['current_stock'];
    $quantity = $_POST['quantity'];

    $getItemStock = mysqli_query($conn, "SELECT * FROM item WHERE id = '$itemId'");
    $currentItemStock = mysqli_fetch_array($getItemStock)['quantity'];

    $newItemStock = ($currentItemStock - $currentStock) + $quantity;

    $updateStock = mysqli_query($conn, "UPDATE item_stock_log SET quantity = '$quantity' WHERE id = '$stockId'");

    if ($updateStock) {

        $updateItemStock = mysqli_query($conn, "UPDATE item SET quantity = '$newItemStock' WHERE id = '$itemId'");

        if ($updateItemStock) {
            header('location:itemstocklog.php');
        } else {
            echo 'Failed to update data';
        }
    }
} else if (isset($_POST['delete_stock'])) {
    $itemId = $_POST['item_id'];
    $stockId = $_POST['stock_id'];
    $currentStock = $_POST['current_stock'];

    $getItemStock = mysqli_query($conn, "SELECT * FROM item WHERE id = '$itemId'");
    $currentItemStock = mysqli_fetch_array($getItemStock)['quantity'];

    $newItemStock = $currentItemStock - $currentStock;

    $updateItemStock = mysqli_query($conn, "UPDATE item SET quantity = '$newItemStock' WHERE id = '$itemId'");

    if ($updateItemStock) {
        $deleteStockLog = mysqli_query($conn, "DELETE FROM item_stock_log WHERE id = '$stockId'");

        if ($deleteStockLog) {
            header('location:itemstocklog.php');
        } else {
            echo 'Failed to delete data';
        }
    } else {
        echo 'Failed to update data';
    }
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

    <title>Agen Jglow Tyara Cimahi Tengah</title>

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
                <div class="sidebar-brand-text mx-3 ">Agen Jglow Tyara Cimahi Tengah</sup>
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column align-items-start mb-4 p-3">
                        <h1 class="h3 mb-0 text-gray-800">Item Stock Log</h1>

                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Data</button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <select class="form-control" name="item_id">
                                                <?php
                                                $getItems = mysqli_query($conn, "SELECT * FROM item");
                                                while ($data = mysqli_fetch_array($getItems)) {
                                                ?>
                                                    <option value="<?= $data['id']; ?>"><?= $data['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select> <br>
                                            <input type="number" name="quantity" placeholder="Quantity" class="form-control" required>
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="add_stock">Submit</button>
                                            <br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                            <th>Name Product</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getItemStockLog = mysqli_query($conn, "SELECT item.id AS item_id, item_stock_log.id AS stock_id, item.name, item_stock_log.quantity FROM item_stock_log INNER JOIN item ON item_stock_log.item_id = item.id ORDER BY item_stock_log.id DESC");
                                        while ($data = mysqli_fetch_array($getItemStockLog)) {
                                            $itemId = $data['item_id'];
                                            $stockId = $data['stock_id'];
                                            $name = $data['name'];
                                            $quantity = $data['quantity'];
                                        ?>
                                            <tr>
                                                <td><?= $name; ?></td>
                                                <td><?= $quantity; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $stockId; ?>"><i class="fa fa-edit"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $stockId; ?>"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editModal<?= $stockId ?>" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="stock_id" value="<?= $stockId; ?>">
                                                                <input type="hidden" name="current_stock" value="<?= $quantity; ?>">
                                                                <select class="form-control" name="item_id" disabled>
                                                                    <?php
                                                                    $getItems = mysqli_query($conn, "SELECT * FROM item");
                                                                    while ($dataItem = mysqli_fetch_array($getItems)) {
                                                                    ?>
                                                                        <option value="<?= $dataItem['id']; ?>" <?= $itemId === $dataItem['id'] ? 'selected' : '' ?>><?= $dataItem['name']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select> <br>
                                                                <input type="number" name="quantity" placeholder="Quantity" class="form-control" value="<?= $quantity; ?>" required>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary" name="edit_stock">Submit</button>
                                                                <br>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal<?= $stockId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this item?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post" action=""> <!-- Adjust action to your delete script -->
                                                                <input type="hidden" name="stock_id" value="<?= $stockId; ?>">
                                                                <input type="hidden" name="current_stock" value="<?= $quantity; ?>">
                                                                <input type="hidden" name="item_id" value="<?= $itemId; ?>">
                                                                <button type="submit" name="delete_stock" class="btn btn-danger">Delete</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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