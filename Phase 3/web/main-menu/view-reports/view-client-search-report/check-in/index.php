<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Check in for a service</title>
</head>
<body>

<form action="./result/" method="post">
<?php
$clientid = $_GET['clientid'];
$isheadofhousehold = $_GET['isheadofhousehold'];
$siteid = $_SESSION['siteid'];

$conn = getConn();

$result = $conn->query("SELECT * FROM Shelter WHERE SiteID='$siteid'");
if ($row = $result->fetch_assoc()){
  $shelterserviceid = $row['ServiceID'];
  echo "<input type='hidden' name='shelterserviceid' value='$shelterserviceid'>";
  if ($row['MaleBunkAvailable'] > 0){
    echo "<input type='radio' name='serviceType' value='MaleBunkAvailable'>Male Bunk<br>";
  }
  if ($row['FemaleBunkAvailable'] > 0){
    echo "<input type='radio' name='serviceType' value='FemaleBunkAvailable'>Female Bunk<br>";
  }
  if ($row['MixedBunkAvailable'] > 0){
    echo "<input type='radio' name='serviceType' value='MixedBunkAvailable'>Mixed Bunk<br>";
  }
  if ($isheadofhousehold) {
    if ($row['FamilyRoomAvailable'] > 0){
      echo "<input type='radio' name='serviceType' value='FamilyRoomAvailable'>Family Room<br>";
    } else {
      echo "<input type='radio' name='serviceType' value='FamilyRoomWaitlist'>Family Room Waitlist<br>";
    }
  }
}

$result = $conn->query("SELECT * FROM FoodPantry WHERE SiteID='$siteid'");
if ($row = $result->fetch_assoc()){
  echo "<input type='radio' name='serviceType' value='FoodPantry'>Food Pantry<br>";
}

$result = $conn->query("SELECT * FROM SoupKitchen WHERE SiteID='$siteid'");
if ($row = $result->fetch_assoc()){
  echo "<input type='radio' name='serviceType' value='SoupKitchen'>Soup Kitchen<br>";
}
?>
<input type="text" name="extranotes" placeholder="Extra notes here">
<input type="hidden" name="clientid" value="<?php echo $clientid;?>">
<input type="submit" name="submit" value="Submit">
</form><br>

</body>
</html>
