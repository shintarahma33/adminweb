<?php
require 'function.php';
require 'cek.php';

function queryData($connection, $query)
{
    $executeQuery = mysqli_query($connection, $query);

    if ($executeQuery) {
        header('location:user.php');
    } else {
        echo 'Failed to query data';
    }
}

if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    queryData($conn, "INSERT INTO user (name, email, phone, password, address, role, verified, created_at) VALUES ('$name','$email','$phone','$password','$address','$role','1',NOW())");
} else if (isset($_POST['edit_user'])) {
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    if (empty($password)) {
        queryData($conn, "UPDATE user SET name = '$name', email = '$email', phone = '$phone', address = '$address', role = '$role' WHERE id = '$userId'");
    } else {
        queryData($conn, "UPDATE user SET name = '$name', email = '$email', phone = '$phone', address = '$address', role = '$role', password = '$password' WHERE id = '$userId'");
    }
} else if (isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    queryData($conn, "DELETE FROM user WHERE id = '$userId'");
} else if (isset($_POST['verify_user'])) {
    $userId = $_POST['user_id'];
    queryData($conn, "UPDATE user SET verified = '1', updated_at = NOW() WHERE id = '$userId'");
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
                <div class="sidebar-brand-text mx-3 ">Jglow Tyara Cimahi Tengah </sup>
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
                    <div class="d-sm-flex flex-column align-items-start mb-4 p-3">
                        <h1 class="h3 mb-0 text-gray-800">User</h1>
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
                                            <input type="text" name="name" placeholder="Name" class="form-control" required>
                                            <br>
                                            <input type="email" name="email" placeholder="Email" class="form-control" required>
                                            <br>
                                            <input type="number" name="phone" placeholder="Phone" class="form-control" required>
                                            <br>
                                            <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                                            <br>
                                            <select name="role" class="form-control" required>
                                                <option value="reseller">Reseller</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                            <br>
                                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="add_user">Submit</button>
                                            <br>
                                        </form>
                                    </div>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Point</th>
                                        <th>Role</th>
                                        <th>Verified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getUsers = mysqli_query($conn, "SELECT * FROM user ORDER BY id DESC");
                                    while ($data = mysqli_fetch_array($getUsers)) {
                                        $userId = $data['id'];
                                        $name = $data['name'];
                                        $email = $data['email'];
                                        $phone = $data['phone'];
                                        $address = $data['address'];
                                        $point = $data['point'];
                                        $role = $data['role'];
                                        $verified = $data['verified'];
                                    ?>
                                        <tr>
                                            <td><?= $name; ?></td>
                                            <td><?= $email; ?></td>
                                            <td><?= $phone; ?></td>
                                            <td><?= $point; ?></td>
                                            <td><?= $role; ?></td>
                                            <td><?= $verified ? 'Yes' : 'No'; ?></td>
                                            <td>
                                                <?php
                                                if (!$verified) {
                                                ?>
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#verifyModal<?= $userId; ?>"><i class="fa fa-check" title="Verify"></i></button>
                                                <?php
                                                }
                                                ?>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal<?= $userId; ?>"><i class="fa fa-eye" title="View"></i></button>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $userId; ?>"><i class="fa fa-edit" title="Edit"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $userId; ?>"><i class="fa fa-trash" title="Delete"></i></button>
                                            </td>
                                        </tr>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal<?= $userId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">View User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Add the view details here -->
                                                        <p>Name: <?= $name; ?></p>
                                                        <p>Email: <?= $email; ?></p>
                                                        <p>Phone: <?= $phone; ?></p>
                                                        <p>Address: <?= $address; ?></p>
                                                        <p>Point: <?= $point; ?></p>
                                                        <p>Role: <?= $role; ?></p>
                                                        <p>Verified: <?= $verified ? 'Yes' : 'No'; ?></p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $userId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="user_id" value="<?= $userId; ?>" required>
                                                            <input type="text" name="name" placeholder="Name" class="form-control" value="<?= $name; ?>" required>
                                                            <br>
                                                            <input type="email" name="email" placeholder="Email" class="form-control" value="<?= $email; ?>" required>
                                                            <br>
                                                            <input type="number" name="phone" placeholder="Phone" class="form-control" value="<?= $phone; ?>" required>
                                                            <br>
                                                            <textarea name="address" class="form-control" placeholder="Address" required><?= $address; ?></textarea>
                                                            <br>
                                                            <select name="role" class="form-control" required>
                                                                <option value="reseller" <?= $role == 'reseller' ? 'selected' : ''; ?>>Reseller</option>
                                                                <option value="admin" <?= $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                            </select>
                                                            <br>
                                                            <input type="password" name="password" placeholder="Password" class="form-control">
                                                            <br>
                                                            <button type="submit" class="btn btn-primary" name="edit_user">Submit</button>
                                                            <br>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $userId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this user?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action=""> <!-- Adjust action to your delete script -->
                                                            <input type="hidden" name="user_id" value="<?= $userId; ?>">
                                                            <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="verifyModal<?= $userId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Verify User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to verify this user?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action=""> <!-- Adjust action to your delete script -->
                                                            <input type="hidden" name="user_id" value="<?= $userId; ?>">
                                                            <button type="submit" name="verify_user" class="btn btn-success">Verify</button>
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