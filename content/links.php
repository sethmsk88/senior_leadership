<script src="./js/links.js"></script>

<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';

	// Get Diversity & Inclusion links
	$sel_di_links = "
		SELECT l.id, l.linkName, f.fileName
		FROM hrodt.senior_leadership_link l
		JOIN hrodt.senior_leadership_file f
			ON l.file_id = f.id
		WHERE l.group_id = 1
		ORDER BY l.linkName
	";
	$stmt = $conn->prepare($sel_di_links);
	$stmt->execute();
	$di_links_result = $stmt->get_result();

	// Get Regulations and Policies links
	$sel_rp_links = "
		SELECT l.id, l.linkName, l.subgroup_id, f.fileName
		FROM hrodt.senior_leadership_link l
		JOIN hrodt.senior_leadership_file f
			ON l.file_id = f.id
		WHERE l.group_id = 2
		ORDER BY l.linkName
	";
	$stmt = $conn->prepare($sel_rp_links);
	$stmt->execute();
	$rp_links_result = $stmt->get_result();

	// Get Voluntary Separation Policy links
	$sel_vsp_links = "
		SELECT l.id, l.linkName, f.fileName
		FROM hrodt.senior_leadership_link l
		JOIN hrodt.senior_leadership_file f
			ON l.file_id = f.id
		WHERE l.group_id = 3
		ORDER BY l.linkName
	";
	$stmt = $conn->prepare($sel_vsp_links);
	$stmt->execute();
	$vsp_links_result = $stmt->get_result();

	// Get FLSA links
	$sel_flsa_links = "
		SELECT l.id, l.linkName, f.fileName
		FROM hrodt.senior_leadership_link l
		JOIN hrodt.senior_leadership_file f
			ON l.file_id = f.id
		WHERE l.group_id = 4
		ORDER BY l.linkName
	";
	$stmt = $conn->prepare($sel_flsa_links);
	$stmt->execute();
	$flsa_links_result = $stmt->get_result();

	// Get subgroups
	$sel_subgroups = "
		SELECT id, subgroupName
		FROM hrodt.senior_leadership_subgroup
	";
	$stmt = $conn->prepare($sel_subgroups);
	$stmt->execute();
	$subgroups_result = $stmt->get_result();

	$filesDir = "./uploads/";
?>



<div id="links-container" class="container">
	<div class="row">
		<div class="col-md-5 container-background">
			<div class="link-group-header">Diversity &amp; Inclusion</div>
			<?php
				while ($row = $di_links_result->fetch_assoc()) {
			?>
			<a href="<?php echo $filesDir . $row["fileName"] ?>" target="_blank"><?= $row["linkName"] ?></a><br />
			<?php
				}
			?>
		</div>

		<div class="col-md-offset-1 col-md-5 container-background">
			<div class="link-group-header">Voluntary Separation Program</div>
			<?php
				while ($row = $vsp_links_result->fetch_assoc()) {
			?>
			<a href="<?php echo $filesDir . $row["fileName"] ?>" target="_blank"><?= $row["linkName"] ?></a><br />
			<?php
				}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-5 container-background">
			<div class="link-group-header">Proposed Regulation Revisions and New Associated Policies</div>
			<?php
				while ($linksRow = $rp_links_result->fetch_assoc()) {
					if ($linksRow['subgroup_id'] == 0)
						echo '<a href="'. $filesDir . $linksRow['fileName'] . '">' . $linksRow['linkName'] . '</a><br />';
				}
			?>

			<?php
				$subgroupRow = $subgroups_result->fetch_assoc();
			?>
			<a id="subgroup1_link" href="#"><?= $subgroupRow['subgroupName'] ?></a><br />
			<div id="subgroup_1" style="padding-left:1.5em; display:none;">
				<?php
					$rp_links_result->data_seek(0); // Be kind, rewind
					while ($linksRow = $rp_links_result->fetch_assoc()) {
						if ($linksRow['subgroup_id'] == 1)
							echo '<a href="'. $filesDir . $linksRow['fileName'] . '" target="_blank">' . $linksRow['linkName'] . '</a><br />';
					}
				?>
			</div>

			<?php
				$subgroupRow = $subgroups_result->fetch_assoc();
			?>
			<a id="subgroup2_link" href="#"><?= $subgroupRow['subgroupName'] ?></a><br />
			<div id="subgroup_2" style="padding-left:1.5em; display:none;">
				<?php
					$rp_links_result->data_seek(0); // Be kind, rewind
					while ($linksRow = $rp_links_result->fetch_assoc()) {
						if ($linksRow['subgroup_id'] == 2)
							echo '<a href="'. $filesDir . $linksRow['fileName'] . '" target="_blank">' . $linksRow['linkName'] . '</a><br />';
					}
				?>
			</div>

			<?php/*
			<?php
				while ($row = $rp_links_result->fetch_assoc()) {
			?>
			<a href="<?php echo $filesDir . $row["fileName"] ?>" target="_blank"><?= $row["linkName"] ?></a><br />
			<?php
				}
			?>
			*/?>
		</div>

		<div class="col-md-offset-1 col-md-5 container-background">
			<div class="link-group-header">Proposed Changes - Fair Labor Standards Act (FLSA)</div>
			<?php
				while ($row = $flsa_links_result->fetch_assoc()) {
			?>
			<a href="<?php echo $filesDir . $row["fileName"] ?>" target="_blank"><?= $row["linkName"] ?></a><br />
			<?php
				}
			?>
		</div>
	</div>
</div>
