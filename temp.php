<?php
if ($_POST['parktrails']){

echo "Recommended Trails for " . $_POST['parktrails'] . '<br/>';	

}	

?>

<?php
if (strcasecmp($_POST['parktrails'], 'Grand Teton National Park') == 0){
?>

<html>
<head>
<title>
Trail recommendation
</title>
</head>
<form method ="post" action ="grandteton.php">
<br/>
<li/><input type="submit" value="Easy" name="1"><br/>
<br/>
<li/><input type="submit" value="Moderate" name="2"><br/>
<br/>
<li/><input type="submit" value="Strenuous" name="3">
</form>
</body>
<?php
}
?>

<?php
if (strcasecmp($_POST['parktrails'], 'Glacier National Park') == 0){
?>

<html>
<head>
<title>
Trail recommendation
</title>
</head>
<form method ="post" action ="glacierpark.php">
<br/>
<li/><input type="submit" value="Easy" name="1"><br/>
<br/>
<li/><input type="submit" value="Moderate" name="2"><br/>
<br/>
<li/><input type="submit" value="Strenuous" name="3">
</form>
</body>
<?php
}
?>



