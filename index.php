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
	if (isset($_POST['submit'])) {
		$fileName = basename($_FILES["fileToUpload"]["name"],"txt").time().".txt";

		echo $fileName;

		/*$file = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName);
		$target_file = "uploads/" . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$textFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		if($textFileType != "txt") {
		    echo "Sorry, only .txt are allowed.";
		    $uploadOk = 0;
		}*/
	}
?>