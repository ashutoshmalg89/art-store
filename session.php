<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

try {
  include 'connection.php';

  session_start();
  $active_user_chk = $_SESSION['curr_user'];

  $query1 = $dbh->prepare("select username from board.customers
    where username='" . $active_user_chk . "'");

  $query1->execute();
  foreach ($query1 as $result) {
    # code...
    $username = $result['username'];
  }
  if(!isset($_SESSION['curr_user'])){
    header("location:customers.php");
  }
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>