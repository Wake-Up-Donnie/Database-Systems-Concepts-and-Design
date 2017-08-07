<?php
function getConn() {
    if ( !isset($GLOBALS["conn"]) ){
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
        $GLOBALS["conn"] = $conn;
    }
    return $GLOBALS["conn"];
}
?>
