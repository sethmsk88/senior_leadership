<?php
/* If FormData was posted to this page */
if (isset($_FILES['fileToUpload'])) {

	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// Start timer
	$timerStart = microtime(true);

	$error = array();
	$fileName = $_FILES['fileToUpload']['name'];
	$fileSize = $_FILES['fileToUpload']['size'];
	$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
	$fileType = $_FILES['fileToUpload']['type'];
	$fileName_exploded = explode('.', $fileName);
	$fileExt = strtolower(end($fileName_exploded));
	
	//$extensions = array("csv", "xls", "xlsx", "doc", "docx", "pdf", "jpg", ".txt");

	// if (in_array($fileExt, $extensions) === false) {
	// 	$errors[] = "Invalid file type.";
	// }

	$maxFileSize = 1024 * 1024 * 64; // 64MB
	if ($fileSize > $maxFileSize) {
		$errors[] = "Max file size exceeded. File size must be less than 64MB";
	}

	/* If upload failed display message */
	if (empty($errors) == false) {
		echo 'Error: File was NOT uploaded<br />';
		foreach ($errors as $errorMsg) {
			echo $errorMsg . '<br />';
		}
	}
	/*
		Else, parse uploaded file, and insert each
		row into the table
	*/
	else {
		move_uploaded_file($fileTmpName, '../uploads/' . $fileName);

		// insert filename and filepath to a database table so we can link
		$ins_file_sql = "
			INSERT INTO hrodt.senior_leadership_file (fileName)
			VALUES (?)
		";

		// Insert fileName into table
		if (!$stmt = $conn->prepare($ins_file_sql)) {
			echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
		} else if (!$stmt->bind_param('s', $fileName)) {
			echo 'Binding params failed: (' . $stmt->errno . ') ' . $stmt->error;
		} else if (!$stmt->execute()) {
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}		
		
		// Stop timer
		$timerStop = microtime(true);

		$elapsedTime = ($timerStop - $timerStart); // seconds
	}
?>
<div class="alert alert-success">
	<strong>Success!</strong> Upload took <?= number_format($elapsedTime, 1) ?> seconds
</div>

<?php
}// End if FormData was posted to this page
?>
