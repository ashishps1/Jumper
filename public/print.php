<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>


<?php
	require_once("../includes/validation_functions.php");
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	if(!isset($_GET["jumperid"])) {
		$_SESSION["message"] = "Error on print pag invalid, Jumper Id.";
		redirect_to("search.php");
	}
?>

<head>
<style>
hr{
    border: 0;
    border-bottom: 1px dashed #ccc;
    background: #999;
}

td
{
    padding:0 100px 0 15px;
}
td.space2{
	 padding:0 50px 0 15px;
}
td.space3, th.space3{
	 padding:0 150px 0 15px;
	  
	
}
td.space4{
	 padding:0 50px 0 15px;
}
@media print {
  /* style sheet for print goes here */
  .noprint {
    visibility: hidden;
  }
}
</style>

<script>
	function myPrint(){
		window.print();
	}
</script>
</head>
<h3 align="center">NPCIL</h3>
<h2 align="center">Kudankulam Nuclear Power Project</h2>
<h3 align="center">Jumper Detail</h3>
<hr>

<table>
<tr>
	<td class="space4"><?php echo "User Name : ".$_SESSION["username"] ; ?></td>
	<td class="space4">
		<?php
			$date = date('Y-m-d H:i:s');
			echo  "Timestamp: ".$date;
		?>	
	</td>
<tr>
</table>
<hr>

