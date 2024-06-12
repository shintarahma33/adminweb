<?php
require 'function.php';
require 'cek.php';

if (isset($_POST['delete_item'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM item WHERE id='$id'";
    $delete = mysqli_query($conn, $deleteQuery);

    if ($delete) {
        header('location:index.php');
    } else {
        echo 'Failed to delete item';
    }
}
