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
					<form method="post" action="#">
						<?php
							if(isset($_GET["jumperid"])) {
								$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
								$result = mysqli_query($connection, $query);
								if(!$result)
									die("database failed at layou1_edit form starting.".mysqli_error($connection));
								$row = mysqli_fetch_assoc($result);
								$query2 = "Select * from tabTag where chUnit = '{$row["chUnit"]}' and vcSubSystem = '{$row["vcSubsystem"]}' and vcSystem = '{$row["vcSystem"]}' and vcSystemNo = '{$row["vcSystemNo"]}' and vcEqpt = '{$row["vcEqpt"]}' and vcEqptNo = '{$row["vcEqptNo"]}'" ;
								$result2 = odbc_exec($connection2, $query2);
								if(!$result2)
									die("database odbc failed at layou1_edit form starting.");
								odbc_fetch_row($result2);
								$tag_desc = odbc_result($result2, 8);
							}
							else
								redirect_to("search.php");
						?>
						<div class="row uniform">
							<div class="3u 12u$(xsmall)">
								<h4>Jumper No. :</h4>
								<input type="text" name="jumper_no" id="jumper_no" <?php if(isset($row["vcJumperNo"])) echo "value =\"".htmlentities($row["vcJumperNo"])."\""; ?> readonly />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Jumper Description :</h4>
								<input type="text" name="jumper_desc" id="jumper_desc" <?php if(isset($row["vcDescription"])) echo "value =\"".htmlentities($row["vcDescription"])."\""; ?> readonly />
							</div>
							<div class="3u 12u$(xsmall)">
								<h4>DR No. :</h4>
								<input type="text" name="dr_no" id="dr_no" <?php if(isset($row["vcDRNo"])) echo "value =\"".htmlentities($row["vcDRNo"])."\""; ?> readonly />
							</div>
						</div>
						<br><h4>Tag No :</h4>
						<div class = "row uniform">
							<div class="2u 12u$(xsmall)">
								<h6>Unit :</h6>
								<input type="text" name="tag_unit" id="tag_unit" <?php if(isset($row["chUnit"])) echo "value =\"".htmlentities($row["chUnit"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Sub Sys:</h6>
								<input type="text" name="tag_subsys" id="tag_subsys" <?php if(isset($row["vcSubsystem"])) echo "value =\"".htmlentities($row["vcSubsystem"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Sys:</h6>
								<input type="text" name="tag_sys" id="tag_sys" <?php if(isset($row["vcSystem"])) echo "value =\"".htmlentities($row["vcSystem"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Sys No:</h6>
								<input type="text" name="tag_sysno" id="tag_sysno" <?php if(isset($row["vcSystemNo"])) echo "value =\"".htmlentities($row["vcSystemNo"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Equip:</h6>
								<input type="text" name="tag_equip" id="tag_equip" <?php if(isset($row["vcEqpt"])) echo "value =\"".htmlentities($row["vcEqpt"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Equip No:</h6>
								<input type="text" name="tag_equipno" id="tag_equipno" <?php if(isset($row["vcEqptNo"])) echo "value =\"".htmlentities($row["vcEqptNo"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Addtl No:</h6>
								<input type="text" name="tag_addtlno" id="tag_adtlno" <?php if(isset($row["vcAdditionalCode"])) echo "value =\"".htmlentities($row["vcAdditionalCode"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>Component :</h6>
								<input type="text" name="tag_component" id="tag_component" <?php if(isset($row["vcComponent"])) echo "value =\"".htmlentities($row["vcComponent"])."\""; ?> readonly />
							</div>
							<div class="2u 12u$(xsmall)">
								<h6>ComponentNo:</h6>
								<input type="text" name="tag_componentno" id="tag_componentno" <?php if(isset($row["vcComponentNo"])) echo "value =\"".htmlentities($row["vcComponentNo"])."\""; ?> readonly />
							</div>
							<div class="3u 12u$(xsmall)">
								<h6>Unit Status:</h6>
								<input type="text" name="tag_unit_status" id="tag_unit_status" <?php if(isset($row["vcUnitStatus"])) echo "value =\"".htmlentities($row["vcUnitStatus"])."\""; ?> readonly />
							</div>
							<div class="3u$">
								<div class="select-wrapper">
									<h6>Existing jumpers :</h6>
									<?php $tag_jumpers = get_jumpers_for_tag($row["chUnit"], $row["vcSubsystem"], $row["vcSystem"], $row["vcSystemNo"], $row["vcEqpt"], $row["vcEqptNo"]); ?>
									<select name="existing_jumpers" id="existing_jumpers">
										<option value="">- Jumpers -</option>
										<?php 
											while($jmpr = mysqli_fetch_assoc($tag_jumpers)) {
												if(isset($jmpr["vcJumperNo"])&&!isset($jmpr["vcPostNormalizedby"])) {
													echo "<option value=\"1\">{$jmpr["vcJumperNo"]}</option>";
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="12u 12u$(xsmall)">
								<h4>Tag Description :</h4>
								<input type="text" name="tag_desc" id="tag_desc" <?php if($tag_desc != null) echo "value =\"".htmlentities($tag_desc)."\""; ?> readonly />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Location of Modification :</h4>
								<input type="text" name="loc_mod" id="loc_mod" <?php if(isset($row["vcLocation"])) echo "value =\"".htmlentities($row["vcLocation"])."\""; ?> readonly />
							</div>
							<div class="6u 12u$(xsmall)">
								<h4>Reference Drawing :</h4>
								<input type="text" name="ref_drawing" id="ref_drawing" <?php if(isset($row["vcDrawing"])) echo "value =\"".htmlentities($row["vcDrawing"])."\""; ?> readonly />
							</div>
							<div class="8u 12u$(xsmall)">
								<h4>Reason for Temp Change :</h4>
								<input type="text" name="reason_temp_chng" id="reason_temp_chng" <?php if(isset($row["vcReason"])) echo "value =\"".htmlentities($row["vcReason"])."\""; ?> readonly />
							</div>
							<div class="4u 12u$(xsmall)">
								<h4>Proposed Till :</h4>
								<input type="text" name="proposed_till" id="proposed_till" <?php if(isset($row["vcProposedTill"])) echo "value =\"".htmlentities($row["vcProposedTill"])."\""; ?> readonly />
							</div>
							<div class="12u$">
								<h4>Remarks :</h4>
								<textarea name="remarks" id="remarks" rows="4" readonly ><?php if(isset($row["vcRemarks"])) echo htmlentities($row["vcRemarks"]); ?></textarea>
							</div>
							<br>
						</div>
						<br>
						<div class = "bordered">
							<h4>Proposed By :</h4>
							<div class = "row uniform">
								<div class="4u 12u$(xsmall)">
									<h6>Name :</h6>
									<input type="text" name="pro_by_name" id="pro_by_name"  <?php if(isset($row["vcProposedby"])) echo "value =\"".htmlentities($row["vcProposedby"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Section :</h6>
									<input type="text" name="pro_by_section" id="pro_by_section"  <?php if(isset($row["vcProposedbySection"])) echo "value =\"".htmlentities($row["vcProposedbySection"])."\""; ?> readonly />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Desig :</h6>
									<input type="text" name="pro_by_desig" id="pro_by_desig"  <?php if(isset($row["vcProposedbyDesig"])) echo "value =\"".htmlentities($row["vcProposedbyDesig"])."\""; ?> readonly />
								</div>
								<div class="3u 12u$(xsmall)">
									<h6>Date/Time :</h6>
									<input type="text" name="pro_by_date_time" id="pro_by_date_time"  <?php if(isset($row["vcProposedbyDate"])) echo "value =\"".htmlentities($row["vcProposedbyDate"])."\""; ?> readonly />
								</div>
							</div>
						</div>
						<br>
						<div class = "row uniform">
							<?php if(!isset($row["vcApprovedby"])) { ?>
								<div class="1.5u 12u$(xsmall)">
									<ul class="actions">
										<li ><a href = <?php echo "\"layout1_edit.php?jumperid={$_GET["jumperid"]}\""; ?> class = "button special">Edit</a></li>
									</ul>
								</div>
							<?php } ?>
							<div class="2u 12u$(xsmall)">
								<ul class="actions">
									<li ><a href = <?php echo "\"print.php?jumperid={$_GET["jumperid"]}\""; ?> class = "button special" target="blank">Print</a></li>
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
