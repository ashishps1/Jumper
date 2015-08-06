<?php
	session_start();
	
	function error_messages() {
		if(isset($_SESSION["error_messages"])) {
			$output = $_SESSION["error_messages"];
			$_SESSION["error_messages"] = null;
			return $output;
		}
	}
	
	function message() {
		
		if(!isset($_SESSION["message_color"])) {
			$_SESSION["message_color"] = null;
		}
		if(isset($_SESSION["message"])) {
			if($_SESSION["message_color"] === "red") {
				$color = $_SESSION["message_color"];
				$output = "<div class = \"bordered\" align = center><h4><font color =\"#ec4b2e\">";
				$output .= htmlentities($_SESSION["message"]);
				$output .= "</font><h4></div><br>";
			}
			else if($_SESSION["message_color"] === "green") {
				$color = $_SESSION["message_color"];
				$output = "<div class = \"bordered\" align = center><h4><font color =\"#36ad65\">";
				$output .= htmlentities($_SESSION["message"]);
				$output .= "</font><h4></div><br>";
			}
			else {
				$output = "<div class = \"inner\" align = center ><h4>* ";
				$output .= htmlentities($_SESSION["message"]);
				$output .= "<h4></div><br>";
			}
			$_SESSION["message_color"] = null;
			$_SESSION["message"] = null;
			return $output;
		}
	}
?>