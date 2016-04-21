<?php
/* If FormData was posted to this page */
if (isset($_FILES['fileToUpload'])) {

	include_once $_SERVER['DOCUMENT_ROOT'] . 'bootstrap/apps/shared/db_connect.php';

	// Start timer
	$timerStart = microtime(true);

	$error = array();
	$fileName = $_FILES['fileToUpload']['name'];
	$fileSize = $_FILES['fileToUpload']['size'];
	$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
	$fileType = $_FILES['fileToUpload']['type'];
	$fileName_exploded = explode('.', $fileName);
	$fileExt = strtolower(end($fileName_exploded));
	
	$extensions = array("csv", "xls", "xlsx", "doc", "docx", "pdf", "jpg");

	if (in_array($fileExt, $extensions) === false) {
		$errors[] = "Invalid file type.";
	}

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
/*
		$insert_csvRow_sql = "
			INSERT INTO hrodt.all_active_fac_staff (
				EmplID,
				EffDt,
				EmplRcd,
				Name,
				PayGroup,
				SalAdminPlan,
				Grade,
				PosNum,
				PosEntryDate,
				FundingDeptID,
				FundingDept,
				DeptID,
				WorkingDept,
				JobFamily,
				JobCode,
				JobTitle,
				UnionCode,
				Annual_Rt,
				BiweeklyRate,
				HourlyRate,
				FTE,
				Sex,
				TenureStatus,
				EthnicCD,
				Race,
				FAMU_HireDate
				)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
		";

		if (!$stmt = $conn->prepare($insert_csvRow_sql)) {
			echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error . '<br />';
		}
		else if (!$stmt->bind_param("isissssisisisssssddddsssss",
			$param_int_EmplID,
			$param_str_EffDt,
			$param_int_EmplRcd,
			$param_str_Name,
			$param_str_PayGroup,
			$param_str_SalAdminPlan,
			$param_str_Grade,
			$param_int_PosNum,
			$param_str_PosEntryDate,
			$param_int_FundingDeptID,
			$param_str_FundingDept,
			$param_int_DeptID,
			$param_str_WorkingDept,
			$param_str_JobFamily,
			$param_str_JobCode,
			$param_str_JobTitle,
			$param_str_UnionCode,
			$param_double_Annual_Rt,
			$param_double_BiweeklyRate,
			$param_double_HourlyRate,
			$param_double_FTE,
			$param_str_Sex,
			$param_str_TenureStatus,
			$param_str_EthnicCD,
			$param_str_Race,
			$param_str_FAMU_HireDate
			// $param_double_BudgetedWeeks,
			// $param_str_BirthDate
			)) {
			echo 'Binding parameters failed (' . $stmt->errno . ') ' . $stmt->error . '<br />';
		}

		
		$stmt->close();
		mysqli_close($conn);
*/
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
