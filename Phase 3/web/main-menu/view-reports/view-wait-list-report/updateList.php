<?php
$user = 'root';
$password = 'root';
$db = 'acacs';
$host = '127.0.0.1';
$port = 8889;
$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$array	= $_POST['arrayorder'];

if ($_POST['update'] == "update"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE WaitlistEntry SET OrderIndex = " . $count . " WHERE ClientID = " . $idval;
        $conn->query($query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
?>