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
						<div class = "bordered">
							<div class="6u$ 12u$(small)">
									<input type="radio" id="iss_radio" name="iss_radio"
									<?php
										if(isset($row["vcIssedby"]))
											echo "checked";
										else
											echo "disabled";
										?>>
									<label for="iss_radio">Issued By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="iss_by_name" id="iss_by_name" <?php if(isset($row["vcIssedby"])) echo "value =\"".htmlentities($row["vcIssedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="iss_by_section" id="iss_by_section" <?php if(isset($row["vcIssedbySection"])) echo "value =\"".htmlentities($row["vcIssedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="iss_by_desig" id="iss_by_desig" <?php if(isset($row["vcIssedbyDesig"])) echo "value =\"".htmlentities($row["vcIssedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="iss_by_date_time" id="iss_by_date_time" <?php if(isset($row["vcIssedbyDate"])) echo "value =\"".htmlentities($row["vcIssedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=1&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>	
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="imp_radio" name="imp_radio" 
									<?php
										if(isset($row["vcImplementedby"]))
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="imp_radio">Implemented By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="iss_by_name" id="iss_by_name" <?php if(isset($row["vcImplementedby"])) echo "value =\"".htmlentities($row["vcImplementedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="iss_by_section" id="iss_by_section" <?php if(isset($row["vcImplementedbySection"])) echo "value =\"".htmlentities($row["vcImplementedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="iss_by_desig" id="iss_by_desig" <?php if(isset($row["vcImplementedbyDesig"])) echo "value =\"".htmlentities($row["vcImplementedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="iss_by_date_time" id="iss_by_date_time" <?php if(isset($row["vcImplementedbyDate"])) echo "value =\"".htmlentities($row["vcImplementedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=2&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="imp_radio" name="imp_radio" 
									<?php
										if(isset($row["vcTestingDoneby"]))
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="imp_radio">Testing Done By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="iss_by_name" id="iss_by_name" <?php if(isset($row["vcTestingDoneby"])) echo "value =\"".htmlentities($row["vcTestingDoneby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="iss_by_section" id="iss_by_section" <?php if(isset($row["vcTestingDonebySection"])) echo "value =\"".htmlentities($row["vcTestingDonebySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="iss_by_desig" id="iss_by_desig" <?php if(isset($row["vcTestingDonebyDesig"])) echo "value =\"".htmlentities($row["vcTestingDonebyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="iss_by_date_time" id="iss_by_date_time" <?php if(isset($row["vcTestingDonebyDate"])) echo "value =\"".htmlentities($row["vcTestingDonebyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=3&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="imp_radio" name="imp_radio" 
									<?php
										if(isset($row["vcQAVerifiedby"]))
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="imp_radio">QA Verified By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="iss_by_name" id="iss_by_name" <?php if(isset($row["vcQAVerifiedby"])) echo "value =\"".htmlentities($row["vcQAVerifiedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="iss_by_section" id="iss_by_section" <?php if(isset($row["vcQAVerifiedbySection"])) echo "value =\"".htmlentities($row["vcQAVerifiedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="iss_by_desig" id="iss_by_desig" <?php if(isset($row["vcQAVerifiedbyDesig"])) echo "value =\"".htmlentities($row["vcQAVerifiedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time :</h6>
									<input type="text" name="iss_by_date_time" id="iss_by_date_time" <?php if(isset($row["vcQAVerifiedbyDate"])) echo "value =\"".htmlentities($row["vcQAVerifiedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=4&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="app_radio" name="app_radio"
									<?php
										if(isset($row["vcNorApprovedby"]))
											echo "checked";
										else
											echo "disabled";
									?>>
									<label for="app_radio">Normalization Approved By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="app_by_name" id="app_by_name" <?php if(isset($row["vcNorApprovedby"])) echo "value =\"".htmlentities($row["vcNorApprovedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="app_by_section" id="app_by_section" <?php if(isset($row["vcNorApprovedbySection"])) echo "value =\"".htmlentities($row["vcNorApprovedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="app_by_desig" id="app_by_desig" <?php if(isset($row["vcNorApprovedbyDesig"])) echo "value =\"".htmlentities($row["vcNorApprovedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="app_by_date_time" id="app_by_date_time" <?php if(isset($row["vcNorApprovedbyDate"])) echo "value =\"".htmlentities($row["vcNorApprovedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=5&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>	
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="nor_radio" name="nor_radio"
									<?php
										if(isset($row["vcNormalizedby"]))
											echo "checked";
										else
											echo "disabled";
									?>>
									<label for="nor_radio">Normalized By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="nor_by_name" id="nor_by_name" <?php if(isset($row["vcNormalizedby"])) echo "value =\"".htmlentities($row["vcNormalizedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="nor_by_section" id="nor_by_section" <?php if(isset($row["vcNormalizedbySection"])) echo "value =\"".htmlentities($row["vcNormalizedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="nor_by_desig" id="nor_by_desig" <?php if(isset($row["vcNormalizedbyDesig"])) echo "value =\"".htmlentities($row["vcNormalizedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="nor_by_date_time" id="nor_by_date_time" <?php if(isset($row["vcNormalizedbyDate"])) echo "value =\"".htmlentities($row["vcNormalizedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=6&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="post_radio" name="post_radio"
									<?php
										if(isset($row["vcPostNormalizedby"]))
											echo "checked";
										else
											echo "disabled";
									?>>
									<label for="post_radio">Post-Normalized & Testing Done By:</label>
							</div>

							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="post_by_name" id="post_by_name" <?php if(isset($row["vcPostNormalizedby"])) echo "value =\"".htmlentities($row["vcPostNormalizedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="post_by_section" id="post_by_section" <?php if(isset($row["vcPostNormalizedbySection"])) echo "value =\"".htmlentities($row["vcPostNormalizedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="post_by_desig" id="post_by_desig" <?php if(isset($row["vcPostNormalizedbyDesig"])) echo "value =\"".htmlentities($row["vcPostNormalizedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="post_by_date_time" id="post_by_date_time" <?php if(isset($row["vcPostNormalizedbyDate"])) echo "value =\"".htmlentities($row["vcPostNormalizedbyDate"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a <?php echo "href = \"layout3_edit.php?value=7&jumperid={$_GET["jumperid"]}\""; ?> class = "button special"> Validate </a></li>
									</ul>
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="#">
						<div class = "bordered">
							<br>
							<div class="6u$ 12u$(small)">
									<input type="radio" id="imp_radio" name="imp_radio" 
									<?php
										if(isset($row["vcQAVerifiedby2"]))
											echo "checked";
										else
											echo "disabled";
									?> >
									<label for="imp_radio">QA Verified By:</label>
							</div>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name:</h6>
									<input type="text" name="iss_by_name" id="iss_by_name" <?php if(isset($row["vcQAVerifiedby2"])) echo "value =\"".htmlentities($row["vcQAVerifiedby2"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section:</h6>
									<input type="text" name="iss_by_section" id="iss_by_section" <?php if(isset($row["vcQAVerifiedby2Section"])) echo "value =\"".htmlentities($row["vcQAVerifiedby2Section"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig:</h6>
									<input type="text" name="iss_by_desig" id="iss_by_desig" <?php if(isset($row["vcQAVerifiedby2Desig"])) echo "value =\"".htmlentities($row["vcQAVerifiedby2Desig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time:</h6>
									<input type="text" name="iss_by_date_time" id="iss_by_date_time" <?php if(isset($row["vcQAVerifiedby2Date"])) echo "value =\"".htmlentities($row["vcQAVerifiedby2Date"])."\""; ?> readonly />
								</div>
								<div class="12u$">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout3_edit.php?value=8&jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Validate</a></li>
									</ul>
								</div>
							</div>
						</div>
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
