<?php
require_once '../external.php';

$CI =& get_instance();
$CI->load->library('session');

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
$table = 'tbl_drier';

// Table's primary key
$primaryKey = 'idtbl_drier';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$drier = $_POST['drier'] ?? '';
$date = $_POST['filter_date'] ?? '';

$columns = array(
	array( 'db' => '`u`.`idtbl_drier`', 'dt' => 'idtbl_drier', 'field' => 'idtbl_drier' ),
	array('db' => '`u`.`name` AS `drier`', 'dt' => 'drier', 'field' => 'drier'),
    array( 'db' => '`ua`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array('db' => '`ua`.`time`', 'dt' => 'time', 'field' => 'time'),
    array( 'db' => '`ua`.`temp`', 'dt' => 'temp', 'field' => 'temp' ),
	array('db' => '`ud`.`name` AS `checked_by`', 'dt' => 'checked_by', 'field' => 'checked_by'),
	array( 'db' => '`ua`.`remark`', 'dt' => 'remark', 'field' => 'remark' ),
    array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
);

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

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );


$joinQuery = "FROM `tbl_drier` AS `u` 
JOIN `tbl_drier_daily_info` AS `ua` ON (`ua`.`drier_id` = `u`.`idtbl_drier`)
JOIN `tbl_user` AS `ud` ON (`ud`.`idtbl_user` = `ua`.`user_id`)";

$extraWhere = "`u`.`status` IN (1, 2)";

if(!empty($drier)){
    $extraWhere .= " AND u.idtbl_drier = '$drier'";
}

if(!empty($date)){
    $extraWhere .= " AND DATE(ua.date) = '$date'";
}
 

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
);