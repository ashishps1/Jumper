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
<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Jumper Details</a></li>
			<li><a href="layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button special">Approval</a></li>
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
					<form method="post" action="#">
						<?php
							if(isset($_GET["jumperid"])) {
								$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
								$result = mysqli_query($connection, $query);
								if(!$result)
									die("database failed at layou1_edit form starting.".mysqli_error($connection));
								$row = mysqli_fetch_assoc($result);
							}
							else
								redirect_to("search.php");
						?>
						<div class = "row uniform">
							<h4>Category : </h4>
							<div class="1u 12u$(small)">
								<input type="radio" id="create_c" name="create_c")
								<?php
									if($row["chCategory"] === "C")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="create_c">C</label>
							</div>
							<div class="1u 12u$(small)">
								<input type="radio" id="create_nc" name="create_nc"
								<?php
									if($row["chCategory"] === "NC")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="create_nc">NC</label>
							</div>
						</div>
						<div class = "row uniform">
							<h4> Jumper Affect Safety System: </h4>
							<div class="1u 12u$(small)">
								<input type="radio" id="jumper_ass_yes" name="jumper_ass_yes"
								<?php
									if($row["chJASS"] === "Y")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="jumper_ass_yes">Yes</label>
							</div>
							<div class="1u 12u$(small)">
								<input type="radio" id="jumper_ass_no" name="jumper_ass_yes"
								<?php
									if($row["chJASS"] === "N")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="jumper_ass_no">No</label>
							</div>
						</div>
						<div class = "row uniform">
							<h4>Requirement of func test :</h4>
							<div class="1u 12u$(small)">
								<input type="radio" id="req_func_test_yes" name="req_func_test_yes"
								<?php
									if($row["chReqFuncTest"] === "Y")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="req_func_test_yes">Yes</label>
							</div>
							<div class="1u 12u$(small)">
								<input type="radio" id="req_func_test_no" name="req_func_test_no"
								<?php
									if($row["chReqFuncTest"] === "N")
										echo "checked";
									else
										echo "disabled";
								?> >
								<label for="req_func_test_no">No</label>
							</div>
						</div>
						<div class = "bordered">
							<div class="6u$ 12u$(small)">
									<input type="radio" id="cancel_check" name="cancel_check"
									<?php
										if(isset($row["vcApprovedby"]) && $row["chCancel"] == "Y")
											echo "checked";
										else
											echo "disabled";
									?>>
									<label for="cancel_check">Cancel Jumper:</label>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)">
									<h6>Name :</h6>
									<input type="text" name="cancel_by_name" id="cancel_by_name" <?php if(isset($row["vcApprovedby"]) && $row["chCancel"] == "Y") echo "value =\"".htmlentities($row["vcApprovedby"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Section :</h6>
									<input type="text" name="cancel_by_section" id="cancel_by_section" <?php if(isset($row["vcApprovedbySection"]) && $row["chCancel"] == "Y") echo "value =\"".htmlentities($row["vcApprovedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig :</h6>
									<input type="text" name="cancel_by_desig" id="cancel_by_desig" <?php if(isset($row["vcApprovedbyDesig"]) && $row["chCancel"] == "Y") echo "value =\"".htmlentities($row["vcApprovedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time :</h6>
									<input type="text" name="cancel_by_date_time" id="cancel_by_date_time" <?php if(isset($row["vcApprovedbyDate"]) && $row["chCancel"] == "Y") echo "value =\"".htmlentities($row["vcApprovedbyDate"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Valid upto :</h6>
									<input type="text" name="valid_upto" id="valid_upto" <?php if(isset($row["vcApprovedTill"]) && $row["chCancel"] == "Y") echo "value =\"".htmlentities($row["vcApprovedTill"])."\""; ?> readonly />
								</div>
							</div>
						</div>
						<br>
						<div class = "bordered">
							<div class="6u$ 12u$(small)">
									<input type="radio" id="imp_check" name="imp_check"
									<?php
										if(isset($row["vcApprovedby"]) && $row["chCancel"] == "N")
											echo "checked";
										else
											echo "disabled";
									?>>
									<label for="imp_check">Approved By/Rec By:</label>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)">
									<h6>Name :</h6>
									<input type="text" name="imp_by_name" id="imp_by_name" <?php if(isset($row["vcApprovedby"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedby"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Section :</h6>
									<input type="text" name="imp_by_section" id="imp_by_section" <?php if(isset($row["vcApprovedbySection"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig :</h6>
									<input type="text" name="imp_by_desig" id="imp_by_desig" <?php if(isset($row["vcApprovedbyDesig"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time :</h6>
									<input type="text" name="imp_by_date_time" id="imp_by_date_time" <?php if(isset($row["vcApprovedbyDate"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedbyDate"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Valid upto :</h6>
									<input type="text" name="valid_upto" id="valid_upto" <?php if(isset($row["vcApprovedTill"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedTill"])."\""; ?> readonly />
								</div>
							</div>
						</div>
						<br>
						<div class="12u$">
							<ul class="actions">
								<li ><a href = "layout2_edit.php?jumperid=<?php echo $_GET["jumperid"]; ?>" class = "button special">Edit</a></li>
							</ul>
						</div>
					</form>
					<?php
						if(isset($row["chCategory"]) && $row["chCategory"] === "C") {
					?>
					<br>
					<div class = "bordered">
						<div class="12u 12u$(xsmall)">
							<h4>JRC Recommendation:</h4>
							<input type="text" name="jrc_desc" id="jrc_desc" <?php if(isset($row["vcJRCDescription"])) echo "value =\"".htmlentities($row["vcJRCDescription"])."\""; ?> readonly />
						</div>
						<br>
						<div align = left>
							<ul class="actions">
								<li ><a href = <?php echo "\"layout2_edit_jrc.php?jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Edit</a></li>
							</ul>
						</div>
					</div>
					<br>
					<?php } ?>
					<form method="post" action="#">
						<br><br>
						<div class = "bordered">
							<div class = "row uniform">
								<h4>Safety Related : </h4>
								<div class="6u$ 12u$(small)">
									<input type="radio" id="cssd_approv" name="cssd_approv"
									<?php
										if(isset($row["vcCSSD"]) && $row["chCS"] != "Y" && $row["chSD"] != "Y" )
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="cssd_approv">CS/SD Approved</label>
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Name :</h6>
									<input type="text" name="cssd_by_name" id="cssd_by_name" <?php if(isset($row["vcCSSD"])) echo "value =\"".htmlentities($row["vcCSSD"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Section :</h6>
									<input type="text" name="cssd_by_section" id="cssd_by_section" <?php if(isset($row["vcCSSDSection"])) echo "value =\"".htmlentities($row["vcCSSDSection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig :</h6>
									<input type="text" name="cssd_by_desig" id="cssd_by_desig" <?php if(isset($row["vcCSSDDesig"])) echo "value =\"".htmlentities($row["vcCSSDDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time :</h6>
									<input type="text" name="cssd_by_date_time" id="cssd_by_date_time" <?php if(isset($row["vcCSSDDate"])) echo "value =\"".htmlentities($row["vcCSSDDate"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Telephonic Approval:</h6>
									<input type="radio" id="tphone_approv_cs" name="tphone_approv_cs"
									<?php
										if($row["chCS"] === "Y")
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="tphone_approv_cs">CS</label>
									<input type="radio" id="tphone_approv_sd" name="tphone_approv_sd"
									<?php
										if($row["chSD"] === "Y")
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="tphone_approv_sd">SD</label>
								</div>
							</div>
							<br>
							<div class="12u$">
								<ul class="actions">
									<li ><a href = "layout2_edit_safety.php?jumperid=<?php echo $_GET["jumperid"]; ?>" class = "button special">Validate</a></li>
								</ul>
							</div>
						</div>
						<br><br><br>
						<?php
							if(isset($row["chCategory"]) && $row["chCategory"] === "NC") {
						?>
						<br>
						<div class = "bordered">
							<div class="12u 12u$(xsmall)">
								<h4>JRC Recommendation:</h4>
								<input type="text" name="jrc_desc" id="jrc_desc" <?php if(isset($row["vcJRCDescription"])) echo "value =\"".htmlentities($row["vcJRCDescription"])."\""; ?> readonly />
							</div>
							<br>
							<div align = left>
								<ul class="actions">
									<li ><a href = <?php echo "\"layout2_edit_jrc.php?jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Edit</a></li>
								</ul>
							</div>
						</div>
						<br>
						<?php } ?>
						<div align = center>
							<ul class="actions">
								<li ><a href = <?php echo "\"print.php?jumperid={$_GET["jumperid"]}\""; ?> class = "button special" target="blank">Print</a></li>
							</ul>
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
