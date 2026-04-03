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
$table = 'tbl_production_wastage';

// Table's primary key
$primaryKey = 'idtbl_production_wastage';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_production_wastage`', 'dt' => 'idtbl_production_wastage', 'field' => 'idtbl_production_wastage' ),
	array( 'db' => '`u`.`production_date`', 'dt' => 'production_date', 'field' => 'production_date' ),
	array( 'db' => '`u`.`batch_no`', 'dt' => 'batchno', 'field' => 'batch_no' ),
    array( 'db' => '`u`.`check_status`', 'dt' => 'check_status', 'field' => 'check_status' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
    array( 'db' => '`u`.`remark`', 'dt' => 'remark', 'field' => 'remark' ),
    array( 'db' => '`u`.`grn_id`', 'dt' => 'grn', 'field' => 'grn_id' )

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

$joinQuery = "FROM `tbl_production_wastage` AS `u` ";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
