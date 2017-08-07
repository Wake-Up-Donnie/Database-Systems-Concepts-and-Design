<?php
// Start the session

session_start();
?>
<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$username = $_SESSION['username'];
$table = 'Item';

// Table's primary key
$primaryKey = 'ItemID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => '`Item`.`ItemID`', 'dt' => 0, 'field' => 'ItemID' ),
    array( 'db' => '`Item`.`ServiceID`',  'dt' => 1, 'field' => 'ServiceID' ),
    array( 'db' => '`Item`.`ItemName`', 'dt' => 2, 'field' => 'ItemName' ),
    array( 'db' => '`Item`.`NumberOfUnits`',  'dt' => 3, 'field' => 'NumberOfUnits' ),
    array( 'db' => '`Item`.`ExpirationDate`', 'dt' => 4, 'field' => 'ExpirationDate', 'formatter' => function( $d, $row ) {
        return date( 'jS M y', strtotime($d));
    }),
    array( 'db' => '`Item`.`StorageType`',  'dt' => 5, 'field' => 'StorageType' ),
    array( 'db' => '`Item`.`Category`',  'dt' => 6, 'field' => 'Category' ),
    array( 'db' => '`Item`.`SubCategory`',  'dt' => 7, 'field' => 'SubCategory' ),
    array( 'db' => '`FoodBank`.`FacilityName`',  'dt' => 8, 'field' => 'FacilityName' ),
    array( 'db' => '`User`.`Username`',  'dt' => 9, 'field' => 'Username' )

    // array( 'db' => 'ItemID', 'dt' => 0 ),
    //array( 'db' => 'Item.ServiceID',  'dt' => 1 ),
    //array( 'db' => 'ItemName',   'dt' => 1 ),
    //array( 'db' => 'NumberOfUnits',     'dt' => 2 ),
    //array(
    //'db'        => 'ExpirationDate',
    //'dt'        => 3,
    //'formatter' => function( $d, $row ) {
    //return date( 'jS M y', strtotime($d));
    //}
    //),

);

/*
$columns = array(
	array( 'db' => '`u`.`first_name`', 'dt' => 0, 'field' => 'first_name' ),
	array( 'db' => '`u`.`last_name`',  'dt' => 1, 'field' => 'last_name' ),
	array( 'db' => '`u`.`position`',   'dt' => 2, 'field' => 'position' ),
	array( 'db' => '`u`.`office`',     'dt' => 3, 'field' => 'office'),
	array( 'db' => '`ud`.`email`',     'dt' => 4, 'field' => 'email' ),
	array( 'db' => '`ud`.`phone`',     'dt' => 5, 'field' => 'phone' ),
	array( 'db' => '`u`.`start_date`', 'dt' => 6, 'field' => 'start_date', 'formatter' => function( $d, $row ) {
																	return date( 'jS M y', strtotime($d));
																}),
	array('db'  => '`u`.`salary`',     'dt' => 7, 'field' => 'salary', 'formatter' => function( $d, $row ) {
																return '$'.number_format($d);
															})
);
*/

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
$big = "Bounty Food Bank";
// require( 'ssp.class.php' );
require('ssp.customized.class.php');

$joinQuery = "FROM `Item` INNER JOIN `FoodBank` ON `FoodBank`.`ServiceID` = `Item`.`ServiceID` INNER JOIN `User` ON`FoodBank`.`SiteID` = `User`.`SiteID`
";
$extraWhere = "`User`.`Username` =" . "'$username'";


echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
