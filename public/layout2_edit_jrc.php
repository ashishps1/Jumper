<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
	if(!isset($_GET["jumperid"]))
		redirect_to("search.php");
	if(!check_auth("A")) {
		$_SESSION["message"] = "Not Authorized for JRC.";
		$_SESSION["message_color"] = "red";
		redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
	}
	if(isset($_POST["jrc_submit"])) {
		if(empty($_POST["jrc_desc"])) {
			$_SESSION["message"] = "mandatory Fields need to be Entered.";
			$_SESSION["message_color"] = "red";
			redirect_to("layout2_edit_jrc.php?jumperid={$_GET["jumperid"]}");
		}
		global $connection;
		$query = "update jumperdr set vcJRCDescription = '{$_POST["jrc_desc"]}' where intJumperID = {$_GET["jumperid"]}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		$_SESSION["message"] = "Successfully inserted JRC Recommendation.";
		$_SESSION["message_color"] = "green";
		redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
	}
?>
<!-- Main -->
<article id="main">
	<section class="wrapper style5">
		<div class = "container-body">
			<div class="inner">
				<?php echo message(); ?>
				<?php echo form_errors(error_messages()); ?>
				<section>
					<form method="post" action=<?php echo "layout2_edit_jrc.php?jumperid={$_GET["jumperid"]}"; ?> >
						<?php
							if(isset($_GET["jumperid"])) {
								$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} " ;
								$result = mysqli_query($connection, $query);
								if(!$result)
									die("database failed at layou1_edit form starting.".mysqli_error($connection));
								$row = mysqli_fetch_assoc($result);
							}
							else
								$row = array();
							if(!isset($row["vcApprovedby"]) || $row["vcStatus"] === "CAN") {
								$_SESSION["message"] = "Cannot be Recommended by JRC if not Approved.";
								$_SESSION["message_color"] = "red";
								redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
							}
						?>
						
						<div class = "row uniform">
							<div class = "12u 12u$(xsmall)">
								<h4>JRC Recommendation<sup><font color = "red">*</font></sup>: </h4>
								<input type="text" name="jrc_desc" id="jrc_desc" <?php if(isset($row["vcJRCDescription"])) echo "value =\"".htmlentities($row["vcJRCDescription"])."\""; ?>  />
							</div>
						</div>
						<div class = "row uniform">
							<ul class="actions">
								<li><input type="submit" name = "jrc_submit" value="Submit" class="special" /></li>
								<li><a href = "layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" >CANCEL</a></li>
							</ul>
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>