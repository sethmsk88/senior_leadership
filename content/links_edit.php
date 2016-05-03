<script src="./js/links_edit.js"></script>

<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// get all uploaded files
	$sel_uploaded_files = "
		SELECT *
		FROM hrodt.senior_leadership_file
		ORDER BY id DESC
	";
	$stmt = $conn->prepare($sel_uploaded_files);
	$stmt->execute();
	$files_result = $stmt->get_result();

	// get groups
	$sel_groups = "
		SELECT *
		FROM hrodt.senior_leadership_group
	";
	$stmt = $conn->prepare($sel_groups);
	$stmt->execute();
	$groups_result = $stmt->get_result();
?>

<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h4>Instructions</h4>
			<ol>
				<li>Upload a file you would like to link to.</li>
				<li>Refresh page</li>
				<li>Fill out the add link form by adding the name of the link, and then selecting the uploaded file you would like to link to.</li>
			</ol>
		</div>
	</div>
	<br />

	<form
		name="uploadFile-form"
		id="uploadFile-form"
		role="form"
		method="post"
		action=""
		enctype="multipart/form-data">

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label for="fileToUpload"><h4>Upload file to be linked</h4></label><br />
					<div class="input-group">
						<span class="input-group-btn">
							<span class="btn btn-primary btn-file">
								Browse <input type="file" name="fileToUpload" id="fileToUpload">
							</span>
						</span>
						<input type="text" class="form-control" readonly="readonly">
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-bottom:20px;">
			<div class="col-lg-2">					
				<input
					type="submit"
					name="upload-submit"
					class="btn btn-primary form-control"
					value="Upload File">
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div id="ajax_uploadResponse"></div>
			</div>
		</div>
	</form>
	<br />

	<form
		name="addLink-form"
		id="addLink-form"
		role="form"
		method="post"
		action="./content/act_links_edit.php">

		<div class="row">
			<div class="col-lg-12">
				<h4>Add Link</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4 form-group">
				<input
					name="linkName"
					type="text"
					class="form-control"
					placeholder="Link Name">
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4 form-group">
				<select name="linkFile" class="form-control">
					<option value="">Select a file...</option>

					<?php
						// get all uploaded files from db table
						while ($row = $files_result->fetch_assoc()) {
					?>
					<option value="<?= $row["id"] ?>"><?= $row["fileName"] ?></option>
					<?php
						}
					?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4 form-group">
				<select name="group" class="form-control">
					<option value="">Select a group...</option>

					<?php
						// get all groups from db table
						while ($row = $groups_result->fetch_assoc()) {
					?>
					<option value="<?= $row["id"] ?>"><?= $row["groupName"] ?></option>
					<?php
						}
					?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-2">
				<input
					type="submit"
					name="link-submit"
					class="btn btn-primary form-control"
					value="Add Link">
			</div>
		</div>
	</form>
</div>
