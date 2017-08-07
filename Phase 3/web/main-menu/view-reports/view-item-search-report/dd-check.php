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
<title>Request Page</title>
</head>

<body>
<?Php
$username = $_SESSION['username'];
$dropdownitemss=$_POST['dropdownitemss'];
$subcat=$_POST['subcat'];

echo "ItemID # = $dropdownitemss <br> User ID = $username <br>Item quantity requested = $subcat ";



$pdo = new PDO("mysql:host=127.0.0.1;dbname=acacs;port=8889", 'root', 'root');


$sql1 = "SELECT ServiceID
	FROM Item WHERE ItemID =  " . $dropdownitemss;

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
    echo "<br>ERROR! : You are Associated with this foodbank, cannot request<br>";
}else{
    echo "<br>You are not associated with this foodbank, Request sent<br>";
    $sql3 = "INSERT INTO Request(RequestID,
            UserName,
            TimeStamp,
            ServiceID,
            ItemID,
            ItemQuantity,
            ItemProvided,
            Status) VALUES (
            :RequestID, 
            :UserName, 
            :TimeStamp, 
            :ServiceID, 
            :ItemID,
            :ItemQuantity,
            :ItemProvided,
            :Status)";

    $stmt3 = $pdo->prepare($sql3);

    $stmt3->bindValue(':RequestID', NULL, PDO::PARAM_NULL);
    $stmt3->bindValue(':UserName', $username, PDO::PARAM_STR);
    $date = date('Y-m-d H:i:s');
    $stmt3->bindParam(':TimeStamp', $date, PDO::PARAM_STR);
// use PARAM_STR although a number
    $stmt3->bindParam(':ServiceID', $serviceid, PDO::PARAM_INT);
    $stmt3->bindParam(':ItemID', $dropdownitemss, PDO::PARAM_INT);
    $stmt3->bindValue(':ItemQuantity',$subcat, PDO::PARAM_INT);
    $stmt3->bindValue(':ItemProvided', 0, PDO::PARAM_INT);
    $stmt3->bindValue(':Status', 'Pending', PDO::PARAM_STR);

    $stmt3->execute();
    $lastId = $pdo->lastInsertId();
}

?>
<br><br>
<a href=index.php>Reset and start again</a>

<br><br>
</body>

</html>
