<?php
	include_once("config.php");
	$greatestResult = mysqli_query($mysqli, "SELECT order_number FROM orders WHERE created > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY id DESC LIMIT 1");
	$greatestRow = $greatestResult->fetch_all(MYSQLI_ASSOC);
	$newOrderNumber = '1';
	if (count($greatestRow) > 0) {
		$greatestOrderNumber = intval($greatestRow[0]['order_number']);
		$newOrderNumber = strval($greatestOrderNumber + 1);
	}
	
?>
<html>
<head>
	<title>Add Order</title>
	<style>
		.textfield{font-size:28px}
	</style>
</head>

<body>
	<a href="index.php">Go to Home</a>
	<br/><br/>

	<form action="add.php" method="post" name="form1">
		<table border="0">
			<tr>
				<td>Order Number</td>
				<td><input type="text" name="order_number" value="<?php echo $newOrderNumber;?>" maxlength="4" autocomplete="off" class="textfield"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="Submit" value="Add"></td>
			</tr>
		</table>
	</form>

<?php
	if(isset($_POST['Submit'])) {
		$orderNumber = $_POST['order_number'];
		$status = 'NEW'; // NEW, READY, TAKEN, CANCEL

		//include_once("config.php");

		$result = mysqli_query($mysqli, "INSERT INTO orders(order_number, status, created, updated) VALUES('$orderNumber','$status', NOW(), NOW())");
		if ($result === false) {
			echo mysqli_error($mysqli);
		} else {
			echo "Order created. <a href='index.php'>View Orders</a>";
		}
	}
?>
</body>
</html>