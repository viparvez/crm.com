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
		
		$fileName = "uploads/".basename($_FILES["fileToUpload"]["name"],"txt").time().".txt";
		$fileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
		
		if($fileType != "txt") {
		    echo "Sorry, only .txt are allowed.";
		} else {
			$file = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName);
		}

			/*$uploadOk = 1;
			
			
			if($textFileType != "txt") {
			    echo "Sorry, only .txt are allowed.";
			    $uploadOk = 0;
			}
		*/
	}
?>