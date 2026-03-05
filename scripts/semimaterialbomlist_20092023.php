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
$table = 'tbl_semi_bom';

// Table's primary key
$primaryKey = 'idtbl_semi_bom';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_semi_bom`', 'dt' => 'idtbl_semi_bom', 'field' => 'idtbl_semi_bom' ),
	array( 'db' => '`u`.`semimaterial`', 'dt' => 'semimaterial', 'field' => 'semimaterial' ),
	array( 'db' => '`ua`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM `tbl_semi_bom` AS `u` 
LEFT JOIN `tbl_material_info` AS `ua` ON (`ua`.`idtbl_material_info` = `u`.`semimaterial`) 
LEFT JOIN `tbl_material_code` AS `ub` ON (`ub`.`idtbl_material_code` = `ua`.`tbl_material_code_idtbl_material_code`)";

$extraWhere = "`u`.`status` IN (1, 2)";

$groupBy ="`u`.`semimaterial`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
