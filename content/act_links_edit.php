<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// insert filename and filepath to a database table so we can link
	$ins_link_sql = "
		INSERT INTO hrodt.senior_leadership_link (linkName, file_id, group_id)
		VALUES (?,?,?)
	";

	if (isset($_POST["linkName"], $_POST["linkFile"], $_POST["group"])
		&& $_POST["linkFile"] != ""
		&& $_POST["group"] != "") {
		$param_str_linkName = $_POST["linkName"];
		$param_int_file_id = $_POST["linkFile"];
		$param_int_group_id = $_POST["group"];

		// Insert linkName into table
		if (!$stmt = $conn->prepare($ins_link_sql)) {
			echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
		} else if (!$stmt->bind_param('sii',
			$param_str_linkName,
			$param_int_file_id,
			$param_int_group_id)) {

			echo 'Binding params failed: (' . $stmt->errno . ') ' . $stmt->error;
		} else if (!$stmt->execute()) {
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
	}
	else {
		echo '<span class="text-danger">Required fields not posted.</span>';
	}
?>
