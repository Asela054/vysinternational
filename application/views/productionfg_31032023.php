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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i class="fas fa-exchange-alt"></i></div>
                            <span>Production FG</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                            <div class="scrollbar pb-3" id="style-2">
                            	<table class="table table-bordered table-striped table-sm nowrap"
                            		id="productionfgtable">
                            		<thead>
                                    <tr>
												<th>#</th>
												<th>Product</th>
												<th>Production Code</th>
												<th>Production Qty</th>
												<th>Transfer Qty</th>
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
<!-- Modal Production Quality -->
<div class="modal fade" id="modalquality" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Finish Good Stock Transfer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
            <div class="row">
                            <div class="col">
                                <form action="<?php echo base_url() ?>Productionfg/Productionfginsertupdate" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                    <input type="hidden" class="form-control form-control-sm" name="fgid" id="fgid" required>
                                    <input type="hidden" class="form-control form-control-sm" name="productid" id="productid" required>
                                    <input type="hidden" class="form-control form-control-sm" name="productcode" id="productcode" required>

                                    </div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Location*</label>
                                        <select class="form-control form-control-sm" name="location" id="location" required>
                                            <option value="">Select</option>
                                            <?php foreach($location->result() as $rowlocation){ ?>
                                            <option value="<?php echo $rowlocation->idtbl_location ?>"><?php echo $rowlocation->location ?></option>
                                            <?php } ?>
                                        </select>
                                            </div>
                                			<div class="col">
                                            <label class="small font-weight-bold">Quantity</label>
                                			<input type="text" class="form-control form-control-sm" name="qty"
                                				id="qty">
                                		</div>
                                	</div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#productionfgtable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Employee Information',
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
                url: "<?php echo base_url() ?>scripts/productionfglist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
					"data": "id"
				},
				{
					"data": "productcode"
				},
				{
					"data": "productioncode"
				},
				{
					"data": "totalqty"
				},
                {
					"data": "transfgqty"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnmodal mr-1" id="' + full[ 'id'] + '" value="' + full[ 'productid'] + '" name="' + full[ 'productioncode'] + '"><i class="fas fa-exchange-alt"></i></button>';
						return button;
					}
				}
			],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#productionfgtable tbody').on('click', '.btnmodal', function() {
                var id = $(this).attr('id');
                var productid = $(this).attr('value');
                var productcode = $(this).attr('name');
                // alert(productid);
                $('#fgid').val(id);
                $('#productid').val(productid);
                $('#productcode').val(productcode);
                $('#modalquality').modal('show');
        });

    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }
</script>
<?php include "include/footer.php"; ?>
