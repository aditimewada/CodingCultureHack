
<?php include 'conn.php';
include("add.php");
?>
 
<?php
 

 
//Execute the query
$id=$_POST['id'];
$iid = $_POST['iid'];
$title=$_POST['title'];
$desc=$_POST['desc'];
$period=$_POST['period'];
$city=$_POST['city'];
$gallery=$_POST['gallery'];
$dimension=$_POST['dimension'];
$artist=$_POST['artist'];
$material=$_POST['material'];
$accession=$_POST['accession'];
$clue=$_POST['clue'];
 
mysqli_query($conn,"INSERT INTO data (id,inventory_id,title,description,period,city,gallery,dimension,artist,material,accession_no,clue)
		        VALUES ('$id','$iid','$title','$desc','$period','$city','$gallery','$dimension','$artist','$material','$accession','$clue')");
				
	if(mysqli_affected_rows($conn) > 0){
      echo '<script language="javascript">';   
echo 'alert("data uploaded")';
echo '</script>';
  /*header('Location:../Admin panel/addimg.php');  */

} else {
	echo "Employee NOT Added<br />";
	echo mysqli_error ($conn);
}
?>