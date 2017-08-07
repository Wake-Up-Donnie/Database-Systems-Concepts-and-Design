<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$conn = getConn();

if (isset($_POST['submit'])) {
        $clientID = $_POST['clientID'];
        // echo $ItemName;
        //$NumberOfUnits = $_POST['NumberOfUnits'];
        // echo $NumberOfUnits; 
}

#$sql = "SELECT ClientID FROM WaitlistEntry WHERE ClientID=$clientID";
#$result = $conn->query($sql);
#$count = $result->fetch_row()[0];
# echo $count; 
#echo $count;
#if ($count > 0) {

$sql3 = "SELECT ClientID FROM WaitlistEntry WHERE ClientID=$clientID";
$result3 = mysqli_query($conn, $sql3);
$result3->fetch_row()[0];
if ($result3) {
    $sql = "DELETE FROM WaitlistEntry WHERE ClientID=$clientID";
    $result2 = mysqli_query($conn, $sql);
    echo "User Deleted from waitlist";
    $sql4 = "SELECT ClientID FROM WaitlistEntry WHERE ClientID=$clientID";
    $result5 = mysqli_query($conn, $sql4);

    if ($result5->fetch_row()[0] > 0) {
        $sql2 = "SELECT OrderIndex FROM WaitlistEntry";
        #$res = mysqli_result::$field_count($conn,$sql2);
        #$sql3 = mysqli_data_seek($res,0);
        $result = mysqli_query($conn, $sql2);
        #$row = mysqli_fetch_array($result);
        #$table_row_count = $result->fetch_row()[0];
        $updated_key = 0;
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        foreach ($rows as $elem) {
            $updated_key = $updated_key + 1;
            #echo ($elem[0]) . "<br/>";
            $sql3 = "UPDATE WaitlistEntry SET OrderIndex = $updated_key WHERE OrderIndex =  $elem[OrderIndex]";
            mysqli_query($conn, $sql3);
        }
    }
}

#}
else {
    echo "<br>ClientID not found on waitlist.</br>";
    echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
}
?>

<br><br>
<form action="http://localhost:8888/main-menu/view-reports/view-wait-list-report/index.php"><input type="submit" value="Back" /></form>

