<!DOCTYPE html>
<html>
<head>
	<title>Bulk Payment</title>
</head>
<body>
	<form name="bulk_payment" method="POST" action="" enctype="multipart/form-data">
		<input type="file" name="fileToUpload">
		<select name="action">
			<option value="payment">Payment Only</option>
			<option value="payment and activation">Payment and Activation</option>
		</select>
		<input type="submit" name="submit" value="SUBMIT">
	</form>
</body>
</html>

<?php
	
	require 'includes/generateToken.php';
	require 'includes/createPayment.php';
	require 'includes/checkStatus.php';
	require 'includes/getStringBetween.php';
	require 'includes/activation.php';

	if (isset($_POST['submit'])) {
		
		$fileName = "uploads/".basename($_FILES["fileToUpload"]["name"],"txt").time().".txt";
		$fileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
		
		if($fileType != "txt") {
		    echo "Sorry, only .txt are allowed.";
		} else {
			$file = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName);

			$rows = explode(',', file_get_contents($fileName));

			require 'config/config.db.php';

			$token = getToken();

			foreach ($rows as $key => $value) {

				$action = $_POST['action'];

				if ($action == 'payment') {

					//Payment
					$paymentInfo = explode(" ", $value);
					$accrecnum = trim($paymentInfo[0]);
					$amount = trim($paymentInfo[1]);
					$pay = createPayment($accrecnum,$amount,'Cash', $token);

					log_payment($pay, $accrecnum, $action);

				} else if ($_POST['action'] == 'payment and activation') {
					//Payment
					$paymentInfo = explode(" ", $value);
					$accrecnum = trim($paymentInfo[0]);
					$amount = trim($paymentInfo[1]);
					$pay = createPayment($accrecnum,$amount,'Cash', $token);

					//Activation
					$status= checkStatus($accrecnum);
					$sub_id = "S0".get_string_between($status,"S0","\"");
					$activate = activate($sub_id);

					log_activation($activate, $accrecnum, $action);
				}
			}
		}

	}

	function log_payment($pay, $accrecnum, $action) {
		
		global $conn;
		
		$dateTime = date("Y-m-d h:i:s");

		if ($pay == 'Payment Posted') {
			$sql = "INSERT INTO testlogger (accrecnum, action, success, message, created_at)
			VALUES ('$accrecnum', '$action', 'YES', '$pay', '$dateTime')";
		} else {
			$sql = "INSERT INTO testlogger (accrecnum, action, success, message, created_at)
			VALUES ('$accrecnum', '$action', 'NO', '$pay', '$dateTime')";
		}

		if ($conn->query($sql) === TRUE) {
		    echo "All jobs executed </br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error."</br>";
		}
	}

	function log_activation($activate, $accrecnum, $action) {

		global $conn;

		$dateTime = date("Y-m-d h:i:s");

		if ($activate == 'Activation Completed') {
			$sql = "INSERT INTO testlogger (accrecnum, action, success, message, created_at)
			VALUES ('$accrecnum', '$action', 'YES', '$activate', '$dateTime')";
		} else {
			$sql = "INSERT INTO testlogger (accrecnum, action, success, message, created_at)
			VALUES ('$accrecnum', '$action', 'NO', '$activate', '$dateTime')";
		}

		if ($conn->query($sql) === TRUE) {
		    echo "All jobs executed </br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error. "</br>";
		}
	}
?>