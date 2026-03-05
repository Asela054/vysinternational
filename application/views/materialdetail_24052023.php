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
                            <div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
                            <span>Material</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-file-upload mr-2"></i>Upload File</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <form action="<?php echo base_url() ?>Materialdetail/Materialdetailinsertupdate" method="post" autocomplete="off">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Name*</label>
                                            <select class="form-control form-control-sm" name="materialname" id="materialname" required>
                                                <option value="">Select</option>
                                                <?php foreach($materialname->result() as $rowmaterialname){ ?>
                                                <option value="<?php echo $rowmaterialname->idtbl_material_code ?>"><?php echo $rowmaterialname->materialname.'-'.$rowmaterialname->materialcode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Category*</label>
                                            <select class="form-control form-control-sm" name="materialcategory" id="materialcategory" required>
                                                <option value="">Select</option>
                                                <?php foreach($materialcategory->result() as $rowmaterialcategory){ ?>
                                                <option value="<?php echo $rowmaterialcategory->idtbl_material_category ?>"><?php echo $rowmaterialcategory->categoryname.'-'.$rowmaterialcategory->categorycode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-6" id="divbrand">
                                            <label class="small font-weight-bold">Brand*</label>
                                            <select class="form-control form-control-sm" name="brand" id="brand">
                                                <option value="">Select</option>
                                                <?php foreach($brand->result() as $rowbrand){ ?>
                                                <option value="<?php echo $rowbrand->idtbl_brand ?>"><?php echo $rowbrand->brandname.'-'.$rowbrand->brandcode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divform">
                                            <label class="small font-weight-bold">Form*</label>
                                            <select class="form-control form-control-sm" name="form" id="form">
                                                <option value="">Select</option>
                                                <?php foreach($form->result() as $rowform){ ?>
                                                <option value="<?php echo $rowform->idtbl_form ?>"><?php echo $rowform->formname.'-'.$rowform->formcode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divgrade">
                                            <label class="small font-weight-bold">Grade*</label>
                                            <select class="form-control form-control-sm" name="grade" id="grade">
                                                <option value="">Select</option>
                                                <?php foreach($grade->result() as $rowgrade){ ?>
                                                <option value="<?php echo $rowgrade->idtbl_grade ?>"><?php echo $rowgrade->gradename.'-'.$rowgrade->gradecode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divsize">
                                            <label class="small font-weight-bold">Size*</label>
                                            <select class="form-control form-control-sm" name="size" id="size">
                                                <option value="">Select</option>
                                                <?php foreach($size->result() as $rowsize){ ?>
                                                <option value="<?php echo $rowsize->idtbl_size ?>"><?php echo $rowsize->sizename.'-'.$rowsize->sizecode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divside">
                                            <label class="small font-weight-bold">Side*</label>
                                            <select class="form-control form-control-sm" name="side" id="side">
                                                <option value="">Select</option>
                                                <?php foreach($side->result() as $rowside){ ?>
                                                <option value="<?php echo $rowside->idtbl_side ?>"><?php echo $rowside->sidename.'-'.$rowside->sidecode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divunittype">
                                            <label class="small font-weight-bold">Unit Type*</label>
                                            <select class="form-control form-control-sm" name="unittype" id="unittype">
                                                <option value="">Select</option>
                                                <?php foreach($unittype->result() as $rowunittype){ ?>
                                                <option value="<?php echo $rowunittype->idtbl_unit_type ?>"><?php echo $rowunittype->unittypename.'-'.$rowunittype->unittypecode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="divunit">
                                            <label class="small font-weight-bold">Unit*</label>
                                            <select class="form-control form-control-sm" name="unit" id="unit">
                                                <option value="">Select</option>
                                                <?php foreach($unit->result() as $rowunit){ ?>
                                                <option value="<?php echo $rowunit->idtbl_unit ?>"><?php echo $rowunit->unitname.'-'.$rowunit->unitcode ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Re-order Level*</label>
                                            <input type="text" class="form-control form-control-sm" name="reorder" id="reorder">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Comment*</label>
                                        <textarea class="form-control form-control-sm" name="comment" id="comment"></textarea>
                                    </div>
                                    <div class="form-group">
                                    	<label class="small font-weight-bold text-dark">Semi Product</label><br>
                                    	<div class="custom-control custom-radio custom-control-inline">
                                    		<input type="radio" id="yesstatus" name="semistatus"
                                    			class="semistatus custom-control-input" value="1">
                                    		<label class="custom-control-label" for="yesstatus">Yes</label>
                                    	</div>
                                    	<div class="custom-control custom-radio custom-control-inline">
                                    		<input type="radio" id="nostatus" name="semistatus"
                                    			class="semistatus custom-control-input" value="0" checked>
                                    		<label class="custom-control-label" for="nostatus">No</label>
                                    	</div>
                                    </div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-8">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Name</th>
                                                <th>Code</th>
                                                <th>Material Code</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Form</th>
                                                <th>Grade</th>
                                                <th>Size</th>
                                                <th>Side</th>
                                                <th>Unit Type</th>
                                                <th>Unit</th>
                                                <th>Re Order</th>
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
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Upload file</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="<?php echo site_url('csv/samplematerialinfo.csv') ?>" download>Click here</a> to download a Sample Csv
                    </div>
                </div>
                <form action="<?php echo base_url() ?>Materialdetail/Materialdetailupload" method="post" enctype="multipart/form-data">
                    <div class="input-group input-group-sm">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="csvfile" name="csvfile" aria-describedby="csvfile" required>
                            <label class="custom-file-label" for="csvfile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit" id="csvfile">Upload File</button>
                        </div>
                    </div>
                </form>
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Material Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Material Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Material Information', 
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
                url: "<?php echo base_url() ?>scripts/materialdetaillist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_material_info"
                },
                {
                    "data": "materialname"
                },
                {
                    "data": "materialinfocode"
                },
                {
                    "data": "materialcode"
                },
                {
                    "data": "categoryname"
                },
                {
                    "data": "brandcode"
                },
                {
                    "data": "formcode"
                },
                {
                    "data": "gradecode"
                },
                {
                    "data": "sizecode"
                },
                {
                    "data": "sidecode"
                },
                {
                    "data": "unittypecode"
                },
                {
                    "data": "unitcode"
                },
                {
                    "data": "reorderlevel"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_material_info']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Materialdetail/Materialdetailstatus/'+full['idtbl_material_info']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Materialdetail/Materialdetailstatus/'+full['idtbl_material_info']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Materialdetail/Materialdetailstatus/'+full['idtbl_material_info']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Materialdetail/Materialdetailedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        checkfield(obj.materialcategory);
                        $('#recordID').val(obj.id);
                        $('#materialname').val(obj.materialcode);                       
                        $('#materialcategory').val(obj.materialcategory);                       
                        $('#brand').val(obj.brand);                       
                        $('#form').val(obj.form);                       
                        $('#grade').val(obj.grade);                       
                        $('#size').val(obj.size);                       
                        $('#side').val(obj.side);                       
                        $('#code').val(obj.materialcode);                       
                        $('#unittype').val(obj.unittype);                       
                        $('#unit').val(obj.unit);                       
                        $('#reorder').val(obj.reorderlevel);                       
                        $('#comment').val(obj.comment); 
                        $('input[type="radio"].semistatus[value="' + obj.semistatus + '"]').prop('checked', true);                  

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
        $('#materialcategory').change(function(){
            var id = $(this).val();
            checkfield(id);
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

    function checkfield(id){
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Materialdetail/Materialdetailcheck',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                
                if(obj.brandstatus==0){$('#divbrand').addClass('d-none');}
                else{$('#divbrand').removeClass('d-none');}
                if(obj.formstatus==0){$('#divform').addClass('d-none');}
                else{$('#divform').removeClass('d-none');}
                if(obj.gradestatus==0){$('#divgrade').addClass('d-none');}
                else{$('#divgrade').removeClass('d-none');}
                if(obj.sizestatus==0){$('#divsize').addClass('d-none');}
                else{$('#divsize').removeClass('d-none');}
                if(obj.sidestatus==0){$('#divside').addClass('d-none');}
                else{$('#divside').removeClass('d-none');}
                if(obj.unittypestatus==0){$('#divunittype').addClass('d-none');}
                else{$('#divunittype').removeClass('d-none');}
            }
        });
    }
</script>
<?php include "include/footer.php"; ?>