<?php
	if(isset($_GET["jumperid"])) {
		global $connection;
		$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
		$result = mysqli_query($connection, $query);
		if(!$result)
			die("database failed at layou1_edit form starting.".mysqli_error($conncetion));
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
<table>
	<tr>
		<td><h4>Jumper No. : <?php if(isset($row["vcJumperNo"])) echo htmlentities($row["vcJumperNo"]);?></h4>
		</td>
		<td>
		<h4>Jumper Description : <?php if(isset($row["vcDescription"])) echo htmlentities($row["vcDescription"]); ?></h4>
		
		</td>
		<td>
		<h4>DR No. : <?php if(isset($row["vcDRNo"])) echo htmlentities($row["vcDRNo"]); ?></h4>
		
		</td>
	</tr>
</table>
<br>
<br>
<table>
<tr>
<th>Tag No :<th>
	<td class="space2">
		<h5>Unit :</h5>
		<?php if(isset($row["chUnit"])) echo htmlentities($row["chUnit"]); ?>
	</td>
	<td class="space2">
		<h5>Sub Sys:</h5>
		<?php if(isset($row["vcSubsystem"])) echo htmlentities($row["vcSubsystem"]); ?>
	</td>
	<td class="space2"> 
		<h5>Sys:</h5>
		<?php if(isset($row["vcSystem"])) echo htmlentities($row["vcSystem"]); ?>
	</td>
	<td class="space2">
		<h5>Sys No:</h5>
		<?php if(isset($row["vcSystemNo"])) echo htmlentities($row["vcSystemNo"]); ?>
	</td >
	<td class="space2">
		<h5>Equip:</h5>
		<?php if(isset($row["vcEqpt"])) echo htmlentities($row["vcEqpt"]); ?>
	</td>
	<td class="space2">
		<h5>Equip No:</h5>
		<?php if(isset($row["vcEqptNo"])) echo htmlentities($row["vcEqptNo"]); ?>
	</td>
	<td class="space2">
		<h5>Addtl No:</h5>
		<?php if(isset($row["vcAdditionalCode"])) echo htmlentities($row["vcAdditionalCode"]); ?>
	</td>
	<td class="space2">
		<h5>Component :</h5>
		<?php if(isset($row["vcComponent"])) echo htmlentities($row["vcComponent"]); ?>
	</td>
	<td class="space2">
		<h5>ComponentNo:</h5>
		<?php if(isset($row["vcComponentNo"])) echo htmlentities($row["vcComponentNo"]); ?> 
	</td>
		<td class="space2">
		<h5>Unit Status:</h5>
		<?php if(isset($row["vcUnitStatus"])) echo htmlentities($row["vcUnitStatus"]); ?>
	</td>

</table>
<br>	
	<!--<div class="12u 12u$(xsmall)">
		<h4>Tag Description :</h4>
		<?php// if($tag_desc != null) echo htmlentities($tag_desc); ?>
	</div>-->
	<div class="6u 12u$(xsmall)">
		<h4>Location of Modification : <?php if(isset($row["vcLocation"])) echo htmlentities($row["vcLocation"]); ?></h4>
		
	</div>
	<div class="6u 12u$(xsmall)">
		<h4>Reference Drawing : <?php if(isset($row["vcDrawing"])) echo htmlentities($row["vcDrawing"]); ?></h4>
		
	</div>
	<div class="8u 12u$(xsmall)">
		<h4>Reason for Temp Change : <?php if(isset($row["vcReason"])) echo htmlentities($row["vcReason"]); ?></h4>
		
	</div>
	<div class="4u 12u$(xsmall)">
		<h4>Proposed Till : <?php if(isset($row["vcProposedTill"])) echo htmlentities($row["vcProposedTill"]); ?></h4>
		
	</div>
	<div class="12u$">
		<h4>Remarks : <?php if(isset($row["vcRemarks"])) echo htmlentities($row["vcRemarks"]); ?></textarea></h4>
		
	</div>
	<div class="12u 12u$(xsmall)">
		<h4>JRC Recommendation: <?php if(isset($row["vcJRCDescription"])) echo htmlentities($row["vcJRCDescription"]); ?></h4>
		
	</div>
	<br>
</div>

<table cellspacing="15">

<thead>
<tr>
<th scope="col" class="space3"></th>
<th scope="col" class="space3">Name</th>
<th scope="col" class="space3">Section</th>
<th scope="col" class="space3">Desig</th>
<th scope="col" class="space3">Date/time</th>
</tr>
</thead>
<tbody>
<!-- <tr>
 <th scope="row">Proposed By</th>
<td > <?php if(isset($row["vcNorApprovedby"])) echo htmlentities($row["vcNorApprovedby"]); ?></td>
<td> <?php if(isset($row["vcNorApprovedby"])) echo htmlentities($row["vcNorApprovedby"]); ?></td>
<td> <?php if(isset($row["vcNorApprovedby"])) echo htmlentities($row["vcNorApprovedby"]); ?></td>
<td> <?php if(isset($row["vcNorApprovedby"])) echo htmlentities($row["vcNorApprovedby"]); ?></td>
</tr> -->
<tr>
<th scope="row" >Approved By</th>
<td class="space3" nowrap="nowrap"> <?php if(isset($row["vcApprovedby"])) echo htmlentities($row["vcApprovedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcApprovedbySection"])) echo htmlentities($row["vcApprovedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcApprovedbyDesig"])) echo htmlentities($row["vcApprovedbyDesig"]); ?></td>
<td class="space3" nowrap="nowrap"> <?php if(isset($row["vcApprovedbyDate"])) echo htmlentities($row["vcApprovedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Issued By</th>
<td class="space3"d> <?php if(isset($row["vcIssedby"])) echo htmlentities($row["vcIssedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcIssedbySection"])) echo htmlentities($row["vcIssedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcIssedbyDesig"])) echo htmlentities($row["vcIssedbyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcIssedbyDate"])) echo htmlentities($row["vcIssedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Implemented By</th>
<td class="space3"> <?php if(isset($row["vcImplementedby"])) echo htmlentities($row["vcImplementedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcImplementedbySection"])) echo htmlentities($row["vcImplementedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcImplementedbyDesig"])) echo htmlentities($row["vcImplementedbyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcImplementedbyDate"])) echo htmlentities($row["vcImplementedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Normalization Approved By</th>
<td class="space3"> <?php if(isset($row["vcNorApprovedby"])) echo htmlentities($row["vcNorApprovedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNorApprovedbySection"])) echo htmlentities($row["vcNorApprovedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNorApprovedbyDesig"])) echo htmlentities($row["vcNorApprovedbyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNorApprovedbyDate"])) echo htmlentities($row["vcNorApprovedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Normalization By</th>
<td class="space3"> <?php if(isset($row["vcNormalizedby"])) echo htmlentities($row["vcNormalizedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNormalizedbySection"])) echo htmlentities($row["vcNormalizedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNormalizedbyDesig"])) echo htmlentities($row["vcNormalizedbyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcNormalizedbyDate"])) echo htmlentities($row["vcNormalizedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Post Normalized By</th>
<td class="space3"> <?php if(isset($row["vcPostNormalizedby"])) echo htmlentities($row["vcPostNormalizedby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcPostNormalizedbySection"])) echo htmlentities($row["vcPostNormalizedbySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcPostNormalizedbyDesig"])) echo htmlentities($row["vcPostNormalizedbyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcPostNormalizedbyDate"])) echo htmlentities($row["vcPostNormalizedbyDate"]); ?></td>
</tr>
<tr>
<th scope="row">Testing Done By</th>
<td class="space3"> <?php if(isset($row["vcTestingDoneby"])) echo htmlentities($row["vcTestingDoneby"]); ?></td>
<td class="space3"> <?php if(isset($row["vcTestingDonebySection"])) echo htmlentities($row["vcTestingDonebySection"]); ?></td>
<td class="space3"> <?php if(isset($row["vcTestingDonebyDesig"])) echo htmlentities($row["vcTestingDonebyDesig"]); ?></td>
<td class="space3"> <?php if(isset($row["vcTestingDonebyDate"])) echo htmlentities($row["vcTestingDonebyDate"]); ?></td>
</tr>
</tbody>
</table>
<br>
<div class="print-button" align="center">
	<button class="noprint" type="submit" onclick="myPrint()" ><img src="assets/css/images/print_icon.png">Print</button>
</div>

