<?php include("../includes/sessions.php");?>
<?php// include("../includes/db_connection.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	/*require_once("../includes/validation_functions.php");
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();*/
?>
<style>
	.scrollable {
		height: 500px;
		overflow-y: auto;
	}
</style>

<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1_edit.php" class="button">New Jumper</a></li>
			<li><a href="search.php" class="button special">Search</a></li>
			<li><a href="logout.php" class="button">Log Out</a></li>
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
					<form name="chooseForm" id="chooseForm" method="post" action="search_results.php">
						<div class="row uniform">
							<div class="4u 12u$(xsmall)">
								<h4>Jumper No. :</h4>
								<input type="text" name="jumper_no" id="jumper_no" />
							</div>
							<div class="4u 12u$(xsmall)">
								<h4>DR No. :</h4>
								<input type="text" name="dr_no" id="dr_no" />
							</div>
							<div class= "1u 12u$(xsmall)"></div>
							<div class="1u 12u$(xsmall)">
								<h4>Category:</h4>
								<input type="radio" id="category_c" name="category" value = "C" >
								<label for="category_c">C</label>
							</div>
							<div class="2u 12u$(xsmall)">
								<h4>.</h4>
								<input type="radio" id="category_nc" name="category" value = "NC">
								<label for="category_nc">NC</label>
							</div>
						</div>
						<br><h4>Tag No :</h4>
						<div class = "bordered">
							<div class = "row uniform">
								<div class="1u 12u$(xsmall)">
									<h6>Unit:</h6>
									<input type="text" name="tag_unit" id="tag_unit" />
								</div>
								<div class="1u 12u$(xsmall)">
									<h6>SubSys:</h6>
									<input type="text" name="tag_subsys" id="tag_subsys" />
								</div>
								<div class="1u 12u$(xsmall)">
									<h6>Sys:</h6>
									<input type="text" name="tag_sys" id="tag_sys" />
								</div>
								<div class="1u 12u$(xsmall)">
									<h6>SysNo:</h6>
									<input type="text" name="tag_sysno" id="tag_sysno" />
								</div>
								<div class="1u 12u$(xsmall)">
									<h6>Eqpt:</h6>
									<input type="text" name="tag_equip" id="tag_equip" />
								</div>
								<div class="1u 12u$(xsmall)">
									<h6>EqptNo:</h6>
									<input type="text" name="tag_equipno" id="tag_equipno" />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Addln:</h6>
									<input type="text" name="tag_addtlno" id="tag_adtlno" />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>Compo:</h6>
									<input type="text" name="tag_component" id="tag_component" />
								</div>
								<div class="2u 12u$(xsmall)">
									<h6>CompoNo:</h6>
									<input type="text" name="tag_componentno" id="tag_componentno" />
								</div>
							</div>
						</div>
						<h4>Waiting for: </h4>
						<div class = "bordered">
							<div class="row uniform">
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_app" name="wait_app" value = "Y" >
									<label for="wait_app">Approval</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_cssd" name="wait_cssd" value = "Y" >
									<label for="wait_cssd">CS/SD</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_iss" name="wait_iss" value = "Y" >
									<label for="wait_iss">Issue</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_imp" name="wait_imp" value = "Y" >
									<label for="wait_imp">Implementation</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_test" name="wait_test" value = "Y" >
									<label for="wait_test">Testing</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_nap" name="wait_nap" value = "Y" >
									<label for="wait_nap">Normalization Approval</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_nor" name="wait_nor" value = "Y" >
									<label for="wait_nor">Normalization</label>
								</div>
								<div class="1.5u 12u$(xsmall)">
									<input type="checkbox" id="wait_post" name="wait_post" value = "Y" >
									<label for="wait_post">Post Normalization</label>
								</div>
							</div>
						</div>
						<br><h4>Filter By Dates:</h4>
						<div class = "bordered">
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5><h5></div>
								<div class="3u 12u$(xsmall)">
									<h5>From:</h5>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<h5>To:</h5>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5>Initiaion: <h5></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_ini_from" class="date_ini_from" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_ini_to" class="date_ini_to" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5>Approval: <h5></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_app_from" class="date_app_from" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_app_to" class="date_app_to" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5>Issue: <h5></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_iss_from" class="date_iss_from" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_iss_to" class="date_iss_to" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5>Implementation: <h5></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_imp_from" class="date_imp_from" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_imp_to" class="date_imp_to" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
							<div class = "row uniform">
								<div class="3u 12u$(xsmall)"><h5>Normalization: <h5></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_nor_from" class="date_nor_from" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="2u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<div class="ui-widget-content form_pad"><input type="text" name="date_nor_to" class="date_nor_to" placeholder = "YYYY-MM-DD"/></div>
								</div>
								<div class="1u 12u$(xsmall)"></div>
							</div>
						</div>
						<br>
						<div class = "row uniform">
							<div class="4u 12u$(xsmall)"></div>
							<div class="2u 12u$(xsmall)">
								<ul class="actions">
									<li><input type="submit" name = "search_submit" value="Submit" class="special" /></li>
								</ul>
							</div>
							<div class="2u 12u$(xsmall)">
								<ul class="actions">
									<li><input type="submit" name = "search_print" value="Print" class="special" /></li>
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
