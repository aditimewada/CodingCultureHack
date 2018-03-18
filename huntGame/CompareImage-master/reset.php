<html>
<head>
      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
    @import "compass/css3";

/*Be sure to look into browser prefixes for keyframes and annimations*/
.flash {
   animation-name: flash;
    animation-duration: 0.8s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-play-state: running;
}

@keyframes flash {
    from {color: limegreen;}
    to {color: black;}
}
        body{
            background-image: url(../img/t.jpg.v1.jpg);
            background-attachment: inherit;
            max-width: inherit;
            max-height: inherit;
}
    </style>
    </head>
<body>
    <h1 class="flash" style="text-align: center;font-size: 70px">WELL PLAYED&#9819;</h1>
    <form method="POST" action="">
        <div align="center">
             <input type="submit" value="PlayAgain" name="button1" align="middle" class="w3-button w3-black" style="border-radius: 12px;padding: 15px 32px; font-size: 30px;margin: 4px 2px; cursor: pointer;"/> 
            </div>
            </form>
    </body>
</html>
<?php
 include('conn.php');

if (isset($_POST['button1'])) 
{ 
   //echo "button 1 has been pressed";
  $sql1="UPDATE data SET cluedisp = '0'";
    $sql2="UPDATE counter set count ='5' where id = '1'"; 
      $sql3="UPDATE counter set count ='10' where id = '3'"; 
    
     if ($conn->query($sql1) === TRUE) {
   // echo "Record updated successfully";
} else {
   // echo "Error updating record: " . $conn->error;
}
    
     if ($conn->query($sql2) === TRUE) {
   // echo "Record updated successfully";
} else {
   // echo "Error updating record: " . $conn->error;
}
    
      if ($conn->query($sql3) === TRUE) {
   // echo "Record updated successfully";
} else {
   // echo "Error updating record: " . $conn->error;
}
 
header("Location: ../index.php");
} 

?>