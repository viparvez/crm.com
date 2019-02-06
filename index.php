<!DOCTYPE html>
<html>
<head>
	<title>Bulk Payment</title>
</head>
<body>
	<form name="bulk_payment" method="POST" action="" enctype="multipart/form-data">
		<input type="file" name="fileToUpload">
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

			$token = getToken();

			foreach ($rows as $key => $value) {
				//Payment
				$paymentInfo = explode(" ", $value);
				$accrecnum = trim($paymentInfo[0]);
				$amount = trim($paymentInfo[1]);
				$pay = createPayment($accrecnum,$amount,'Cash', $token);
				//Activation
				$status= checkStatus($accrecnum);
				$sub_id = "S0".get_string_between($status,"S0","\"");
				$activate = activate($sub_id);

				echo $activate." account number: $accrecnum</br>";
			}
		}

	}
?>