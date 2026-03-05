<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<?php

$sql = "SELECT COUNT(`idtbl_product`) AS productcount FROM `tbl_product` WHERE `status`=1";
$respondproduct=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_customer`) AS customercount FROM `tbl_customer` WHERE `status`=1";
$respondcustomer=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_employee`) AS employeecount FROM `tbl_employee` WHERE `status`=1";
$respondemployee=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_customer_porder`) AS ordercount, SUM(`nettotal`) AS total FROM `tbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`= `tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_customer_porder`.`status` = 1 AND `tbl_customer`.`customertype`=1  AND MONTH(`tbl_customer_porder`.`orderdate`) = MONTH(CURRENT_DATE())";
$respondorders=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_customer_porder`) AS ordercount, SUM(`nettotal`) AS total FROM `tbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`= `tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_customer_porder`.`status` = 1 AND `tbl_customer`.`customertype`=2  AND MONTH(`tbl_customer_porder`.`orderdate`) = MONTH(CURRENT_DATE())";
$respondorders2=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_invoice`) AS invoicecount, SUM(`tbl_invoice`.`nettotal`) AS total FROM `tbl_invoice` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`= `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`= `tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_invoice`.`status` = 1 AND `tbl_customer`.`customertype`=1  AND MONTH(`tbl_invoice`.`invdate`) = MONTH(CURRENT_DATE())";
$respondinvoice=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_invoice`) AS invoicecount, SUM(`tbl_invoice`.`nettotal`) AS total FROM `tbl_invoice` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`= `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`= `tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_invoice`.`status` = 1 AND `tbl_customer`.`customertype`=2  AND MONTH(`tbl_invoice`.`invdate`) = MONTH(CURRENT_DATE())";
$respondinvoice2=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_semi_production_detail`) AS productioncount, SUM(`total`) AS total FROM `tbl_semi_production_detail` LEFT JOIN `tbl_semi_production` ON `tbl_semi_production`.`idtbl_semi_production`= `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production` WHERE `tbl_semi_production_detail`.`status` = 1 AND MONTH(`tbl_semi_production`.`prodate`) = MONTH(CURRENT_DATE())";
$respondproduction=$this->db->query($sql);

$sql = "SELECT COUNT(`idtbl_production_orderdetail`) AS packingcount, SUM(`total`) AS total FROM `tbl_production_orderdetail` LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order`= `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` WHERE `tbl_production_orderdetail`.`status` = 1 AND MONTH(`tbl_production_order`.`prodate`) = MONTH(CURRENT_DATE())";
$respondpacking=$this->db->query($sql);

