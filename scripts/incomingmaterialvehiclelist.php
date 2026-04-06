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
$table = 'tbl_raw_material_vehicle_inspection';

// Table's primary key
$primaryKey = 'idtbl_raw_material_vehicle_inspection';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_raw_material_vehicle_inspection`', 'dt' => 'idtbl_raw_material_vehicle_inspection', 'field' => 'idtbl_raw_material_vehicle_inspection' ),
	array( 'db' => '`u`.`vehicle_number`', 'dt' => 'vehicle_number', 'field' => 'vehicle_number' ),
	array( 'db' => '`u`.`assosiation_name`', 'dt' => 'assosiation_name', 'field' => 'assosiation_name' ),
	array( 'db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`assosiation_id`', 'dt' => 'assosiation_id', 'field' => 'assosiation_id' ),
	array( 'db' => '`u`.`address`', 'dt' => 'address', 'field' => 'address' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`u`.`materail_status`', 'dt' => 'materail_status', 'field' => 'materail_status' ),
    array( 'db' => '`ft`.`type`', 'dt' => 'fruittype', 'field' => 'type' ),
    array( 'db' => '`sp`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`u`.`approval_status`', 'dt' => 'approval_status', 'field' => 'approval_status' )
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

$joinQuery = "FROM `tbl_raw_material_vehicle_inspection` AS `u`
LEFT JOIN `tbl_fruit_type` AS `ft` ON (`ft`.`idtbl_fruit_type` = `u`.`tbl_fruit_type_idtbl_fruit_type`)
LEFT JOIN `tbl_supplier` AS `sp` ON (`sp`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`)";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
