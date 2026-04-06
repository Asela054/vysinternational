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
                            <div class="page-header-icon"><i class="fas fa-car"></i></div>
                            <span>Raw Materials Vehicle Inspection</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#vehicleModal" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Add Raw Material Vehicle</button>
                                <hr>
                            </div>
                        
                            <div class="col-12">
                            <div class="scrollbar pb-3" id="style-2">
                            	<table class="table table-bordered table-striped table-sm nowrap"
                            		id="vehicleincomingtable" width="100%">
                            		<thead>
                            			<tr>
                                            <th class="d-none">ID</th>
                            				<th>#</th>
                                            <th>Date</th>
                            				<th>Vehicle Number</th>
                                            <th>supplier</th>
                                            <th>Fruit Type</th>
                                            <th>Assosiation Name</th>
                                            <th>Material Status</th>
                            				<th>Quantity</th>
                                            <th>Approval Status</th>
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
<div class="modal fade" id="vehicleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Raw Material Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?php echo base_url() ?>IncomingMaterialVehicle/MaterialVehicleInfoInsertUpdate" method="post" autocomplete="off">
                <div class="modal-body">

                    <div class="form-row mb-2">
                        <div class="col">
                            <label class="small font-weight-bold">V-Number</label>
                            <input type="text" class="form-control form-control-sm" name="v_number">
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold">Fruit Type*</label>
                            <select class="form-control form-control-sm" name="f_type" required>
                                <option value="">Select</option>
                                <?php foreach ($fruittype->result() as $fruittypes) { ?>
                                    <option value="<?= $fruittypes->idtbl_fruit_type ?>">
                                        <?= $fruittypes->type ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col">
                            <label class="small font-weight-bold">Assosiation Name</label>
                            <input type="text" class="form-control form-control-sm" name="aname">
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold">Quantity</label>
                            <input type="number" class="form-control form-control-sm" name="qty">
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col">
                            <label class="small font-weight-bold">Supplier</label>
                            <select class="form-control form-control-sm" name="supplier" required>
                                <option value="">Select</option>
                                <?php foreach ($supplier->result() as $sup) { ?>
                                    <option value="<?= $sup->idtbl_supplier ?>">
                                        <?= $sup->suppliername ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold">Farmer Assosiation Id*</label>
                            <input type="text" class="form-control form-control-sm" name="fa_id" required>
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="col">
                            <label class="small font-weight-bold">Address</label>
                            <input type="text" class="form-control form-control-sm" name="address">
                        </div>
                        <div class="col">
                            <label class="small font-weight-bold">Date</label>
                            <input type="date" class="form-control form-control-sm" name="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Material Status*</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="fstatus" value="Organic" required> Organic
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="fstatus" value="In Conventional" required> In Conventional
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="fstatus" value="Conventional" required> Conventional
                        </div>
                    </div>

                    <input type="hidden" name="recordOption" value="1">
                    <input type="hidden" name="recordID">

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm px-4"
                        <?php if($addcheck==0){echo 'disabled';} ?>>
                        <i class="far fa-save"></i> Save
                    </button>
                </div>
            </form>

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

        $('#vehicleincomingtable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Incoming Vehicle Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Incoming Vehicle Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Incoming Vehicle Information',
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
                url: "<?php echo base_url() ?>scripts/incomingmaterialvehiclelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
					data: "idtbl_raw_material_vehicle_inspection",
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
                    "data": "vehicle_number"
                },
                {
                    "data": "suppliername"
                },
                {
                    "data": "fruittype"
                },
                {
                    "data": "assosiation_name"
                },
                {
                    "data": "materail_status"
                },
                {
                    "data": "qty"
                },
                {
                "data": "approval_status",
                "render": function(data, type, full) {

                    if (data == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Aprroved';
                    } else {
                        return 'Not Approved';
                    }

                }
            },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';

                        var disabled = (full['approval_status'] == 1) ? 'disabled' : '';

                        button += '<button type="button" ' +
                            'class="btn btn-warning btn-sm btnApprove" ' +
                            'data-id="'+full['idtbl_raw_material_vehicle_inspection']+'" ' +
                            disabled + '>' +
                            '<i class="fas fa-times"></i>' +
                            '</button>';

                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('form').on('submit', function () {
            setTimeout(function () {
                $('#vehicleModal').modal('hide');
                $('#vehicleincomingtable').DataTable().ajax.reload();
            }, 1000);
        });
    });
    $(document).on('click', '.btnApprove', function () {

        var id = $(this).data('id');

        if (!id) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid ID',
                text: 'Something went wrong!'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to approve this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?php echo base_url() ?>IncomingMaterialVehicle/approveVehicle",
                    type: "POST",
                    data: { id: id },
                    success: function (response) {

                        if (response == "success") {

                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: 'Record approved successfully',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#vehicleincomingtable').DataTable().ajax.reload();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });
                        }

                    }
                });

            }

        });

    });
</script>
<?php include "include/footer.php"; ?>
