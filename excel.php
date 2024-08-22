<?php

// use Shuchkin\SimpleXLSXGen;

// require 'SimpleXLSXGen.php';

// $books = [
//     ['ISBN', 'title', 'author', 'publisher', 'ctry'],
//     [618260307, 'The Hobbit', 'J. R. R. Tolkien', 'Houghton Mifflin', 'USA'],
//     [908606664, 'Slinky Malinki', 'Lynley Dodd', 'Mallinson Rendel', 'NZ']
// ];

// $xlsx = SimpleXLSXGen::fromArray($books);
// $xlsx->downloadAs('books.xlsx');

use Shuchkin\SimpleXLSXGen;

require 'SimpleXLSXGen.php';
require 'function.php';
require 'cek.php';

$getDataExcel = mysqli_query($conn, "SELECT user.name, transaction.created_at, item.name as product, transaction_detail.quantity, item.reseller_price, transaction.status FROM transaction_detail INNER JOIN transaction ON transaction.id = transaction_detail.transaction_id INNER JOIN item ON item.id = transaction_detail.item_id INNER JOIN user ON transaction.user_id = user.id WHERE transaction.status = 'approved'");

$index = 0;
$dataExcel[] = ['Reseller Name', 'Transaction Date', 'Nama Produk', 'Quantity', 'Total Price', 'Transaction Status'];
while ($row = mysqli_fetch_assoc($getDataExcel)) {
    $dataExcel[] = $row;
    $dataExcel[$index + 1]['reseller_price'] = ($row['quantity'] * $row['reseller_price']);
    $index++;
}

// echo '<pre>';

// print_r($dataExcel);

// echo '</pre>';
// die;

$xlsx = SimpleXLSXGen::fromArray($dataExcel);
$xlsx->downloadAs('transactions.xlsx');
