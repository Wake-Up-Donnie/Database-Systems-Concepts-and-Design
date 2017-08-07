<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])){
  header('Location: /');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

$conn = getConn();
$query = "SELECT SiteID From User WHERE Username='$username' AND Password= '$password'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if (is_null($row)) {
  header('Location: /');
} else {
  $siteid = $row['SiteID'];

  $query = "SELECT ShortName From Site WHERE SiteID='$siteid'";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();

  if (is_null($row)) {
    header('Location: /');
  } else {
    $siteshortname = $row['ShortName'];
    $_SESSION['siteshortname'] = $siteshortname;
    $_SESSION['siteid'] = $siteid;
  }
}
?>
