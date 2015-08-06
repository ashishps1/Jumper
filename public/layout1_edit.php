<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
	if(!check_auth("2")) {
		$_SESSION["message"] = "Not Authorised To Edit Or Create Jumper";
		$_SESSION["message_color"] = "red";
		if(isset($_GET["jumperid"]))
			redirect_to("layout1.php?jumperid={$_GET["jumperid"]}");
		else
			redirect_to("search.php");
	}
?>
<?php
	require_once("../includes/validation_functions.php");
	if(isset($_POST["submit"])) {
		$_SESSION["error_messages"] = array();
		$flag = 0;
		if(!has_presence($_POST["loc_mod"])||!has_presence($_POST["dr_no"])||!has_presence($_POST["tag_unit"])||!has_presence($_POST["tag_subsys"])||!has_presence($_POST["proposed_till"])||!has_presence($_POST["loc_mod"])||!has_presence($_POST["reason_temp_chng"])||!has_presence($_POST["jumper_desc"])) {
			//mandatory fields are not present
			$_SESSION["error_messages"][] = "All Field Marked * Are Mandatory.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST["proposed_till"])) {
			//Proposed date not of order yyyy-mm-dd
			$_SESSION["error_messages"][] = "Invalid Proposal Date.";
			$flag=1;
		}
		if(!preg_match("/^[0-9]{1}-[0-9]{2}-[0-9]{2}-[0-9a-zA-Z]{2}-[0-9]{3}$/", $_POST["dr_no"])) {
			//DR NO. not like 1-15-09-MM-002
			$_SESSION["error_messages"][] = "Invalid DR-No.";
			$flag=1;
		}
		else if(check_drno($_POST["dr_no"])===0) {
			$_SESSION["error_messages"][] = "DR-No Not in database.";
			$flag = 1;
		}
		else if(check_drno_approval($_POST["dr_no"])===0) {
			$_SESSION["error_messages"][] = "DR-No Already Approved.";
			$flag = 1;
		}
		if (!has_max_length($_POST["loc_mod"], 50)||!has_max_length($_POST["ref_drawing"], 50)||!has_max_length($_POST["reason_temp_chng"], 50)||!has_max_length($_POST["jumper_desc"], 50)||!has_max_length($_POST["remarks"], 50)) {
			//text fields with over 50 length data mustn't be allowed
			$_SESSION["error_messages"][] = "Text Fields Mustn't Have More Than 50 Characters.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9]{1}$/", $_POST["tag_unit"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Unit.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9]{1}$/", $_POST["tag_subsys"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Sub System.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9a-zA-Z]{3}$/", $_POST["tag_sys"])) {
			$_SESSION["error_messages"][] = "Invalid Tag System.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9]{2}$/", $_POST["tag_sysno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag System Number.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9a-zA-Z]{1,2}$/", $_POST["tag_equip"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Equipment.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9]{3}$/", $_POST["tag_equipno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Equiptment Number.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9a-zA-Z]{0,5}$/", $_POST["tag_addtlno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Additional Code.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9a-zA-Z]{0,7}$/", $_POST["tag_component"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Component.";
			$flag = 1;
		}
		if(!preg_match("/^[0-9a-zA-Z]{0,3}$/", $_POST["tag_componentno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Component No.";
			$flag = 1;
		}
		if(preg_match("/[^0-9a-zA-Z_ \t]+/", $_POST["reason_temp_chng"]) || (preg_match("/[^0-9a-zA-Z_ \t]+/", $_POST["jumper_desc"]) && !empty($_POST["jumper_desc"])) || preg_match("/[^0-9a-zA-Z_ \t+-]+/", $_POST["loc_mod"]) || preg_match("/[^0-9a-zA-Z_ \t]+/", $_POST["ref_drawing"])  || (preg_match("/[^0-9a-zA-Z_ \n\t\r]+/", $_POST["remarks"]) && !empty($_POST["remarks"]))) {
			//special characters in text fields
			$_SESSION["error_messages"][] = "Text Fields May Contain Only Alphabets, Digits, Underscores and Whitespaces.";
			$flag = 1;
		}
		if(check_tagno($_POST["tag_unit"], $_POST["tag_subsys"], $_POST["tag_sys"], $_POST["tag_sysno"], $_POST["tag_equip"], $_POST["tag_equipno"])===0) {
			$_SESSION["error_messages"][] = "Tag No. Not in database.";
			$flag = 1;
		}
		
		if (!$flag) {
			// insert in database
			if(!isset($_GET["jumperid"])) {
				$get_jumperid = insert_into_layout1( $_POST["proposed_till"], $_POST["jumper_desc"], $_POST["dr_no"], $_POST["tag_unit"], $_POST["tag_subsys"], $_POST["tag_sys"], $_POST["tag_sysno"], $_POST["tag_equip"], $_POST["tag_equipno"], $_POST["tag_addtlno"], $_POST["tag_component"], $_POST["tag_componentno"], $_POST["loc_mod"], $_POST["ref_drawing"], $_POST["reason_temp_chng"], $_POST["remarks"], $_POST["unit_status"]);
				$_SESSION["message"] = "Successfully Inserted Jumper Details";
			}
			else {
				//update existing row
				$get_jumperid = $_GET["jumperid"];
				update_into_layout1($_GET["jumperid"], $_POST["proposed_till"], $_POST["jumper_desc"], $_POST["dr_no"], $_POST["tag_unit"], $_POST["tag_subsys"], $_POST["tag_sys"], $_POST["tag_sysno"], $_POST["tag_equip"], $_POST["tag_equipno"], $_POST["tag_addtlno"], $_POST["tag_component"], $_POST["tag_componentno"], $_POST["loc_mod"], $_POST["ref_drawing"], $_POST["reason_temp_chng"], $_POST["remarks"], $_POST["unit_status"]);
				$_SESSION["message"] = "Successfully Edited Jumper Details";
			}
			$_SESSION["message_color"] = "green";
			redirect_to("layout1.php?jumperid={$get_jumperid}");
		}
		else {
			if(isset($_GET["jumperid"]))
				redirect_to("layout1_edit.php?jumperid={$_GET["jumperid"]}");
			else
				redirect_to("layout1_edit.php");
		}
	}
?>
<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button special">Jumper Details</a></li>
			<li><a href="layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Approval</a></li>
			<li><a href="layout3.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Issue</a></li>
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
					<form method="post" action=
						<?php
							if (isset($_GET["jumperid"]))
								echo ("layout1_edit.php?jumperid=".$_GET["jumperid"]);
							else
								echo ("layout1_edit.php");
						?>>
						<?php
							if(isset($_GET["jumperid"])) {
								$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
								$result = mysqli_query($connection, $query);
								if(!$result)
									die("database failed at layou1_edit form starting.".mysqli_error($connection));
								$row = mysqli_fetch_assoc($result);
								if(isset($row["vcApprovedby"]))
									redirect_to("layout1.php?jumperid={$_GET["jumperid"]}");
							}
							else
								$row = array();
						?>
						<div class="row uniform">
							<div class="3u 12u$(xsmall)">
								<h4>Jumper No. :</h4>
								<input type="text" name="jumper_no" id="jumper_no" <?php if(isset($row["vcJumperNo"])) echo "value =\"".htmlentities($row["vcJumperNo"])."\""; ?> readonly />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Jumper Description<sup><font color = "red">*</font></sup>:</h4>
								<input type="text" name="jumper_desc" id="jumper_desc" <?php if(isset($row["vcDescription"])) echo "value =\"".htmlentities($row["vcDescription"])."\""; ?>/>
							</div>
							<div class="3u 12u$(xsmall)">
								<h4>DR No.<sup><font color = "red">*</font></sup> :</h4>
								<input type="text" name="dr_no" id="dr_no" <?php if(isset($row["vcDRNo"])) echo "value =\"".htmlentities($row["vcDRNo"])."\""; ?> onkeyup="validateNonEmpty(this, document.getElementById('date_help'))" />
											<span id="date_help" class="help"></span>
							</div>
						</div>
						<br><h4>Tag No :</h4>
						<div class = "bordered">
							<div class = "row uniform">
								<div class="2u 12u$(xsmall)">
									<h6>Unit<sup><font color = "red">*</font></sup> :</h6>
									<input type="text" name="tag_unit" id="tag_unit" <?php if(isset($row["chUnit"])) echo "value =\"".htmlentities($row["chUnit"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Sub Sys<sup><font color = "red">*</font></sup>:</h6>
									<input type="text" name="tag_subsys" id="tag_subsys" <?php if(isset($row["vcSubsystem"])) echo "value =\"".htmlentities($row["vcSubsystem"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Sys<sup><font color = "red">*</font></sup>:</h6>
									<input type="text" name="tag_sys" id="tag_sys" <?php if(isset($row["vcSystem"])) echo "value =\"".htmlentities($row["vcSystem"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Sys No<sup><font color = "red">*</font></sup>:</h6>
									<input type="text" name="tag_sysno" id="tag_sysno" <?php if(isset($row["vcSystemNo"])) echo "value =\"".htmlentities($row["vcSystemNo"])."\""; ?> />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Equip<sup><font color = "red">*</font></sup>:</h6>
									<input type="text" name="tag_equip" id="tag_equip" <?php if(isset($row["vcEqpt"])) echo "value =\"".htmlentities($row["vcEqpt"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Equip No<sup><font color = "red">*</font></sup>:</h6>
									<input type="text" name="tag_equipno" id="tag_equipno" <?php if(isset($row["vcEqptNo"])) echo "value =\"".htmlentities($row["vcEqptNo"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Addtl No:</h6>
									<input type="text" name="tag_addtlno" id="tag_adtlno" <?php if(isset($row["vcAdditionalCode"])) echo "value =\"".htmlentities($row["vcAdditionalCode"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Cmpnent:</h6>
									<input type="text" name="tag_component" id="tag_component" <?php if(isset($row["vcComponent"])) echo "value =\"".htmlentities($row["vcComponent"])."\""; ?>/>
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>CmpnentNo:</h6>
									<input type="text" name="tag_componentno" id="tag_componentno" <?php if(isset($row["vcComponentNo"])) echo "value =\"".htmlentities($row["vcComponentNo"])."\""; ?>/>
								</div>
								<div class="2u 12u$(small)">
									<h6>Unit Status<sup><font color = "red">*</font></sup></h6>
									<input type="radio" id="units_o" name="unit_status" value = "Operational" <?php if(isset($row["vcUnitStatus"]) && $row["vcUnitStatus"] != "Shut Down") echo "checked";?>>
									<label for="units_o">Operational</label>
								</div>
								<div class="4u 12u$(small)">
									<h6>:</h6>
									<input type="radio" id="units_s" name="unit_status" value = "Shut Down" <?php if(isset($row["vcUnitStatus"]) && $row["vcUnitStatus"] == "Shut Down") echo "checked";?>>
									<label for="units_s">Shut Down</label>
								</div>
							</div>
						</div>
						<div class = "row uniform">
							<div class="6u 12u$(xsmall)">
								<h4>Location of Modif<sup><font color = "red">*</font></sup>:</h4>
								<input type="text" name="loc_mod" id="loc_mod" <?php if(isset($row["vcLocation"])) echo "value =\"".htmlentities($row["vcLocation"])."\""; ?>/>
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Ref Drawing:</h4>
								<input type="text" name="ref_drawing" id="ref_drawing" <?php if(isset($row["vcDrawing"])) echo "value =\"".htmlentities($row["vcDrawing"])."\""; ?> />
							</div>
							<div class="8u 12u$(xsmall)">
								<h4>Reason for Temp Change<sup><font color = "red">*</font></sup>:</h4>
								<input type="text" name="reason_temp_chng" id="reason_temp_chng" <?php if(isset($row["vcReason"])) echo "value =\"".htmlentities($row["vcReason"])."\""; ?>/>
							</div>
						
							<div class="4u 12u$(xsmall)">
								<h4>Proposed Till<sup><font color = "red">*</font></sup>:</h4>
								<input type="text" name="proposed_till" id="proposed_till" <?php if(isset($row["vcProposedTill"])) echo "value =\"".htmlentities($row["vcProposedTill"])."\""; ?> placeholder = "YYYY-MM-DD"/>
							</div>
							<div class="12u$">
								<h4>Remarks:</h4>
								<textarea name="remarks" id="remarks" rows="4"><?php if(isset($row["remarks"])) echo htmlentities($row["remarks"]); ?><?php if(isset($row["vcRemarks"])) echo htmlentities($row["vcRemarks"]); ?></textarea>
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input type="submit" name = "submit" value="Submit" class="special" /></li>
								</ul>
							</div>
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
