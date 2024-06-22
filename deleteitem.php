<?php
require 'function.php';
require 'cek.php';

if (isset($_POST['delete_item'])) {
    $itemId = $_POST['id'];

    $getImage = mysqli_query($conn, "SELECT photo FROM item_photo WHERE item_id = '$itemId'");

    while ($row = mysqli_fetch_array($getImage)) {
        unlink('uploads/' . $row[0]);
        $deleteImage = mysqli_query($conn, "DELETE FROM item_photo WHERE item_id = '$itemId'");

        if (!$deleteImage) {
            echo 'Failed to delete item photo';
        }
    }

    $deleteItem = mysqli_query($conn, "DELETE FROM item WHERE id = '$itemId'");

    if ($deleteItem) {
        header('location:index.php');
    } else {
        echo 'Failed to delete item';
    }
}
