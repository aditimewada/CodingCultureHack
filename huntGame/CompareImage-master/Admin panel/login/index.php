<?php
	session_start();
	if(isset($_SESSION['login_user'])){
header("location: ../");
}
else
{
?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<script src="../assets/js/jquery.min.js"></script>
	<link rel="stylesheet" href="../assets/css/main.css">
	<link rel="stylesheet" href="../assets/css/login.css">
</head>
<body >
	<div id="main_login">
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-4 cmptr">
				<img src="../assets/img/b.png" class="pull-left" caption="d">
				<div class="panel pull-right pnldef lft">
					<sm>a</sm>
					<sm>d</sm>						
					<sm>d</sm>						
					<sm>+</sm>
					<sm class="btn-info">F12</sm>						
					<sm>@</sm>						
					<sm>del</sm>						
					<sm>F8</sm>						
					<sm>@</sm>						
					<sm>n</sm>
					<sm>j</sm>
					<sm>del</sm>						
					<sm>F3</sm>						
					<sm>@</sm>						
					<sm>h</sm>
					<sm>?</sm>
					<sm class="btn-danger">del</sm>						
					<br>
					<sm>a</sm>
					<sm>d</sm>						
					<sm>d</sm>						
					<sm>+</sm>
					<sm class="btn-info">add</sm>						
					<sm>@</sm>						
					<sm>del</sm>						
					<sm>F8</sm>						
					<sm>@</sm>						
					<sm>n</sm>
					<sm>j</sm>
					<br>
					<sm>a</sm>
					<sm>d</sm>						
					<sm>d</sm>						
					<sm>+</sm>
					<sm class="btn-primary">ins</sm>						
					<sm>@</sm>						
					<sm>@</sm>						
					<sm>n</sm>
					<sm>j</sm>
					<sm>del</sm>						
					<sm>F3</sm>						
					<sm>@</sm>						
					<sm>h</sm>
					<sm>?</sm>
					<sm class="btn-default">Home</sm>						
					<br>
					<sm>u</sm>						
					<sm>e</sm>						
					<sm>-</sm>						
					<sm>5</sm>
					<sm class="btn-success">l</sm>						
					<sm>p</sm>
					<sm>d</sm>						
					<sm>a</sm>						
					<sm>t</sm>
					<sm class="btn-warning">shift</sm>						
					<sm>a</sm>						
					<sm>t</sm>
					<sm>e</sm>						
					<sm>-</sm>						
					<sm>5</sm>
					<sm class="btn-success">enter</sm>						
					<br>
					<sm class="btn-success">ctrl</sm>						
					<sm class="glyphicon glyphicon-th-large"></sm>						
					<sm>alt</sm>
					<sm class="btn-primary">space</sm>						
					<sm>alt</sm>
					<sm class="glyphicon glyphicon-th-large"></sm>						
					<sm class="glyphicon glyphicon-list-alt"></sm>						
					<sm>ctrl</sm>						
				</div>
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-4">
				<div class="col-md-8 lgdef">
					<h5>ADMIN <sub>i</sub></h5>
					<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Login</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>

<label for='username' >USERNAME:</label>
<input type='text' name='username' id='username'  maxlength="50" placeholder="username" class="form-control"/>

<label for='password' >PASSWORD:</label>
<input type='password' name='password' id='password' maxlength="50" placeholder="**********" class="form-control"/>

<input type='submit' name='submit' class="btn btn-info "  value="LOGIN" />

</fieldset>
</form>
					<div class="list-group text-left ">
 						<a  class="list-group-item text-success">CRUD ADMIN i READY USE</a>
 						<a  class="list-group-item"><input type='hidden' value="lakki">ADD ENTIRES | INSERT</a>
 						<a  class="list-group-item">VIEW ENTRIES | SHOW</a>
 						<a  class="list-group-item">EDIT ENTRIES | UPDATE</a>
 						<a  class="list-group-item">REMOVE ENTRIES | DELETE</a>
 				
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php
}
?>