<?php
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using this script.//
/// You can use it at your own risk. /////
//*****************************************
session_start();
?>

<html>

<head>
<title>Lower Item Number Page</title>
</head>

<body>
<?Php
$username = $_SESSION['username'];
$dropdownitemsremove=$_POST['dropdownitemsremove'];
$sub=$_POST['sub'];

echo "ItemID # = $dropdownitemsremove <br> User ID = $username <br>Item quantity reduced to = $sub ";



$pdo = new PDO("mysql:host=127.0.0.1;dbname=acacs;port=8889", 'root', 'root');


$sql1 = "SELECT ServiceID
	FROM Item WHERE ItemID =  " . $dropdownitemsremove;

$stmt1 = $pdo->prepare($sql1);
//Execute the statement.
$stmt1->execute();
//Retrieve the rows using fetchAll.
$serviceid = $stmt1->fetchColumn();

#echo $serviceid;

$sqlreject = "SELECT Item.ItemName FROM Item JOIN FoodBank ON FoodBank.ServiceID = FoodBank.ServiceID JOIN User ON FoodBank.SiteID = User.SiteID
WHERE FoodBank.ServiceID = " . $serviceid . " AND User.Username =  \"$username\"";

$stmt2 = $pdo->prepare($sqlreject);
//Execute the statement.
$stmt2->execute();
//Retrieve the rows using fetchAll.
$serviceid2 = $stmt2->rowCount();
#echo $serviceid2;
if($serviceid2 >0){
    $sql3 = "UPDATE `Item`
    SET `NumberOfUnits` = :units
    WHERE `ItemID` = :dropdown";
try {
    $stmt3 = $pdo->prepare($sql3);

     $stmt3->bindParam(':units', $sub, PDO::PARAM_INT);
    $stmt3->bindParam(':dropdown', $dropdownitemsremove, PDO::PARAM_INT);
    $stmt3->execute();
    #$date = date('Y-m-d H:i:s');
    #$stmt3->bindParam(':TimeStamp', $date, PDO::PARAM_STR);
// use PARAM_STR although a number
    #$stmt3->bindParam(':ServiceID', $serviceid, PDO::PARAM_INT);
    #$stmt3->bindParam(':ItemID', $dropdownitemss, PDO::PARAM_INT);
    #$stmt3->bindValue(':ItemQuantity',$sub, PDO::PARAM_INT);
    #$stmt3->bindValue(':ItemProvided', 0, PDO::PARAM_INT);
    #$stmt3->bindValue(':Status', 'Pending', PDO::PARAM_STR);
} catch (Exception $e) {

    #$lastId = $pdo->lastInsertId();
    throw $e;
}
}else{
    echo "<br>ERROR! : You are NOT Associated with this foodbank, cannot set Items<br>";
}


$sqlcheckitemzero = "SELECT Item.NumberOfUnits FROM Item WHERE Item.ItemID =" . $dropdownitemsremove;
try {
    $stmt7 = $pdo->prepare($sqlcheckitemzero);
    $stmt7->execute();
//Retrieve the rows using fetchAll.
    $itemcount = $stmt7->fetchColumn();
}
catch (PDOException $e) {
    echo $itemcount . "<br>" . $e->getMessage();
}
/*
if ($itemcount < 1) {
    $sqlcheckifinrequest = "SELECT Request.ItemQuantity FROM Request WHERE Request.ItemID =" . $dropdownitemsremove;
    try {
        $stmt4 = $pdo->prepare($sqlcheckifinrequest);
        $stmt4->execute();

    } catch (PDOException $e) {
        #echo $iteminrequest . "<br>" . $e->getMessage();
    }
    #echo $stmt4;
    if ($stmt4 = TRUE) {
        $sqldelete1 = "DELETE FROM `Request`
               WHERE `ItemID` = :dropdown2";
        $stmt9 = $pdo->prepare($sqldelete1);
        $stmt9->bindParam(':dropdown2', $dropdownitemsremove, PDO::PARAM_INT);
        $stmt9->execute();

        $sqldelete2 = "DELETE FROM `Item`
               WHERE `ItemID` = :dropdown2";
        try {
            $stmt10 = $pdo->prepare($sqldelete2);
            $stmt10->bindParam(':dropdown2', $dropdownitemsremove, PDO::PARAM_INT);
            $stmt10->execute();
        } catch (PDOException $e) {
            echo $sqldelete2 . "<br>" . $e->getMessage();
        }

        echo "<br>Item was detected in request list and deleted from the request list as well as the item list .<br>";
        }
    else {
        $sqldelete = "DELETE FROM `Item`
                   WHERE `ItemID` = :dropdown2";
        try {
            $stmt5 = $pdo->prepare($sqldelete);
            $stmt5->bindParam(':dropdown2', $dropdownitemsremove, PDO::PARAM_INT);
            $stmt5->execute();
            echo "Item Deleted";
        } catch (PDOException $e) {
            echo $sqldelete . "<br>" . $e->getMessage();
        }
        echo "<br>Item was has hit zero and was deleted from the item list<br>.";
    }
}else {
    echo "<br>Number of units for item has not hit zero: Number Of Items UPDATED<br>";
}
*/
?>
<br><br>
<a href=index.php>Reset and start again</a>

<br><br>
</body>

</html>
