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
                            <div class="page-header-icon"><i class="fas fa-water"></i></div>
                            <span>Water Bath </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Add To Water Bath</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable" width="100%">
									<thead>
                                            <tr>
												<th class="d-none">ID</th>
                                                <th>#</th>
												<th>Date</th>
                                                <th>Batch No</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
												<th>Remark</th>
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
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Water Bath</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form id="waterbathForm" autocomplete="off">

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Date*</label>
						<input type="date" class="form-control form-control-sm" 
							   name="date" value="<?php echo date('Y-m-d'); ?>" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Batch No*</label>
						<input type="text" class="form-control form-control-sm" 
							   name="batchno" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Product*</label>
						<select class="form-control form-control-sm" name="product" required>
                                    <option value="">Select</option>
                                        <?php foreach($product->result() as $products){ ?>
                                        <option value="<?php echo $products->idtbl_product ?>"><?php echo $products->prodcutname ?></option>
                                    <?php } ?>
							          
						</select>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Quantity *</label>
						<input type="number" class="form-control form-control-sm" 
							   name="qty" required>
					</div>

                    <div class="form-group mb-2">
						<label class="small font-weight-bold">Exhausting Temperature*</label>
						<input type="number" class="form-control form-control-sm" 
							   name="e_temp" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Capping Temperature*</label>
						<input type="number" class="form-control form-control-sm" 
							   name="capping_temp" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Sterilization Temperature*</label>
						<input type="number" class="form-control form-control-sm" 
							   name="ster_temp" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Steam ON Time*</label>
						<input type="time" class="form-control form-control-sm" 
							   name="steam_on" step="1" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Steam OFF Time*</label>
						<input type="time" class="form-control form-control-sm" 
							   name="steam_off" step="1" required>
					</div>

					
					<div class="form-group mb-2">
						<label class="small font-weight-bold">Number of Rejections*</label>
						<input type="number" class="form-control form-control-sm" 
							   name="n_rejections" required>
					</div>

					<div class="form-group mb-2">
						<label class="small font-weight-bold">Remark</label>
						<textarea name="remark" class="form-control form-control-sm"></textarea>
					</div>

					<div class="form-group mt-3 text-right">
						<button type="submit" class="btn btn-primary btn-sm px-4">
							<i class="fas fa-save"></i> Add
						</button>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bath Details</h5>
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Water Bath Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Water Bath Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Water Bath Information',
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
                url: "<?php echo base_url() ?>scripts/waterbathlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
				{
					data: "idtbl_water_bath",
					visible: false   
				},
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "date"
                },
				{
					"data": "batch_no"
				},
				{
					"data": "prodcutname"
				},
                {
                    "data": "qty"
                },
				{
					data: "remark"
				},
				{
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';

							button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_water_bath'] +'"><i class="fas fa-eye"></i></button>';

                        
                        return button;
                    }
                }
            ],
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


		$(document).on("click", ".btnview", function () {

			selectedID = $(this).attr("id");

			$.ajax({
				url: "WaterBath/getBathDetails",
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
				url: "WaterBath/markAsChecked",
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

		$(document).ready(function () {

		$("#waterbathForm").submit(function (e) {
			e.preventDefault();

			$.ajax({
				url: "WaterBath/WaterBathInsertUpdate",
				type: "POST",
				data: $(this).serialize(),
				dataType: "json",
				success: function (response) {

					if (response.status == 1) {

						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: 'Added successfully!',
							timer: 2000,
							showConfirmButton: false
						});

						$('#dataTable').DataTable().ajax.reload();
						$("#waterbathForm")[0].reset();
						$("#staticBackdrop").modal("hide");

					} else {

						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: response.action.message
						});

					}
				},
				error: function () {

					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong!'
					});

				}
			});
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
