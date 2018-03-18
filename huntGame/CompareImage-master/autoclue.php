<html><head>
      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body{
            background-image: url(../img/t.jpg.v1.jpg);
            background-attachment: inherit;
            max-width: inherit;
            max-height: inherit;
        }
    </style>
    </head></html>
<?php
 include('conn.php');

//include('displayimg.php');

  $count_sql1=$conn->query("select count from counter where id='1'");
            $row2 = $count_sql1->fetch_assoc();
            $count = $row2['count'];

$queryp =$conn->query( "SELECT * FROM counter where id='3'");//points
 $rowp = $queryp->fetch_assoc();    
 $point = $rowp['count'];
?>

<div align="center">
<h1 class="flash" style="text-align: center;font-size: 90px"><?php echo $point ?></h1>

<?php
if($count>'0')
{

    a:?>
<?php $query = $conn->query("SELECT * FROM data  
ORDER BY RAND ( )  
LIMIT 1");?>



<?php
$row = $query->fetch_assoc();
if($row['cluedisp']==0)
{  // echo $row['clue'];
    //echo $row['id'];
    $id = $row['id'];
     $query2 = $conn->query("SELECT * FROM imgdata where id=$id");
    $row2 = $query2->fetch_assoc();
    $image1 = 'Upload/img'.$row2["name"];
    ?></div><!-- image removed after some interval -->
<html>
    <body>
    <h3 style="font-family:courier ; color:black"><b><?php echo $row['clue']; ?></b></h3>
    <div class="w3-container">
    <div style='float: left;'>
    <form method="POST" action='capcam/index.php'>   
     <input type="submit" value="Unlock Me &#9919;" name="butt" align="center" class="w3-button w3-black" style="border-radius: 12px;padding: 15px 15px; font-size: 20px;margin: 4px 2px; cursor: pointer;"/> 
         </form>
         </div>
          <div style='float: right;'>      
<form method="POST" action='reset.php'>
    <input type="submit" value="QUIT" name="butt" align="center" class="w3-button w3-black" style="border-radius: 12px;padding: 15px 15px; font-size: 20px;margin: 4px 2px; cursor: pointer;"/> </form></div></div>
       <!--  <div style='float: right;'>
             <form method="POST">
                 <input type="submit" value="HELP" name="button" align="center" class="w3-button w3-black" style="border-radius: 12px;padding: 15px 32px; font-size: 20px;margin: 4px 2px; cursor: pointer;"/></form>
         </div></div>-->
    <div align='center'>    
    <img id="heli" src="<?php echo $image1 ?>" alt="Isla Tabarca, Spain" class="jqPuzzle" width="420" height="420" style="align:middle;"/></div>
         <script>
            setTimeout(function() {
                document.getElementById('heli').style.display='none'
            }, 10*1000);
            
 function start(){
    window.timerID =  setInterval(function() {
    var aOpaque = document.getElementById('heli').style.opacity;
    aOpaque = aOpaque-.1;
    aOpaque = aOpaque.toFixed(1);   

document.getElementById('heli').style.opacity = aOpaque;

if(document.getElementById('heli').style.opacity<=0)
clearInterval(window.timerID);
},5000);
}           
window.onload = function(){start();}   
    </script>
    </body></html>
<?php
 $id=$row['id'];
 
    echo '<br>';
 
$sql=" UPDATE data SET cluedisp = '1'where id=$id"; 
$sql_id=$conn->query("UPDATE counter SET count = $id where id='2'"); 
 
 if ($conn->query($sql) === TRUE) {
   // echo "Record updated successfully";
     
     //counter variable
    $count_sql=$conn->query("select count from counter where id='1'");
            $row1 = $count_sql->fetch_assoc();
            $count = $row1['count'];
            $count = $count-1;
           $count_up= "UPDATE counter SET count=$count where id='1'";
                if ($conn->query($count_up) === TRUE) {
                       // echo "Record updated successfully of count";
                }
        
} else {
    echo "Error updating record: " . $conn->error;
}
 
 // Alter table  $row['cluedisp']=1;
}
else
{
    goto a;
}
}
else
{
        echo"FINISHED";
     
    header("Location: reset.php");
}
?>


