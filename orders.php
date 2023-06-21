<?php
include_once("./admin/config.php");

$statusReady = 'NEW';
$ordersNew = mysqli_query($mysqli, "SELECT * FROM orders WHERE status='NEW' AND created > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY id DESC");
$ordersReady = mysqli_query($mysqli, "SELECT * FROM orders WHERE status='READY' AND created > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY id DESC");
if ($result === false) {
	echo mysqli_error($mysqli);
} else {
	$rowsNew = $ordersNew->fetch_all(MYSQLI_ASSOC);
	$rowsReady = $ordersReady->fetch_all(MYSQLI_ASSOC);

	$object = array('n' => $rowsNew, 'r' => $rowsReady);

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($object);
}
