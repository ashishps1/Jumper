<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
?>
<?php
	if(!isset($_GET["jumperid"]))
		redirect_to("search.php");
	else {
		global $connection;
		$query2 = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
		$result2 = mysqli_query($connection, $query2);
		if(!$result2)
			die("database failed at layou1_edit form starting.".mysqli_error($connection));
		$row2 = mysqli_fetch_assoc($result2);
	}
	
	if(!isset($_GET["value"]))
		redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
	else if ($_GET["value"] === "1") {
		if(!check_auth("5")) {
			$_SESSION["message"] = "Not Authorised To Issue Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "2") {
		if(!check_auth("6")) {
			$_SESSION["message"] = "Not Authorised To Implement or Test Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "3") {
		if(!check_auth("6")) {
			$_SESSION["message"] = "Not Authorised To Implement or Test Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "4") {
		if(!check_auth("1")) {
			$_SESSION["message"] = "Not Authorised To QA Verify Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "5") {
		if(!check_auth("7")) {
			$_SESSION["message"] = "Not Authorised To Approve Normalization of Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "6") {
		if(!check_auth("8")) {
			$_SESSION["message"] = "Not Authorised To Normalize Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "7") {
		if(!check_auth("9")) {
			$_SESSION["message"] = "Not Authorised To Post-Normalize Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}
	else if ($_GET["value"] === "8") {
		if(!check_auth("1")) {
			$_SESSION["message"] = "Not Authorised To QA Verify Jumper";
			$_SESSION["message_color"] = "red";
			if(isset($_GET["jumperid"]))
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("search.php");
		}
	}

	if(isset($_POST["validate_no"])) {
		redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
	}
	else if(isset($_POST["validate_yes"])) {
		$get_value = $_GET["value"];
		global $connection;
		$date = date('Y-m-d H:i:s');
		if($get_value === "1") {
			if(!isset($row2["vcApprovedby"]) || $row2["vcStatus"] != "APP") {
				$_SESSION["message"] = "Issue can be done only once, after approval";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcIssedby = '{$_SESSION["username"]}', ";
			$query .= "vcIssedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcIssedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcIssedbyDate = '{$date}' ";
			$_SESSION["message"] = "Succesfully Issued Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "2") {
			if(!isset($row2["vcIssedby"])) {
				$_SESSION["message"] = "Implementation can be done only once, after Issue.";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcImplementedby = '{$_SESSION["username"]}', ";
			$query .= "vcImplementedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcImplementedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcImplementedbyDate = '{$date}', ";
			$query .= "vcStatus = 'IMP' ";
			$_SESSION["message"] = "Succesfully Implemented Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "3") {
			if(!isset($row2["vcImplementedby"])) {
				$_SESSION["message"] = "Testing can be done only once, after Implementation.";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcTestingDoneby = '{$_SESSION["username"]}', ";
			$query .= "vcTestingDonebyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcTestingDonebySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcTestingDonebyDate = '{$date}' ";
			$_SESSION["message"] = "Succesfully Updated Testing Done for Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "4") {
			$query = "update jumperdr set ";
			$query .= "vcQAVerifiedby = '{$_SESSION["username"]}', ";
			$query .= "vcQAVerifiedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcQAVerifiedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcQAVerifiedbyDate = '{$date}' ";
			$_SESSION["message"] = "Succesfully QA Verified Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "5") {
			if(!isset($row2["vcImplementedby"])) {
				$_SESSION["message"] = "Normalization Approval can be given only once, after Implementation.";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcNorApprovedby = '{$_SESSION["username"]}', ";
			$query .= "vcNorApprovedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcNorApprovedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcNorApprovedbyDate = '{$date}' ";
			$_SESSION["message"] = "Succesfully NorApproved Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "6") {
			if(!isset($row2["vcNorApprovedby"])) {
				$_SESSION["message"] = "Normalization can be done only once, after Normalization Approval.";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcNormalizedby = '{$_SESSION["username"]}', ";
			$query .= "vcNormalizedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcNormalizedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcNormalizedbyDate = '{$date}', ";
			$query .= "vcStatus = 'NOR' ";
			$_SESSION["message"] = "Succesfully Normalized Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "7") {
			if(!isset($row2["vcNormalizedby"])) {
				$_SESSION["message"] = "Post Normalization can be done only once, after Normlaization.";
				$_SESSION["message_color"] = "red";
				redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
			}
			$query = "update jumperdr set ";
			$query .= "vcPostNormalizedby = '{$_SESSION["username"]}', ";
			$query .= "vcPostNormalizedbyDesig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcPostNormalizedbySection = '{$_SESSION["userSection"]}', ";
			$query .= "vcPostNormalizedbyDate = '{$date}', ";
			$query .= "vcStatus = 'CLSD' ";
			$_SESSION["message"] = "Succesfully Post Normalized Jumper";
			$_SESSION["message_color"] = "green";
		}
		else if($get_value === "8") {
			$query = "update jumperdr set ";
			$query .= "vcQAVerifiedby2 = '{$_SESSION["username"]}', ";
			$query .= "vcQAVerifiedby2Desig = '{$_SESSION["userDesig"]}', ";
			$query .= "vcQAVerifiedby2Section = '{$_SESSION["userSection"]}', ";
			$query .= "vcQAVerifiedby2Date = '{$date}' ";
			$_SESSION["message"] = "Succesfully QA Verified Jumper";
			$_SESSION["message_color"] = "green";
		}
		else
			redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
		$query .= "where intJumperID = {$_GET["jumperid"]}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			$_SESSION["message"] = null;
			$_SESSION["message_color"] = null;
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		redirect_to("layout3.php?jumperid={$_GET["jumperid"]}");
	}
?>
<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Jumper Details</a></li>
			<li><a href="layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Approval</a></li>
			<li><a href="layout3.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button special">Issue</a></li>
			<li><a href="search.php" class="button">Search</a></li>
		</ul>
	</div>
</section>
</header>
<!-- Main -->
<article id="main">
	<section class="wrapper style5">
		<div class = "container-body">
			<div class="inner">
				<?php echo message(); ?>
				<?php echo form_errors(error_messages()); ?>
				<section>
					<form method="post" action="layout3_edit.php<?php echo "?value={$_GET["value"]}&jumperid={$_GET["jumperid"]}";?>">
						<h4>Are You Sure You Want To Validate?</h4>
						<div class = "row uniform">
							<ul class="actions">
								<li><input type="submit" name = "validate_yes" value="Yes" /></li>
							</ul>
							<ul class="actions">
								<li><input type="submit" name = "validate_no" value="No" class="special" /></li>
							</ul>
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
