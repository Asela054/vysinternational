<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
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
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Prodcution Wastage</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Add Production Wastage</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
									<thead>
                                            <tr>
												<th class="d-none">ID</th>
                                                <th>#</th>
                                                <th>Production Date</th>
                                                <th>GRN No</th>
                                                <th>Batch No</th>
												<th>Check Status</th>
                                                <th>remark</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Wastage Quantity</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Production Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="pdate" id="pdate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>

                                <div class="col">
                                    <label class="small font-weight-bold text-dark">GRN Number</label>
                                    <select class="form-control form-control-sm" name="grn" id="grn">
                                        <option value="">Select</option>
                                        <?php foreach($grnnumber->result() as $grnum){ ?>
                                        <option value="<?php echo $grnum->idtbl_grn ?>"><?php echo 'GRN-'.$grnum->idtbl_grn ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            

                            </div>
                            <div class="form-row mb-1">

                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Batch No*</label>
                                    <input type="text" class="form-control form-control-sm" name="batchno" id="batchno" required readonly>
                                </div>

                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Fruit Type*</label>
                                    <select class="form-control form-control-sm" name="fruittype" id="fruittype" required>
                                        <option value="">Select</option>
                                        <?php foreach($fruittype->result() as $ftype){ ?>
                                        <option value="<?php echo $ftype->idtbl_fruit_type ?>"><?php echo $ftype->type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm" name="product" id="product" required></select>
                                </div>
                               
                            </div>

                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Produced Quantity*</label>
                                    <input type="number" id="pqty" name="pqty" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> required value="0">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Raw </label>
                                    <input type="text" id="raw" name="raw" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> value="0">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Cutting </label>
                                <input type="number" name="cutting" id="cutting" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> value="0">
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Packing </label>
                                <input type="number" id="packing" name="packing" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?>value="0">
                            </div>

                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="tableproductionqty">
                                <thead>
                                    <tr>
										<th>Fruit Type</th>
                                        <th>Product</th>
                                        <th>Produced Qty</th>
                                        <th>Raw </th>
                                        <th>Cutting </th>
                                        <th>packing </th>
                                        <th class="d-none">ProductID</th>
										<th class="d-none">FruitTypeID</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="row">
                            
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreatewastage"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Add
                                </button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Production Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div id="viewhtml">
                </div>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm px-2" id="markCheckedBtn">
					Mark As Checked
				</button>
            </div>

        </div>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>

	var selectedID = 0;

    $(document).ready(function () {
    	var addcheck = '<?php echo $addcheck; ?>';
    	var editcheck = '<?php echo $editcheck; ?>';
    	var statuscheck = '<?php echo $statuscheck; ?>';
    	var deletecheck = '<?php echo $deletecheck; ?>';

		sessionStorage.setItem('companyid', '<?php echo $this->session->userdata('companyid'); ?>');

		$('#staticBackdrop').on('shown.bs.modal', function () {
			$('.selecter2').select2({
				width: '100%',
				dropdownParent: $('#staticBackdrop')
			});
        });

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Good Receive Note Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/productionwastagelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
				{
					data: "idtbl_production_wastage",
					visible: false   
				},
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "production_date"
                },
				{
					data: "grn",
					render: function(data, type, row){
						return "GRN-" + data;
					}
				},
                {
                    "data": "batchno"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['check_status']==1){return '<i class="fas fa-check text-success mr-2"></i>checked';}
                        else{return 'Not Checked';}
                    }
                },
                {
                    "data": "remark"
                },
                {
    				"targets": -1,
    				"className": 'text-right',
    				"data": null,
    				"render": function (data, type, full) {
    					var button = '';
						
						button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_production_wastage'] +'"><i class="fas fa-eye"></i></button>';

    					return button;
    				}
    			}
            ],
        });


		$('#grn').change(function(){
		var grnID = $(this).val();

			if(grnID != ''){
				$.ajax({
					url: "<?php echo base_url('Productionwastage/getBatchByGRN'); ?>",
					type: "POST",
					data: {grn_id: grnID},
					success: function(response){
						$('#batchno').val(response);
					}
				});
			} else {
				$('#batchno').val('');
			}
		});

		    $('#product').select2({
				width: '100%',
				placeholder: 'Search Product',
				allowClear: true,
				ajax: {
					url: "<?php echo base_url('Productionwastage/getProducts'); ?>",
					type: "POST",
					dataType: "json",
					delay: 250,

					data: function (params) {
						return {
							search: params.term 
						};
					},

					processResults: function (response) {
						return {
							results: response
						};
					},

					cache: true
				}
		});


    	$("#formsubmit").click(function () {
    		if (!$("#createorderform")[0].checkValidity()) {
    			// If the form is invalid, submit it. The form won't actually submit;
    			// this will just cause the browser to display the native HTML5 error messages.
    			$("#submitBtn").click();
    		} else {
				var productID = $('#product').val();
    			var product = $("#product option:selected").text();
    			var fruitTypeID = $('#fruittype').val();
    			var fruitType = $("#fruittype option:selected").text();
    			var productQty = parseFloat($('#pqty').val());
				var raw = parseFloat($('#raw').val());
				var cutting = parseFloat($('#cutting').val());
				var packing = parseFloat($('#packing').val());

				$('#tableproductionqty tbody').append(
					'<tr class="pointer">' +
						'<td>' + fruitType + '</td>' +
						'<td>' + product + '</td>' +
						'<td>' + productQty + '</td>' +
						'<td>' + raw + '</td>' +
						'<td>' + cutting + '</td>' +
						'<td>' + packing + '</td>' +
						'<td class="d-none">' + productID + '</td>' +
						'<td class="d-none">' + fruitTypeID + '</td>' +
					'</tr>'
				);

				$('#product').val('').trigger('change');
				$('#fruitType').val('').trigger('change');
    			$('#productQty').val('');
    			$('#raw').val('');
    			$('#cutting').val('');
    			$('#packing').val('');

    		}
    	});
    	$('#tableproductionqty').on('click', 'tr', function () {
    		var r = confirm("Are you sure, You want to remove this product ? ");
    		if (r == true) {
    			$(this).closest('tr').remove();

    			var sum = 0;
    			$(".total").each(function () {
    				sum += parseFloat($(this).text());
    			});

    			var showsum = addCommas(parseFloat(sum).toFixed(2));

    			$('#divtotal').html('Rs. ' + showsum);
    			$('#hidetotalorder').val(sum);
    			$('#product').focus();
    		}
    	});

    	$('#btncreatewastage').click(function () { //alert('IN');
    		$('#btncreatewastage').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Production Wastage')
    		var tbody = $("#tableproductionqty tbody");

    		if (tbody.children().length > 0) {
    			jsonObj = [];
    			$("#tableproductionqty tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});
    				jsonObj.push(item);
    			});
    			// console.log(jsonObj);

    			var remark = $('#remark').val();
    			var grn = $('#grn').val();
    			var productionDate = $('#pdate').val();
    			var batchno = $('#batchno').val();

    			// alert(orderdate);
    			$.ajax({
    				type: "POST",
    				data: {
    					tableData: jsonObj,
    					grn: grn,
    					remark: remark,
    					productionDate: productionDate,
    					batchno: batchno
    				},
    				url: 'Productionwastage/wastageInsertUpdate',
    				success: function (result) { //alert(result);
    					// console.log(result);
    					var obj = JSON.parse(result);
    					if (obj.status == 1) {
    						$('#modalgrnadd').modal('hide');
    						setTimeout(window.location.reload(), 3000);
    					}
    					action(obj.action);
    				}
    			});
    		}

    	});

		$(document).on("click", ".btnview", function () {

			selectedID = $(this).attr("id");

			$.ajax({
				url: "Productionwastage/getWastageDetails",
				type: "POST",
				data: { id: selectedID },
				dataType: "json",  
				success: function (response) {

					$("#viewhtml").html(response.html);

					if(response.showButton){
						$("#markCheckedBtn").show();
					} else {
						$("#markCheckedBtn").hide();
					}

					$("#viewModal").modal("show");
				},
				error: function(xhr, status, error){
					console.error("AJAX Error:", status, error);
					alert("Something went wrong while fetching data.");
				}
			});

		});

		$("#markCheckedBtn").click(function () {

			if(selectedID == 0){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Invalid ID!'
				});
				return;
			}

			$.ajax({
				url: "Productionwastage/markAsChecked",
				type: "POST",
				data: { id: selectedID },
				success: function (response) {

					if(response === "success"){
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: 'Marked as Checked Successfully',
							timer: 1500,
							showConfirmButton: false
						});

						$("#viewModal").modal("hide");
						$('#dataTable').DataTable().ajax.reload();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Error updating status'
						});
					}
				},
				error: function(xhr, status, error){
					Swal.fire({
						icon: 'error',
						title: 'AJAX Error',
						text: error
					});
				}
			});

		});


    });

    function deactive_confirm() {
    	return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
    	return confirm("Are you sure you want to approve this good receive note?");
    }

    function delete_confirm() {
    	return confirm("Are you sure you want to reject this good receive note?");
    }

    function addCommas(nStr) {
    	nStr += '';
    	x = nStr.split('.');
    	x1 = x[0];
    	x2 = x.length > 1 ? '.' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + ',' + '$2');
    	}
    	return x1 + x2;
    }

    function action(data) { //alert(data);
    	var obj = JSON.parse(data);
    	$.notify({
    		// options
    		icon: obj.icon,
    		title: obj.title,
    		message: obj.message,
    		url: obj.url,
    		target: obj.target
    	}, {
    		// settings
    		element: 'body',
    		position: null,
    		type: obj.type,
    		allow_dismiss: true,
    		newest_on_top: false,
    		showProgressbar: false,
    		placement: {
    			from: "top",
    			align: "center"
    		},
    		offset: 100,
    		spacing: 10,
    		z_index: 1031,
    		delay: 5000,
    		timer: 1000,
    		url_target: '_blank',
    		mouse_over: null,
    		animate: {
    			enter: 'animated fadeInDown',
    			exit: 'animated fadeOutUp'
    		},
    		onShow: null,
    		onShown: null,
    		onClose: null,
    		onClosed: null,
    		icon_type: 'class',
    		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    			'<span data-notify="icon"></span> ' +
    			'<span data-notify="title">{1}</span> ' +
    			'<span data-notify="message">{2}</span>' +
    			'<div class="progress" data-notify="progressbar">' +
    			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    			'</div>' +
    			'<a href="{3}" target="{4}" data-notify="url"></a>' +
    			'</div>'
    	});
    }

	
</script>
<?php include "include/footer.php"; ?>
