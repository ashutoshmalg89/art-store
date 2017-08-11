<?php 
include 'connection.php';

session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){

$username = $_POST['username'];
$password = $_POST['password'];


$query = $dbh->prepare("select username from board.customers where username ='$username' and password ='$password'");
$query -> debugDumpParams();
$query -> execute();

foreach ($query as $result) {
  # code...
  $count = $result['username'];
}

if($count == $username){
  $_SESSION['curr_user']=$username;
  header("location:welcome.php");

}else{
  $errMsg = "User Does Not Exist";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<style> 
.flex-container {
    display: -webkit-flex;
    display: flex;  
    -webkit-flex-flow: row wrap;
    flex-flow: row wrap;
    text-align: center;
}

.flex-container > * {
    padding: 15px;
    -webkit-flex: 1 100%;
    flex: 1 100%;
}

header {background: black;color:white;}
footer {background: #aaa;color:white;}

.nav ul {
    list-style-type: none;
  padding: 0;
}
      
</style>
<script type="text/javascript">
  

</script>

</head>
<body>

<div class="flex-container">
<header>
  <h1>Assignment 4</h1>
</header>
<div id="loginform">
  <table align="center">
  <form action="" method="POST" class="login" id="login">
    <tr><th colspan="2"><b> Login Here </b> </th></tr>
    <tr>
    <td><label for="username" class="uname">Username :</label></td>
    <td><input type="text" required="required" name="username" id="username" placeholder="Enter Username" oninvalid="this.setCustomValidity('Username cannot be blank')">
    </td>
    </tr>
    <tr>
    <td> <label for="password" class="pwd">Password :</label></td>
    <td><input type="password" required="required" name="password" id="password" placeholder="Enter Password" oninvalid="this.setCustomValidity('Password cannot be blank')">
    </td>
    </tr>
    <tr>
    <td>
    <input type="submit" value="Login" onclick=" return validate()">  
    </td></form>
    <td><button onclick="location.href='register.php';">Register</button></td></tr>
  </table>

</div>
<footer></footer>
</div>

</body>
</html>