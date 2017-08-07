<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Client Result</title>
</head>
<body>

<?php
$conn = getConn();
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$idnumber = $_GET['idnumber'];
$params = array();

if ($firstname != '') $params[] = "firstname LIKE '%$firstname%'";
if ($lastname != '') $params[] = "lastname LIKE '%$lastname%'";
if ($idnumber != '') $params[] = "idnumber LIKE '%$idnumber%'";

if (count($params) == 0) {
  echo "<p>Empty query</p>";
} else {
  $query = "SELECT * FROM Client WHERE " . implode(' AND ', $params) . " LIMIT 5;";
  $result = $conn->query($query);
  if ($result->num_rows == 0) {
    echo "<p>No client found</p>";
  } else {
    if ($result->num_rows > 4){
      echo "<p>Search result has more than 4 clients. Please input more specific search terms.</p>";
    }else{
      echo "<table border='1'>";
          echo "<tr>";
          echo "<th>FirstName</th>";
          echo "<th>LastName</th>";
          echo "<th>IDNumber</th>";
          echo "<th>ID Description</th>";
          echo "<th>Is head of household?</th>";
          echo "<th>Phone</th>";
          echo "</tr>";
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['FirstName'] . "</td>";
          echo "<td>" . $row['LastName'] . "</td>";
          echo "<td>" . $row['IDNumber'] . "</td>";
          echo "<td>" . $row['IDDescription'] . "</td>";
          echo "<td>" . ($row['IsHeadOfHousehold']==0?"No":"Yes") . "</td>";
          echo "<td>" . $row['Phone'] . "</td>";
          echo "<td><a href='../../edit-client?clientid=$row[ClientID]'>Edit</a></td>";
          echo "<td><a href='../../view-log-entry?clientid=$row[ClientID]'>View Log Entry</a></td>";
          echo "<td><a href='../../check-in?clientid=$row[ClientID]&isheadofhousehold=$row[IsHeadOfHousehold]'>Check-In</a></td>";
          echo "</tr>";
        }
      echo "</table>";
    }
  }
}
?>
<br>
<br>
<a href=/main-menu/view-reports/view-client-search-report/search-client/index.php>Back</a>
<br>
<br>
</body>
</html>
