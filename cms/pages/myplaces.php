<?php if(!strlen($_SESSION["SESS_USERNAME"]) > 0)header("location: ../home.php"); 
if (isset($_GET['getall'])&& $_SESSION["SESS_ROLE"] == 1) {$getall = 1;}else $getall =0; ?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="css/blue.css" rel="stylesheet">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script>
	$(function(){
		$('table').tablesorter({
			theme: 'blue',
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true
		});
	});
	</script>
    <h2>Mijn plaatsen</h2>
    <form action="" method="post">
    <table class="tablesorter">
	<thead><tr>
			<th>Selecteren</th>
			<th>Plaats</th>
			<th wdit>Beschrijving</th>
			<th>Wijzigings datum</th>
			</tr>
	</thead>
	<tbody>
    <?php	
	if($getall > 0) {if(!$rs = mysql_query("SELECT ID,title,info,modified_date FROM monumenten")){echo "Cannot parse query";}
	} else {
		if(!$rs = mysql_query("SELECT ID,title,info,modified_date FROM monumenten WHERE userid='" . $_SESSION["SESS_USERID"] . "'")){echo "Cannot parse query";}
		}
		if(mysql_num_rows($rs) == 0) {echo "U heeft geen plaatsen.";} else{while($row = mysql_fetch_array($rs)) {
	echo'

					<tr>
						<td><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$row['ID'].'"></td>
						<td><a href="home.php?page=editplace&id='.$row['ID'].'">'. $row['title'] .'</a></td>
						<td><a href="home.php?page=editplace&id='.$row['ID'].'">'. substr(strip_tags($row['info']),0, 60) . '...'.'</a></td>
						<td>'. $row['modified_date'] .'</td>
					</tr>
		';
			}} ?>
	</tbody>
	</table>
    <input type="submit" name="submit" class="save" value="Verwijder geselecteerde" style="margin-right: 120px;"></input>
    <?php if($_SESSION["SESS_ROLE"] == 1) echo'<a class="button" style="float:right;" href="home.php?page=myplaces&getall=1">Toon alle monumenten</a>'; ?>
    </form>
    <?php
	$checkbox = $_POST['checkbox'];
if(isset($_POST['submit'])){
for($i=0;$i<count($checkbox);$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM monumenten WHERE ID='$del_id'";
$result = mysql_query($sql);
if($result){
echo "<meta http-equiv='refresh'content='0'>";
}
}
}
?>