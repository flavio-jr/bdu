<?php
require_once 'Transaction.php';
require_once 'Connection.php';
Work\Database\Transaction::open('bdu');
Work\Database\Transaction::close();
$conn = Work\Database\Transaction::get();
if($conn) {
	echo "get OK!<br>\n";
}
else {
	echo "not ok!";
}
?>