?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title font-weight-light">
							<div class="page-header-icon"><i class="fas fa-desktop"></i></div>
							<span>Dashboard</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card rounded-0">
					<div class="card-body p-0 p-2">
						<div class="row">
						<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-primary card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-primary">
											<i class="fas fa-shopping-bag fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class=" text-primary my-1">
													<?php if($respondproduct->num_rows() > 0){ foreach($respondproduct->result() as $rowlist){ echo $rowlist->productcount; }}?>
												</h3>
												<h3 class="card-title text-primary m-0 font-weight-bold"><a
														class="text-primary"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Product';}else{echo '#';} ?>">Finish
														Good
														Info</a></h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-primary" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-secondary card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="ol-auto p-2  text-secondary">
											<i class="fas fa-users fa-3x" aria-hidden="true"></i>

										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class=" text-secondary my-1">
													<?php if($respondcustomer->num_rows() > 0){ foreach($respondcustomer->result() as $rowlist){ echo $rowlist->customercount; }}?>
												</h3>
												<h3 class="card-title text-secondary m-0 "><a class="text-secondary"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Customer';}else{echo '#';} ?>">Customers
													</a></h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-secondary" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-orange p-2 p-0">
									<div class="row no-gutters h-100">
										<div class="col-auto card-icon-aside-new text-orange">
											<i class="fas fa-people-carry fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<h3 class=" text-orange my-1">
													<?php if($respondemployee->num_rows() > 0){ foreach($respondemployee->result() as $rowlist){ echo $rowlist->employeecount; }}?>
												</h3>
												<h3 class="card-title text-orange m-0 "><a class="text-orange"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Employee';}else{echo '#';} ?>">Employees</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-orange">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-orange" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-success card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-success">
											<i class="fas fa-shopping-cart fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-success my-1">
													<?php
												$total = 0;
												if ($respondorders->num_rows() > 0) {
													foreach ($respondorders->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondorders->num_rows() > 0){ foreach($respondorders->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-success m-0 font-weight-bold"><a
														class="text-success"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Customerporder';}else{echo '#';} ?>">Sales
														Orders Local
														(<?php if($respondorders->num_rows() > 0){ foreach($respondorders->result() as $rowlist){ echo $rowlist->ordercount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-danger card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-danger">
											<i class="fas fa-luggage-cart fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-danger my-1">
													<?php
												$total = 0;
												if ($respondorders2->num_rows() > 0) {
													foreach ($respondorders2->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondorders2->num_rows() > 0){ foreach($respondorders2->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-danger m-0 font-weight-bold"><a
														class="text-danger"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Customerporder';}else{echo '#';} ?>">Sales
														Orders Export
														(<?php if($respondorders2->num_rows() > 0){ foreach($respondorders2->result() as $rowlist){ echo $rowlist->ordercount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-danger" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-warning card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-warning">
											<i class="fas fa-file-invoice fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-warning my-1">
													<?php
												$total = 0;
												if ($respondinvoice->num_rows() > 0) {
													foreach ($respondinvoice->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondinvoice->num_rows() > 0){ foreach($respondinvoice->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-warning m-0 font-weight-bold"><a
														class="text-warning"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Invoice';}else{echo '#';} ?>">Monthly
														Invoice Local
														(<?php if($respondinvoice->num_rows() > 0){ foreach($respondinvoice->result() as $rowlist){ echo $rowlist->invoicecount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-warning" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-info card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-info">
											<i class="fas fa-file-invoice-dollar fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-info my-1">
													<?php
												$total = 0;
												if ($respondinvoice2->num_rows() > 0) {
													foreach ($respondinvoice2->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondinvoice2->num_rows() > 0){ foreach($respondinvoice2->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-info m-0 font-weight-bold"><a
														class="text-info"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Invoice';}else{echo '#';} ?>">Monthly Invoice Export
														(<?php if($respondinvoice2->num_rows() > 0){ foreach($respondinvoice2->result() as $rowlist){ echo $rowlist->invoicecount; }}?>)</a>
												</h3>
											</div>
										</div>
											</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-info" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-dark card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-dark">
											<i class="fas fa-sitemap fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-dark my-1">
													<?php
												$total = 0;
												if ($respondproduction->num_rows() > 0) {
													foreach ($respondproduction->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondproduction->num_rows() > 0){ foreach($respondproduction->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-dark m-0 font-weight-bold"><a
														class="text-dark"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Semiproduction';}else{echo '#';} ?>">Monthly Production Orders
														(<?php if($respondproduction->num_rows() > 0){ foreach($respondproduction->result() as $rowlist){ echo $rowlist->productioncount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-dark" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-4 col-lg-4 col-xl-4">
								<div class="card shadow-none border-pink card-icon p-0 mb-3">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-pink">
										<i class="fas fa-tag fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
											<h4 class=" text-pink my-1">
													<?php
												$total = 0;
												if ($respondpacking->num_rows() > 0) {
													foreach ($respondpacking->result() as $rowlist) {
														$total += $rowlist->total;
													}
												}
												$formatted_total = number_format($total, 2);
												?>
													<?php if($respondpacking->num_rows() > 0){ foreach($respondpacking->result() as $rowlist){ echo 'Total: ' . $formatted_total; }}?>
												</h4>
												<h3 class="card-title text-pink m-0 font-weight-bold"><a
														class="text-pink"
														href="<?php if($_SESSION['type']==1 | $_SESSION['type']==2){ echo base_url().'Productionorderview';}else{echo '#';} ?>">Monthly Packing Orders
														(<?php if($respondpacking->num_rows() > 0){ foreach($respondpacking->result() as $rowlist){ echo $rowlist->packingcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-pink" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="p-0 p-2">
						<div class="row">
							<div class="col-6">
								<div class="card border-black shadow-none mt-3 mb-3">
									<div class="card-body">
										<h6 class="large title-style"><span>Monthly Sales Graph</span></h6>
										<canvas id="producttrendanalysis" width="800" height="250"></canvas>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card border-black shadow-none mt-3 mb-3">
									<div class="card-body">
										<h6 class="large title-style"><span>Daily Sales Graph</span></h6>
										<canvas id="dailygraph" width="800" height="250"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="p-0 p-2">
						<div class="card border-black shadow-none mt-3 mb-3">
							<div class="card-body">
								<h6 class="large title-style"><span>Production Info</span></h6>
								<table class="table table-bordered table-striped table-sm nowrap" id="productiontable">
									<thead class="table-orange">
										<tr>
											<th>#</th>
											<th>PRODUCT</th>
											<th>QUANTITY</th>
											<th>PRODUCTION CODE</th>
											<th>PRODUCTION DATE</th>
											<th>APPROVE STATUS</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div> -->
					<!-- <div class="p-0 p-2">
                    	<div class="card border-black shadow-none mt-3 mb-3">
                    		<div class="card-body">
							<h6 class="large title-style"><span>Packing Info</span></h6>
                    			<table class="table table-bordered table-striped table-sm nowrap"
                    				id="packingtable">
                    				<thead class="table-success">
									<tr>
                                            <th>#</th>
                                            <th>BUYER</th>
                                            <th>ITEM</th>
                                            <th>DELIVERY DATE</th>
                                            <th>QTY.</th>
                                            <th>SHIPPED QTY.</th>
                                            <th>PACKED QTY.</th>
                                            <th>LABEL QTY.</th>
                                            <th>BALANCE</th>
                                        </tr>
                    				</thead>
                    			</table>
                    		</div>
                    	</div>
                    </div> -->
					<!-- <div class="p-0 p-2">
						<div class="card border-black shadow-none mt-3 mb-3">
							<div class="card-body">
								<h6 class="large title-style"><span>Finish Goods Stock</span></h6>
								<canvas id="productsalepricetrendanalysis" width="800" height="250"></canvas>
							</div>
						</div>
					</div>
					<div class="p-0 p-2">
						<div class="card border-black shadow-none mt-3 mb-3">
							<div class="card-body">
								<h6 class="large title-style"><span>Material Stock</span></h6>
								<canvas id="materialsalepricetrendanalysis" width="800" height="250"></canvas>
							</div>
						</div>
					</div> -->
				</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

	$(document).ready(function () {
		// Bar chart
		new Chart(document.getElementById("producttrendanalysis"), {
			type: 'bar',
			data: {
				labels: <?php echo $xline; ?> ,
				datasets : [{
					label: "",
					backgroundColor: function () {
						// Call the getRandomColor function to generate a random color
						return getRandomColor();
					},
					data: <?php echo $yline; ?>,
				}]
			},
			options: {
				scales: {
			xAxes: [{
				barPercentage: 1.1
			}]
		},
				legend: {
					display: false
				},
				title: {
					display: true,
					text: 'Month'
				},
			}
		});

	    // Bar chart
		new Chart(document.getElementById("dailygraph"), {
    	type: 'bar',
    	data: {
    		labels: <?php echo $xlinedaily; ?> ,
    		datasets : [{
    			label: "",
    			backgroundColor: function () {
    				// Call the getRandomColor function to generate a random color
    				return getRandomColor();
    			},
    			data: <?php echo $ylinedaily; ?>,
    		}]
    	},
    	options: {
            scales: {
        xAxes: [{
            barPercentage: 1.1
        }]
    },
    		legend: {
    			display: false
    		},
    		title: {
    			display: true,
    			text: 'Day'
    		},
    	}
    });

	new Chart(document.getElementById("productsalepricetrendanalysis"), {
		type: 'bar',
		data: {
			labels: <?php echo $xline2; ?>,
			datasets : [{
				label: "",
				backgroundColor: function () {
					// Call the getRandomColor function to generate a random color
					return getRandomColor();
				},
				data: <?php echo $yline2; ?>,
			}]
		},
		options: {
			scales: {
				xAxes: [{
					// Remove the 'barPercentage' property
				}]
			},
			legend: {
				display: false
			},
			title: {
				display: true,
				text: 'Finish Goods'
			},
		}
	});

	new Chart(document.getElementById("materialsalepricetrendanalysis"), {
		type: 'bar',
		data: {
			labels: <?php echo $xline3; ?>,
			datasets : [{
				label: "",
				backgroundColor: function () {
					// Call the getRandomColor function to generate a random color
					return getRandomColor();
				},
				data: <?php echo $yline3; ?>,
			}]
		},
		options: {
			scales: {
				xAxes: [{
					// Remove the 'barPercentage' property
				}]
			},
			legend: {
				display: false
			},
			title: {
				display: true,
				text: 'Materials'
			},
		}
	});


	
	$('#productiontable').DataTable({
		"destroy": true,
		"processing": true,
		"serverSide": true,
		dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
		responsive: true,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, 'All'],
		],
		"buttons": [{
				extend: 'csv',
				className: 'btn btn-success btn-sm',
				title: 'Employee Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Employee Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Employee Information',
				className: 'btn btn-primary btn-sm',
				text: '<i class="fas fa-print mr-2"></i> Print',
				customize: function (win) {
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				},
			},
			// 'copy', 'csv', 'excel', 'pdf', 'print'
		],
		ajax: {
			url: "<?php echo base_url() ?>scripts/qtylist.php",
			type: "POST", // you can use GET
			// data: function(d) {}
		},
		"order": [
			[0, "desc"]
		],
		"columns": [{
				"data": "idtbl_semi_production"
			},
			{
				"data": "materialinfocode"
			},
			{
				"data": "qty"
			},
			{
				"data": "procode"
			},
			{
				"data": "prodate"
			},
			{
				"targets": -1,
				"className": '',
				"data": null,
				"render": function(data, type, full) {
					if(full['approvestatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Production Order Approved';}
					else{return '<i class="fas fa-times text-danger mr-2"></i>Production Order Not Approved';}
				}
			},
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$('#packingtable').DataTable({
		"destroy": true,
		"processing": true,
		"serverSide": true,
		dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
		responsive: true,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, 'All'],
		],
		"buttons": [{
				extend: 'csv',
				className: 'btn btn-success btn-sm',
				title: 'Employee Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Employee Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Employee Information',
				className: 'btn btn-primary btn-sm',
				text: '<i class="fas fa-print mr-2"></i> Print',
				customize: function (win) {
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				},
			},
			// 'copy', 'csv', 'excel', 'pdf', 'print'
		],
		// ajax: {
		// 	url: "<?php echo base_url() ?>scripts/qtylist.php",
		// 	type: "POST", // you can use GET
		// 	// data: function(d) {}
		// },
		// "order": [
		// 	[0, "desc"]
		// ],
		// "columns": [{
		// 		"data": "id"
		// 	},
		// 	{
		// 		"data": "name"
		// 	},
		// 	{
		// 		"data": "productcode"
		// 	},
		// 	{
		// 		"data": "duedate"
		// 	},
		// 	{
		// 		"data": "order_qty"
		// 	},
		// 	{
		// 		"data": "shipped_qty"
		// 	},
		// 	{
		// 		"data": "packed_qty"
		// 	},
		// 	{
		// 		"data": "label_qty"
		// 	},
		// 	{
		// 		"data": "balance_qty"
		// 	},
		// ],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
});
    
</script>
<?php include "include/footer.php"; ?>
