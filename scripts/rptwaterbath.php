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
$table = 'tbl_water_bath';

// Table's primary key
$primaryKey = 'idtbl_water_bath';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

// $date = $_POST['filter_date'] ?? '';

$columns = array(
	array( 'db' => '`u`.`idtbl_water_bath`', 'dt' => 'idtbl_water_bath', 'field' => 'idtbl_water_bath' ),
	array('db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date'),
    array( 'db' => '`u`.`batch_no`', 'dt' => 'batch_no', 'field' => 'batch_no' ),
	array('db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty'),
    array( 'db' => '`u`.`exhasting_temp`', 'dt' => 'exhasting_temp', 'field' => 'exhasting_temp' ),
	array('db' => '`u`.`capping_temp`', 'dt' => 'capping_temp', 'field' => 'capping_temp'),
	array( 'db' => '`u`.`sterlization_temp`', 'dt' => 'sterlization_temp', 'field' => 'sterlization_temp' ),
    array( 'db' => '`u`.`steam_on_time`', 'dt' => 'steam_on_time', 'field' => 'steam_on_time' ),
    array( 'db' => '`u`.`steam_off_time`', 'dt' => 'steam_off_time', 'field' => 'steam_off_time' ),
    array( 'db' => '`u`.`number_of_rejection`', 'dt' => 'number_of_rejection', 'field' => 'number_of_rejection' ),
    array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
    array( 'db' => '`ua`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`u`.`remark`', 'dt' => 'remark', 'field' => 'remark' ),
    array( 'db' => '`p`.`prodcutname`', 'dt' => 'prodcutname', 'field' => 'prodcutname' ),
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


$joinQuery = "FROM `tbl_water_bath` AS `u`
LEFT JOIN `tbl_product` AS `p` ON (`p`.`idtbl_product` = `u`.`product_id`)
LEFT JOIN `tbl_user` AS `ua` ON (`ua`.`idtbl_user` = `u`.`checked_by`)";

$extraWhere = "`u`.`status` IN (1, 2)";

// if(!empty($drier)){
//     $extraWhere .= " AND u.idtbl_drier = '$drier'";
// }

if(!empty($date)){
    $extraWhere .= " AND DATE(u.date) = '$date'";
}
 

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
);