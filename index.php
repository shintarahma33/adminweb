<?php
require 'function.php';
require 'cek.php';

function insertImage($connection, $images, $itemId)
{
    // Handle image uploads
    $targetDir = "uploads/";

    foreach ($images['name'] as $key => $val) {

        $basenameImage = basename($images['name'][$key]);
        $imageType = strtolower(pathinfo($basenameImage, PATHINFO_EXTENSION));
        $imageName = date("YmdHis") . $key . '.' . $imageType;
        $targetFilePath = $targetDir . $imageName;
        move_uploaded_file($images['tmp_name'][$key], $targetFilePath);

        $insertImages = mysqli_query($connection, "INSERT INTO item_photo (item_id, photo, created_at) VALUES ('$itemId','$imageName',NOW())");

        if ($insertImages) {
            header('location:index.php');
        } else {
            echo 'Failed to update data';
        }
    }
}

//menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $point = $_POST['point'];
    $normal_price = $_POST['normal_price'];
    $reseller_price = $_POST['reseller_price'];
    $images = $_FILES['images'];

    $insertdata = mysqli_query($conn, "INSERT INTO item (name, description, quantity, point, normal_price, reseller_price, created_at) VALUES ('$name','$description','$quantity','$point','$normal_price','$reseller_price', NOW())");
    if ($insertdata) {
        $lastItemId = $conn->insert_id;

        if ($images['name'][0] != null) {
            insertImage($conn, $images, $lastItemId);
        }
    } else {
        echo 'Failed to insert data into the database';
    }
} else if (isset($_POST['edit_item'])) {
    $itemId = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $point = $_POST['point'];
    $normal_price = $_POST['normal_price'];
    $reseller_price = $_POST['reseller_price'];
    $images = $_FILES['images'];

    $updateData = mysqli_query($conn, "UPDATE item SET name = '$name', description = '$description', quantity = '$quantity', point = '$point', normal_price = '$normal_price', reseller_price = '$reseller_price' WHERE id = '$itemId'");

    if ($updateData) {

        if ($images['name'][0] != null) {
            $getImage = mysqli_query($conn, "SELECT photo FROM item_photo WHERE item_id = '$itemId'");

            while ($row = mysqli_fetch_array($getImage)) {
                unlink('uploads/' . $row[0]);
                $deleteImage = mysqli_query($conn, "DELETE FROM item_photo WHERE item_id = '$itemId'");

                if (!$deleteImage) {
                    echo 'Failed to delete item photo';
                }
            }

            insertImage($conn, $images, $itemId);
        } else {
            header('location:index.php');
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
                <div class="sidebar-brand-text mx-3 ">Agen Jglow Tyara Cimahi Tengah
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Item -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Item</span>
                </a>
            </li>


            <!-- Nav Item - Item Stock Log -->
            <li class="nav-item active">
                <a class="nav-link" href="itemstocklog.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Item Stock Log</span>
                </a>
            </li>

            <!-- Nav Item - Transaction -->
            <li class="nav-item active">
                <a class="nav-link" href="transaction.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Transaction</span>
                </a>
            </li>

            <!-- Nav Item - Katalog Produk -->
            <li class="nav-item active">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>User</span>
                </a>
            </li>

            <!-- Nav Item - Logout -->
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Logout</span>
                </a>
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
                        <h1 class="h3 mb-0 text-gray-800">Item</h1>
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Data</button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Item</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" enctype="multipart/form-data" action="">
                                            <input type="text" name="name" placeholder="Name" class="form-control" required>
                                            <br>
                                            <textarea name="description" placeholder="Description" class="form-control" required></textarea>
                                            <br>
                                            <input type="number" name="quantity" placeholder="Quantity" class="form-control" required>
                                            <br>
                                            <input type="number" name="point" placeholder="Point" class="form-control" required>
                                            <br>
                                            <input type="number" name="normal_price" placeholder="Normal Price" class="form-control" required>
                                            <br>
                                            <input type="number" name="reseller_price" placeholder="Reseller Price" class="form-control" required>
                                            <br>
                                            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- Content Row -->
                        <div class=" row">

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

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Point</th>
                                                <th>Normal Price</th>
                                                <th>Reseller Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1; // Initialize $i before the loop
                                            $ambilsemuadataitem = mysqli_query($conn, "select * from item");
                                            while ($data = mysqli_fetch_array($ambilsemuadataitem)) {
                                                $name = $data['name'];
                                                $description = $data['description'];
                                                $quantity = $data['quantity'];
                                                $point = $data['point'];
                                                $normal_price = $data['normal_price'];
                                                $reseller_price = $data['reseller_price'];
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $name; ?></td>
                                                    <td><?= $description; ?></td>
                                                    <td><?= $quantity; ?></td>
                                                    <td><?= $point; ?></td>
                                                    <td><?= $normal_price; ?></td>
                                                    <td><?= $reseller_price; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal<?= $data['id']; ?>">View</button>
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $data['id']; ?>">Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $data['id']; ?>">Delete</button>
                                                    </td>
                                                </tr>

                                                <!-- View Modal -->
                                                <div class="modal fade" id="viewModal<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">View Item</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Add the view details here -->
                                                                <p>Name: <?= $name; ?></p>
                                                                <p>Description: <?= $description; ?></p>
                                                                <p>Quantity: <?= $quantity; ?></p>
                                                                <p>Point: <?= $point; ?></p>
                                                                <p>Normal Price: <?= $normal_price; ?></p>
                                                                <p>Reseller Price: <?= $reseller_price; ?></p>
                                                                <p>Photo:</p>
                                                                <?php
                                                                $getImageFromItem = mysqli_query($conn, "SELECT * FROM item_photo WHERE item_id = " . $data['id']);
                                                                while ($image = mysqli_fetch_array($getImageFromItem)) {
                                                                ?>
                                                                    <img src="uploads/<?= $image['photo']; ?>" alt="" width="100" height="100">
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="" enctype="multipart/form-data"> <!-- Adjust action to your edit script -->
                                                                    <input type="hidden" name="item_id" value="<?= $data['id']; ?>">
                                                                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?= $name; ?>" required>
                                                                    <br>
                                                                    <textarea name="description" placeholder="Description" class="form-control"><?= $description; ?></textarea>
                                                                    <br>
                                                                    <input type="number" name="quantity" placeholder="Quantity" class="form-control" value="<?= $quantity; ?>" required>
                                                                    <br>
                                                                    <input type="number" name="point" placeholder="Point" class="form-control" value="<?= $point; ?>" required>
                                                                    <br>
                                                                    <input type="number" name="normal_price" placeholder="Normal Price" class="form-control" value="<?= $normal_price; ?>" required>
                                                                    <br>
                                                                    <input type="number" name="reseller_price" placeholder="Reseller Price" class="form-control" value="<?= $reseller_price; ?>" required>
                                                                    <br>
                                                                    <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                                                                    <br>
                                                                    <button type="submit" class="btn btn-primary" name="edit_item">Save changes</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                <form method="post" action="deleteitem.php"> <!-- Adjust action to your delete script -->
                                                                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                                    <button type="submit" name="delete_item" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Main Content -->
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->
        </div>
    </div>

</body>

</html>