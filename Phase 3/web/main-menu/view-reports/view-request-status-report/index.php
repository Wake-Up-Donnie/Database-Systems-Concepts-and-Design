<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
$conn = getConn();
?>

<!DOCTYPE html>
<html>
<head>
<title> View Request Status Report </title>
</head>
<body>

<h1> Request Status Report </h1>

<?php

if (!empty($_GET['cancel_request'])) {
    $RequestID = mysqli_real_escape_string($conn, $_GET['cancel_request']);
    $query = "DELETE FROM Request WHERE RequestID = '$RequestID'";
    mysqli_query($conn, $query);
}

//Update status to close and zero item provided when item stock quanitiy reached zero
$query = "
UPDATE Request, Item 
SET Status = 'Closed', ItemProvided = 0
WHERE Request.ItemID = Item.ItemID 
    AND NumberOfUnits = 0
";
$result = $conn->query($query);


$query = "
SELECT RequestID, FacilityName, ItemName, ItemQuantity, ItemProvided, Status 
FROM ((Request
INNER JOIN Item ON Request.ItemID = Item.ItemID)
INNER JOIN FoodBank ON Request.ServiceID = FoodBank.ServiceID)
WHERE Username = '$username'
ORDER BY RequestID
";
/*
$query = "
SELECT RequestID, FacilityName, ItemName, ItemQuantity, ItemProvided, Status 
FROM Request, Item, FoodBank
Where Request.ItemID = Item.ItemID 
AND Request.ServiceID = FoodBank.ServiceID
AND Username = '$username'
";
*/

$result = $conn->query($query);

?>

<?php 

if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
    echo "No request report available.";
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if ($row) {

echo '<table width=100% border=1>';
        echo '<tr style="font-weight:bold">';
        echo '<td>RequestID</td>';
        echo '<td>FacilityName</td>';
        echo '<td>ItemName</td>';
        echo '<td>ItemQuantity</td>';
        echo '<td>ItemProvided</td>';
        echo '<td>Status</td>';
        echo '<td>Cancel/Delete</td>';
        echo '</tr>';
    // output data of each row
    while ($row) {
        echo "<tr>";
        echo "<td>" . $row['RequestID'] . "</td>";
        echo "<td>" . $row['FacilityName'] . "</td>"; 
        echo "<td>" . $row['ItemName'] . "</td>";
        echo "<td>" . $row['ItemQuantity'] . "</td>";
        echo "<td>" . $row['ItemProvided'] . "</td>";
        echo "<td>" . $row['Status'] . "</td>";
        if ($row['Status'] == 'Closed') {
            echo '<td><a href="index.php?cancel_request=' . urlencode($row['RequestID']) . '">Delete</a></td>';
        } else {
            echo '<td><a href="index.php?cancel_request=' . urlencode($row['RequestID']) . '">Cancel</a></td>';
        }
        echo "</tr>";

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    }
}

echo "</table>";
$conn->close();

?>

<br>
<br>
<a href=/main-menu/view-reports/index.php>Back</a>
<br>
<br>

</body>
</html>