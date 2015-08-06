<?php
	function form_errors($errors = array()) {
		$output = "";
		if(!empty($errors)) {
			$output .= "<div class = \"bordered\"><div class = \"inner\" align = center ><h4><font color =\"#ec4b2e\">";
			$output .= "Your form appears to have the following errors : </h4><h6></div><div align = \"left\"><ul>";
			foreach($errors as $key => $error) {
				$safe_error = htmlentities($error);
				$output .= "<li>{$safe_error}</li>";
			}
			$output .= "</ul></font></h6></div></div><br>";
		}
		return $output;
	}
	
	function redirect_to($new_location) {
		header("Location: ".$new_location);
		exit;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: ");
		}
	}
	
	function get_all_jumpers() {
		global $connection;
		
		$query = "SELECT * FROM jumperdr";
		$page_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function get_jumpers_for_dr($drno) {
		global $connection;
		$query = "SELECT * FROM jumperdr WHERE vcDRNo = '{$drno}'";
		$page_set = mysqli_query($connection, $query);
		if(!$page_set) {
			die("database query fail. ". mysqli_error($connection));
		}
		if(mysqli_affected_rows($connection) == 0)
			return null;
		return $page_set;
	}
	
	function get_jumpers_for_tag($chUnit, $vcSubsystem, $vcSystem, $vcSystemNo, $vcEqpt, $vcEqptNo) {
		global $connection;
		$query = "SELECT * FROM jumperdr WHERE chUnit = '{$chUnit}' and vcSubsystem = '{$vcSubsystem}' and vcSystem = '{$vcSystem}' and vcSystemNo = '{$vcSystemNo}' and vcEqpt = '{$vcEqpt}' and vcEqptNo = '{$vcEqptNo}'";
		$page_set = mysqli_query($connection, $query);
		if(!$page_set)
			die("Database query failed: ".mysqli_error($connection));
		if(mysqli_affected_rows($connection) == 0)
			return null;
		return $page_set;
	}

	function get_jumpers_for_jumper($jumperNo) {
		global $connection;
		$query = "SELECT * FROM jumperdr WHERE vcJumperNo = '{$jumperNo}' ";
		$page_set = mysqli_query($connection, $query);
		if(!$page_set)
			die("Database query failed123: ".mysqli_error($connection));
		if(mysqli_affected_rows($connection) == 0)
			return null;
		return $page_set;
	}

	function get_jumpers_for_date($date) {
		global $connection;
		$query = "SELECT * FROM jumperdr WHERE Date(vcProposedbyDate) = '{$date}' ";
		$page_set = mysqli_query($connection, $query);
		if(!$page_set)
			die("Database query failed: ".mysqli_error($connection));
		if(mysqli_affected_rows($connection) == 0)
			return null;
		return $page_set;
	}
	
	function get_jumpers_for_employee ($username) {
		global $connection;
		global $connection2;
		$query = "SELECT * FROM tabEmployee WHERE vcEmployeeNo = '{$username}' ";
		$page_set =  odbc_exec($connection2, $query);
		if(!$page_set)
			die("Database query failed at get_jumpers_for_employee.");
		if(odbc_num_rows($page_set) == 0)
			return null;
		odbc_fetch_row($page_set);
		$name = substr(odbc_result($page_set, 3), 0, 10);
		$query2 = "SELECT * FROM jumperdr WHERE vcProposedby = '{$name}' ";
		$page_set2 = mysqli_query($connection, $query2);
		if(!$page_set2)
			die("Database query failed: ". mysqli_error($connection));
		if(mysqli_affected_rows($connection) == 0)
			return null;
		return $page_set2;
	}
	
	function check_drno($drno) {
		global $connection2;
		$query = "SELECT * FROM TabDeficiencyReportMaster WHERE vcDRNo = '{$drno}'";
		$page_set = odbc_exec($connection2, $query);
		if (!$page_set) {
			die("Database query failed at check_drno.");
		}
		if(odbc_fetch_row($page_set))
			return 1;
		return 0;
	}

	function check_drno_approval($drno) {
		global $connection2;
		$query = "SELECT * FROM TabDeficiencyReportMaster WHERE vcDRNo = '{$drno}'";
		$page_set = odbc_exec($connection2, $query);
		if (!$page_set) {
			die("Database query failed at check_drno_approval.");
		}
		if(odbc_fetch_row($page_set))
			if(odbc_result($page_set, 53) == null)
				return 1;
		return 0;
	}

	function check_tagno($cUnit, $vSubSystem, $vSystem, $vSystemNo, $vEqpt, $vEqptNo) {
		global $connection2;
		$query = "SELECT * FROM tabTag WHERE chUnit = '{$cUnit}' and vcSubSystem = '{$vSubSystem}' and vcSystem = '{$vSystem}' and vcSystemNo = '{$vSystemNo}' and vcEqpt = '{$vEqpt}' and vcEqptNo = '{$vEqptNo}'";
		$page_set = odbc_exec($connection2, $query);
		if (!$page_set) {
			die("Database query failed at check_tagno.");
		}
		if(odbc_fetch_row($page_set))
			return 1;
		return 0;
	}
	
	function insert_into_layout1($proposed_till, $jumper_desc, $dr_no, $tag_unit, $tag_subsys, $tag_sys, $tag_sysno, $tag_equip, $tag_equipno, $tag_addtlno, $tag_component, $tag_componentno, $loc_mod, $ref_drawing, $reason_temp_chng, $remarks, $unit_status) {
		global $connection;
		$date = date('Y-m-d H:i:s');
		$query = "insert into jumperdr ( ";
		$query .= "intJumperID, vcDescription, vcDRNo, chUnit, vcSubSystem, vcSystem, vcSystemNo, vcEqpt, vcEqptNo, vcAdditionalCode, vcComponent, vcComponentNo,  vcLocation, vcDrawing, vcReason, vcRemarks, vcProposedby, vcProposedbyDesig, vcProposedbySection, vcProposedbyDate, vcProposedTill, vcUnitStatus, vcStatus";
		$query .= ") values ( ";
		$query .= mysqli_insert_id($connection).", \"{$jumper_desc}\", \"{$dr_no}\", \"{$tag_unit}\", \"{$tag_subsys}\", \"{$tag_sys}\", \"{$tag_sysno}\", \"{$tag_equip}\", \"{$tag_equipno}\", \"{$tag_addtlno}\", \"{$tag_component}\", \"{$tag_componentno}\", \"{$loc_mod}\", \"{$ref_drawing}\", \"{$reason_temp_chng}\", \"{$remarks}\", \"{$_SESSION["username"]}\", \"{$_SESSION["userDesig"]}\", \"{$_SESSION["userSection"]}\", \"{$date}\", \"{$proposed_till}\", \"{$unit_status}\", \"NEW\" ";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		return mysqli_insert_id($connection);
	}
	
	function update_into_layout1($intJumperID, $proposed_till, $jumper_desc, $dr_no, $tag_unit, $tag_subsys, $tag_sys, $tag_sysno, $tag_equip, $tag_equipno, $tag_addtlno, $tag_component, $tag_componentno, $loc_mod, $ref_drawing, $reason_temp_chng, $remarks, $unit_status) {
		global $connection;
		$date = date('Y-m-d H:i:s');
		$query = "update jumperdr set ";
		$query .= "vcDescription = '{$jumper_desc}', ";
		$query .= "vcDRNo = '{$dr_no}', ";
		$query .= "chUnit = '{$tag_unit}', ";
		$query .= "vcSubSystem = '{$tag_subsys}', ";
		$query .= "vcSystem = '{$tag_sys}', ";
		$query .= "vcSystemNo = '{$tag_sysno}', ";
		$query .= "vcEqpt = '{$tag_equip}', ";
		$query .= "vcEqptNo = '{$tag_equipno}', ";
		$query .= "vcAdditionalCode = '{$tag_addtlno}', ";
		$query .= "vcComponent = '{$tag_component}',  ";
		$query .= "vcComponentNo = '{$tag_componentno}', ";
		$query .= "vcLocation = '{$loc_mod}', ";
		$query .= "vcDrawing = '{$ref_drawing}', ";
		$query .= "vcReason = '{$reason_temp_chng}', ";
		$query .= "vcRemarks = '{$remarks}', ";
		$query .= "vcProposedby = '{$_SESSION["username"]}', ";
		$query .= "vcProposedbyDesig = '{$_SESSION["userDesig"]}', ";
		$query .= "vcProposedbySection = '{$_SESSION["userSection"]}', ";
		$query .= "vcProposedTill = '{$proposed_till}', ";
		$query .= "vcUnitStatus = '{$unit_status}', ";
		$query .= "vcProposedbyDate = '{$date}', ";
		$query .= "vcStatus = 'NEW' ";
		$query .= "where intJumperID = {$intJumperID}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
	}
	
	function set_jumperno($jumperid, $vcCategory) {
		global $connection;
		$query = "Select * from jumperdr where intJumperID = {$jumperid} limit 1" ;
		$result = mysqli_query($connection, $query);
		if(!$result)
			die("database failed at layou1_edit form starting.".mysqli_error($conncetion));
		$row = mysqli_fetch_assoc($result);
		$search_key = substr($row["vcDRNo"], 0, 5) . $vcCategory;
		$query2 = "UPDATE jumperdr SET ";
		$query2 .= "vcTempJumperNo = '{$search_key}' ";
		$query2 .= "where intJumperID = {$jumperid}";
		$result2 = mysqli_query($connection, $query2);
		if(!$result2) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		$query3 = "SELECT COUNT(*) AS 'count' FROM jumperdr where vcTempJumperNo = '{$search_key}'";
		$result3 = mysqli_query($connection, $query3);
		if(!$result3) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		$row2 = mysqli_fetch_assoc($result3);
		$serial = (int) $row2["count"];
		if($serial > 999) {
			die("999 Jumpers of this order already exist!".mysqli_error($connection));
		}
		$jumperno_final = sprintf("%s-%03d", $search_key, $serial);
		$query4 = "UPDATE jumperdr SET ";
		$query4 .= "vcJumperNo = '{$jumperno_final}' ";
		$query4 .= "where intJumperID = {$jumperid}";
		$result4 = mysqli_query($connection, $query4);
		if(!$result4) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
	}
	
	function set_auth() {
		
		global $connection2;
		$query = "select * from tabDrModulePrivilege where vcGroupId = '{$_SESSION["userGroup"]}' and vcControl = 'MCRI' ";
		$result = odbc_exec($connection2, $query);
		if (!$result) {
			die("Database query failed at set_auth.");
		}
		odbc_fetch_row($result, 0);
		$res = "";
		//for post normalization auth of 9
		if(odbc_result($result, 9) == "Y") {
			$res .= "9";
		}
		//for normalization auth of 8
		if(odbc_result($result, 6) == "Y") {
			$res .= "8";
		}
		//for normalization approval auth of 7
		if(odbc_result($result, 5) == "Y") {
			$res .= "7";
		}
		//for implementing auth of 6
		if(odbc_result($result, 6) == "Y") {
			$res .= "6";
		}
		//for issuing auth of 5
		if(odbc_result($result, 5) == "Y") {
			$res .= "5";
		}
		//for cssd approving auth of 4
		if(odbc_result($result, 29) == "Y") {
			$res .= "4";
		}
		//for approving jumper auth of 3
		if(odbc_result($result, 5) == "Y") {
			$res .= "3";
		}
		//for creating and updating jumper auth of 2
		if(odbc_result($result, 4) == "Y") {
			$res .= "2";
		}
		//for quality assurance auth of 1
		if(odbc_result($result, 10) == "Y") {
			$res .= "1";
		}
		//for jrc recommendations
		if(odbc_result($result, 30) == "Y") {
			$res .= "A";
		}
		$_SESSION["auth"] = $res;
	}
		


	function check_auth($auth) {
		if(strpos($_SESSION["auth"], $auth) === 0 || strpos($_SESSION["auth"], $auth) > 0)
			return 1;
		return 0;
	}
	

	function check_login($username, $password) {
		global $connection2;
		$i = strlen($password)-1;
		$hash_password = "";
		for(;$i>=0;$i--) {
			$hash_password .= (string) ord(substr($password, $i));
		}
		
		$query = "SELECT * FROM tabUserHeader WHERE vcEmployeeCode = '{$username}' and vcPassword = '{$hash_password}'";
		$page_set = odbc_exec($connection2, $query);
		if (!$page_set) {
			die("Database query failed at check_login.");
		}
		
		if(odbc_fetch_row($page_set)) {
			$user_group = odbc_result($page_set, 2);
			$query2 = "SELECT * FROM tabEmployee WHERE vcEmployeeNo = '{$username}' ";

			$res = odbc_exec($connection2, $query2);
			if(odbc_fetch_row($res)) {
				
				$_SESSION["userNo"] = $username;
				$_SESSION["username"] = odbc_result($res, 3);
				$_SESSION["userDesig"] = odbc_result($res, 4);
				$_SESSION["userSection"] = odbc_result($res, 5);
				$_SESSION["userGroup"] = $user_group;
				$_SESSION["timeout"] = time();

				set_auth();
				return 1;
			}

		}
		return 0;
	}
	


	function check_session_timeout() {
		if($_SESSION["timeout"] + 1200 < time()) {
			$_SESSION["message"] = "Session Timeout, Please Login.";
			redirect_to("loginpage.php");
		}
	}
?>
