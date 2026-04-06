
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
                            <div class="page-header-icon"><i class="fas fa-wind"></i></div>
                            <span>Drier</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Drier/DrierInsertupdate" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Drier*</label>
                                        <input type="text" class="form-control form-control-sm" name="drier"
                                            id="drier" required>
                                    </div>

                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1" required>
                                    <input type="hidden" name="recordID" id="recordID" value="" required>

                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Drier</th>
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
        <!-- Modal -->
    <div class="modal fade" id="driermodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="driermodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="driermodalLabel">&nbsp;</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="drierForm" action="<?php echo base_url() ?>Drier/Drierdailyinfoinsertupdate" method="post" autocomplete="off">
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold">Date*</label>
                            <input type="date" class="form-control form-control-sm" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold">Time*</label>
                            <select class="form-control form-control-sm" name="time" id="time" required>
                                        <option value="">-- Select Time --</option>
                                        <?= $time;?>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold">Temperature*</label>
                            <input type="number" class="form-control form-control-sm" name="temp" id="temp" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold">Remark*</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                            <input type="hidden" name="drierid" id="drierid" value="" required>
                        <div class="form-group mt-2 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                <?php if($addcheck==0){echo 'disabled';} ?>><i
                                    class="far fa-save"></i>&nbsp;Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Drier Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Drier Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Drier Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'csv', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/drierlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "drier"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-warning btn-sm btntempadd mr-1" data-toggle="tooltip" data-placement="bottom" title="Drier Daily info" id="'+full['id']+'"><i class="fas fa-plus"></i></button>';

                        if(editcheck==1){
                            button+='<button type="button" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['id']+'"><i class="fas fa-pen"></i></button>';
                        }
                        if(full['status']==1 && statuscheck==1){
                            button+='<button type="button" data-url="Drier/Drierstatus/'+full['id']+'/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        }else if(full['status']==2 && statuscheck==1){
                            button+='<button type="button" data-url="Drier/Drierstatus/'+full['id']+'/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if(deletecheck==1){
                            button+='<button type="button" data-url="Drier/Drierstatus/'+full['id']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }

                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', async function() {
            var r = await Otherconfirmation("You want to edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Drier/Drieredit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#drier').val(obj.name);                        

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });

        $('#dataTable tbody').on('click', '.btntempadd', function () {
			var id = $(this).attr('id');
			$('#drierid').val(id);
			$('#driermodal').modal('show');
		});

        $("#drierForm").submit(function(e){
            e.preventDefault(); 

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: $(this).serialize(),
                success: function(response){

                    if(response.trim() === "success"){

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Drier info added successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $("#drierForm")[0].reset();   
                        $("#driermodal").modal('hide'); 

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Insert failed!'
                        });

                    }
                }
            });
        });
    });
</script>
<?php include "include/footer.php"; ?>
