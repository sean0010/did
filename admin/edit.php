<?php
include_once("config.php");

if(isset($_POST['update']))
{
	$id = $_POST['id'];
	$status=$_POST['status'];

	$result = mysqli_query($mysqli, "UPDATE orders SET status='$status', updated=NOW() WHERE id=$id");

	header("Location: index.php");
}
?>
<?php
// Display selected user data based on id
// Getting id from url
$id = $_GET['id'];

// Fetech user data based on id
$result = mysqli_query($mysqli, "SELECT * FROM orders WHERE id=$id");

while($order_data = mysqli_fetch_array($result))
{
	$orderNumber = $order_data['order_number'];
	$status = $order_data['status'];
	$created = $order_data['created'];
	$updated = $order_data['updated'];
}
?>
<html>
<head>
	<title>Edit Order Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>

	<form name="update_order" method="post" action="edit.php">
		<table border="0">
			<tr>
				<td>ID</td>
				<td><?php echo $id;?></td>
			</tr>
			<tr>
				<td>Order#</td>
				<td><?php echo $orderNumber;?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<!--NEW, READY, TAKEN, CANCEL-->
					<input type="radio" name="status" <?php if (isset($status) && $status=="NEW") echo "checked";?> value="NEW">NEW
					<input type="radio" name="status" <?php if (isset($status) && $status=="READY") echo "checked";?> value="READY">READY
					<input type="radio" name="status" <?php if (isset($status) && $status=="TAKEN") echo "checked";?> value="TAKEN">TAKEN
					<input type="radio" name="status" <?php if (isset($status) && $status=="CANCEL") echo "checked";?> value="CANCEL">CANCEL
				</td>
			</tr>
			<tr>
				<td>Created</td>
				<td><?php echo $created;?></td>
			</tr>
			<tr>
				<td>Updated</td>
				<td><?php echo $updated;?></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>