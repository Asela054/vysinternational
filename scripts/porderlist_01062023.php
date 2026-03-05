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
$table = 'tbl_production_fg';

// Table's primary key
$primaryKey = 'idtbl_production_fg';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_production_fg`', 'dt' => 'idtbl_production_fg', 'field' => 'idtbl_production_fg' ),
	array( 'db' => '`ub`.`idtbl_customer_porder`', 'dt' => 'idtbl_customer_porder', 'field' => 'idtbl_customer_porder' ),
    array( 'db' => '`ub`.`orderdate`', 'dt' => 'orderdate', 'field' => 'orderdate' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`ue`.`type`', 'dt' => 'type', 'field' => 'type' ),
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

$joinQuery = "FROM `tbl_production_fg` AS `u`
LEFT JOIN `tbl_production_order` AS `ua` ON (`u`.`tbl_production_order_idtbl_production_order` = `ua`.`idtbl_production_order`)
LEFT JOIN `tbl_customer_porder` AS `ub` ON (`ua`.`tbl_customer_porder_idtbl_customer_porder` = `ub`.`idtbl_customer_porder`)
LEFT JOIN `tbl_customer_porder_detail` AS `uc` ON (`uc`.`tbl_customer_porder_idtbl_customer_porder` = `ub`.`idtbl_customer_porder`)
LEFT JOIN `tbl_customer` AS `ud` ON (`ub`.`tbl_customer_idtbl_customer` = `ud`.`idtbl_customer`)
LEFT JOIN `tbl_order_type` AS `ue` ON (`ub`.`tbl_order_type_idtbl_order_type` = `ue`.`idtbl_order_type`)";

$extraWhere = "`u`.`status` IN (1, 2)";
$groupBy = "`ub`.`idtbl_customer_porder`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
