<?php include("../includes/sessions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	require_once("../includes/validation_functions.php");
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
	if(!isset($_POST["search_submit"]))
		redirect_to("search.php");
	$flag = 0;
	if(!empty($_POST["jumper_no"])) {
		if(!preg_match("/^[0-9]{1}-[0-9]{2}-[CN]{1,2}-[0-9]{3}$/", $_POST["search_submit"])) {
			$_SESSION["error_messages"][] = "Invalid Jumper No.";
			$flag = 1;
		}
	}
	if(!empty($_POST["dr_no"])) {
		if(!preg_match("/^[0-9]{1}-[0-9]{2}-[0-9]{2}-[0-9a-zA-Z]{2}-[0-9]{3}$/", $_POST["dr_no"])) {
			$_SESSION["error_messages"][] = "Invalid DR-No.";
			$flag=1;
		}
		else if(check_drno($_POST["dr_no"]) === 0) {
			$_SESSION["error_messages"][] = "DR-No Not in database.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_unit"])) {
		if(!preg_match("/^[0-9]{1}$/", $_POST["tag_unit"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Unit.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_subsys"])) {
		if(!preg_match("/^[0-9]{1}$/", $_POST["tag_subsys"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Sub System.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_sys"])) {
		if(!preg_match("/^[0-9a-zA-Z]{3}$/", $_POST["tag_sys"])) {
			$_SESSION["error_messages"][] = "Invalid Tag System.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_sysno"])) {
		if(!preg_match("/^[0-9]{2}$/", $_POST["tag_sysno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag System Number.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_equip"])) {
		if(!preg_match("/^[0-9a-zA-Z]{1,2}$/", $_POST["tag_equip"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Equipment.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_equipno"])) {
		if(!preg_match("/^[0-9]{3}$/", $_POST["tag_equipno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Equiptment Number.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_addtlno"])) {
		if(!preg_match("/^[0-9a-zA-Z]{0,5}$/", $_POST["tag_addtlno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Additional Code.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_component"])) {
		if(!preg_match("/^[0-9a-zA-Z]{0,7}$/", $_POST["tag_component"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Component.";
			$flag = 1;
		}
	}
	if(!empty($_POST["tag_componentno"])) {
		if(!preg_match("/^[0-9a-zA-Z]{0,3}$/", $_POST["tag_componentno"])) {
			$_SESSION["error_messages"][] = "Invalid Tag Component No.";
			$flag = 1;
		}
	}
	if(!empty($_POST["date_ini_from"])) {
		$ini_from = date($_POST["date_ini_from"]);
		if(empty($_POST["date_ini_to"])) {
			$_SESSION[error_messages][] = "From Date Entered And To Date Not Entered in Initiation.";
			$flag=1;
		}
		else {
			$ini_to = date($_POST["date_ini_to"]);
			if($ini_from > $ini_to) {
				$_SESSION[error_messages][] = "From Date Cannot be Greater Than To Date in Initiation.";
				$flag=1;
			}
		}
	}
	if(empty($_POST["date_ini_from"]) && !empty($_POST["date_ini_to"])) {
		$_SESSION[error_messages][] = "To Date Entered And From Date Not Entered in Initiation.";
		$flag=1;
	}
	if(!empty($_POST["date_app_from"])) {
		$app_from = date($_POST["date_app_from"]);
		if(empty($_POST["date_app_to"])) {
			$_SESSION[error_messages][] = "From Date Entered And To Date Not Entered in Approval.";
			$flag=1;
		}
		else {
			$app_to = date($_POST["date_app_to"]);
			if($app_from > $app_to) {
				$_SESSION[error_messages][] = "From Date Cannot be Greater Than To Date in Approval.";
				$flag=1;
			}
		}
	}
	if(empty($_POST["date_app_from"]) && !empty($_POST["date_app_to"])) {
		$_SESSION[error_messages][] = "To Date Entered And From Date Not Entered in Approval.";
		$flag=1;
	}
	if(!empty($_POST["date_iss_from"])) {
		$iss_from = date($_POST["date_iss_from"]);
		if(empty($_POST["date_iss_to"])) {
			$_SESSION[error_messages][] = "From Date Entered And To Date Not Entered in Issue.";
			$flag=1;
		}
		else {
			$iss_to = date($_POST["date_iss_to"]);
			if($iss_from > $iss_to) {
				$_SESSION[error_messages][] = "From Date Cannot be Greater Than To Date in Issue.";
				$flag=1;
			}
		}
	}
	if(empty($_POST["date_iss_from"]) && !empty($_POST["date_iss_to"])) {
		$_SESSION[error_messages][] = "To Date Entered And From Date Not Entered in Issue.";
		$flag=1;
	}
	if(!empty($_POST["date_imp_from"])) {
		$imp_from = date($_POST["date_imp_from"]);
		if(empty($_POST["date_imp_to"])) {
			$_SESSION[error_messages][] = "From Date Entered And To Date Not Entered in Implementation.";
			$flag=1;
		}
		else {
			$imp_to = date($_POST["date_imp_to"]);
			if($imp_from > $imp_to) {
				$_SESSION[error_messages][] = "From Date Cannot be Greater Than To Date in Implementation.";
				$flag=1;
			}
		}
	}
	if(empty($_POST["date_imp_from"]) && !empty($_POST["date_imp_to"])) {
		$_SESSION[error_messages][] = "To Date Entered And From Date Not Entered in Implementation.";
		$flag=1;
	}
	if(!empty($_POST["date_nor_from"])) {
		$nor_from = date($_POST["date_nor_from"]);
		if(empty($_POST["date_nor_to"])) {
			$_SESSION[error_messages][] = "From Date Entered And To Date Not Entered in Normalization.";
			$flag=1;
		}
		else {
			$nor_to = date($_POST["date_nor_to"]);
			if($nor_from > $nor_to) {
				$_SESSION[error_messages][] = "From Date Cannot be Greater Than To Date in Normalization.";
				$flag=1;
			}
		}
	}
	if(empty($_POST["date_nor_from"]) && !empty($_POST["date_nor_to"])) {
		$_SESSION[error_messages][] = "To Date Entered And From Date Not Entered in Normalization.";
		$flag=1;
	}
	if($flag) {
		redirect_to("search.php");
	}
	
	$query = "select * from jumperdr where ";
	if(!empty($_POST["jumper_no"])) {
		$query .= "vcJumperNo = '{$_POST["jumper_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcDRNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["category"])) {
		$query .= "chCategory = '{$_POST["category"]}' and "
	}
	if(!empty($_POST["tag_unit"])) {
		$query .= "chUnit = '{$_POST["tag_unit"]}' and "
	}
	if(!empty($_POST["tag_subsys"])) {
		$query .= "vcSubSystem = '{$_POST["tag_subsys"]}' and "
	}
	if(!empty($_POST["tag_sys"])) {
		$query .= "vcSystem = '{$_POST["tag_sys"]}' and "
	}
	if(!empty($_POST["tag_sysno"])) {
		$query .= "vcSystemNo = '{$_POST["tag_sysno"]}' and "
	}
	if(!empty($_POST["tag_equip"])) {
		$query .= "vcEqpt = '{$_POST["tag_equip"]}' and "
	}
	if(!empty($_POST["tag_equipno"])) {
		$query .= "vcEqptNo = '{$_POST["tag_equipno"]}' and "
	}
	if(!empty($_POST["tag_addtlno"])) {
		$query .= "vcAdditionalCode = '{$_POST["tag_addtlno"]}' and "
	}
	if(!empty($_POST["tag_component"])) {
		$query .= "vcComponent = '{$_POST["tag_component"]}' and "
	}
	if(!empty($_POST["tag_componentno"])) {
		$query .= "vcComponentNo = '{$_POST["tag_componentno"]}' and "
	}
	///// start here
	
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
	if(!empty($_POST["dr_no"])) {
		$query .= "vcJumperNo = '{$_POST["dr_no"]}' and "
	}
?>