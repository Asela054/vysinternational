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
                            <div class="page-header-icon"><i class="fas fa-briefcase"></i></div>
                            <span>Production Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Production</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Semi Material Code</th>
                                            <th>Material Name</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal Create -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title" id="staticBackdropLabel">Create Production</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-3">
						<form id="formproduction">
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Date</label>
								<input type="date" class="form-control form-control-sm" name="prodate" id="prodate" required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Semi Material</label><br>
								<select class="form-control form-control-sm" name="semimaterial" id="semimaterial" style="width: 100%;" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Qty</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control form-control-sm col-10" name="qty" id="qty" required>
									<input type="text" id="unit" name="unit" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitcheck" <?php if($addcheck==0){echo 'disabled';} ?>>Check Production</button>
								<input type="submit" id="hidesubmit" class="d-none">
							</div>
						</form>
                    </div>
					<div class="col-9 border border-right-0 border-top-0 border-bottom-0">
						<table class="table table-striped table-bordered table-sm small" id="tablebomqtyinfo">
							<thead>
								<tr>
									<th>#</th>
									<th class="d-none">MaterialID</th>
									<th>Material</th>
									<th>Qty</th>
									<th>Batch No</th>
								</tr>
							</thead>
							<tbody id="tablebody"></tbody>
						</table>
						<hr>
						<div class="row">
							<div class="col-12 text-right">
								<button type="button" class="btn btn-danger btn-sm small" id="btnstartproduction" <?php if($addcheck==0){echo 'disabled';} ?> disabled>Create Production</button>
							</div>
							<div class="col-12">
								<hr>
								<div id="alertdiv"></div>
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal View Detail -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Production information of <label id="procode"></label> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewproduction"></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Batch No List -->
<div class="modal fade" id="modalbatchno" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Material Issue Batch No</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="formbatchno">
							<div class="form-group">
								<label class="small font-weight-bold">Stock Batch No</label><br>
								<select class="form-control form-control-sm" name="batchnolist[]" id="batchnolist" style="width: 100%;" multiple required>
								</select>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitbatch" <?php if($addcheck==0){echo 'disabled';} ?>>Done</button>
								<input type="submit" id="hidesubmitbatch" class="d-none">
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
$(document).ready(function () {
	var addcheck = '<?php echo $addcheck; ?>';
	var editcheck = '<?php echo $editcheck; ?>';
	var statuscheck = '<?php echo $statuscheck; ?>';
	var deletecheck = '<?php echo $deletecheck; ?>';

	var rowID;

	$('#batchnolist').select2();
	$("#batchnolist").on("select2:select", function (evt) {
		var element = evt.params.data.element;
		var $element = $(element);
		
		$element.detach();
		$(this).append($element);
		$(this).trigger("change");
	});
	$("#semimaterial").select2({
		dropdownParent: $('#staticBackdrop'),
		// placeholder: 'Select supplier',
		ajax: {
			url: "<?php echo base_url() ?>Semiproduction/GetSemimateriallist",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term // search term
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

	$("#semimaterial").on('change', function () {
		var unit = $(this).find("option:selected").text().split('/');
		$("#unit").val(unit[1]);
	});

	$('#btnsubmitcheck').click(function(){
		if (!$("#formproduction")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmit").click();
		} else {
			var prodate = $('#prodate').val();
			var semimaterial = $('#semimaterial').val();
			var qty = $('#qty').val();
			$('#btnsubmitcheck').prop('disabled', true);

			$.ajax({
				type: "POST",
				data: {
					prodate: prodate,
					semimaterial: semimaterial,
					qty: qty
				},
				url: '<?php echo base_url() ?>Semiproduction/Getprodcutioninfo',
				success: function(result) { //alert(result);
					var obj = JSON.parse(result);
					$('#tablebody').html(obj.htmlview);
					if(obj.stockstatus==1){
						$('#btnstartproduction').prop('disabled', true);
						$('#alertdiv').html('<div class="alert alert-danger" role="alert">Some Product quantity not enough for you production. Please check stock and production start again.</div>');
					}
					else{
						$('#btnstartproduction').prop('disabled', false);
					}
				}
			}); 
		}
	});
	$('#tablebomqtyinfo tbody').on('click', 'tr', function () {
		var row = $(this);
		// console.log(row);
        var materialID = row.closest("tr").find('td:eq(1)').text();
		rowID = row.closest("tr")[0].rowIndex;
		
		$.ajax({
			type: "POST",
			data: {
				materialID: materialID
			},
			url: '<?php echo base_url() ?>Semiproduction/Getbatchnolistaccomaterial',
			success: function(result) { //alert(result);
				var objfirst = JSON.parse(result);

                var html = '';
                $.each(objfirst, function(i, item) {
                    //alert(objfirst[i].id);
                    html += '<option value="' + objfirst[i].batchno + '">';
                    html += objfirst[i].batchno+' - '+objfirst[i].qty+objfirst[i].unitcode;
                    html += '</option>';
                });

				$('#batchnolist').empty().append(html);
				$('#batchnolist').trigger('change');
				$('#modalbatchno').modal('show');
			}
		}); 
	});
	$('#btnsubmitbatch').click(function(){
		if (!$("#formbatchno")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmitbatch").click();
		} else {
			$('#tablebomqtyinfo').find('tr').eq(rowID).find('td:eq(4)').text($('#batchnolist').val());
			$('#batchnolist').empty().trigger('change');
			$('#modalbatchno').modal('hide');
		}
	});
	$('#btnstartproduction').click(function(){
		$('#btnstartproduction').prop('disabled', true);
		var prodate = $('#prodate').val();
		var semimaterial = $('#semimaterial').val();
		var qty = $('#qty').val();

		var emptybatch = 0;
		var tbody = $('#tablebomqtyinfo tbody');
    	if (tbody.children().length > 0) {
    		var jsonObj = []
    		$("#tablebomqtyinfo tbody tr").each(function () {
    			item = {}
    			$(this).find('td').each(function (col_idx) {
					if($(this).text()==''){
						emptybatch=1;
					}
    				item["col_" + (col_idx + 1)] = $(this).text();
    			});
    			jsonObj.push(item);
    		});
    	}
		// console.log(jsonObj);
		if(emptybatch==1){
			$('#alertdiv').html('<div class="alert alert-danger" role="alert">Please select material stock batch no for issue materials.</div>');
		}
		else{
			$.ajax({
				type: "POST",
				data: {
					prodate: prodate,
					semimaterial: semimaterial,
					qty: qty,
					tableData: jsonObj
				},
				url: '<?php echo base_url() ?>Semiproduction/Semiproductioninsertupdate',
				success: function(result) { //alert(result);
					// console.log(result);
					window.location.reload();
				}
			}); 
		}
	});
	$('#staticBackdrop').on('hidden.bs.modal', function () {
		window.location.reload();
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
		"buttons": [{
				extend: 'csv',
				className: 'btn btn-success btn-sm',
				title: 'Brand Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Brand Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Brand Information',
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
			url: "<?php echo base_url() ?>scripts/semiprodcutionlist.php",
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
				"data": "prodate"
			},
			{
				"data": "materialinfocode"
			},
			{
				"data": "materialname"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';
					button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-eye"></i></button>';

                    if(full['approvestatus']==1){
                        button+='<button type="button" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
                    }else{
                        button+='<a href="<?php echo base_url() ?>Semiproduction/Semiproductionapprove/'+full['idtbl_semi_production']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                    }

					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('#dataTable tbody').on('click', '.btnview', function () {
		var id = $(this).attr('id');
		var p = $(this).parent().parent();
		var td = p.children("td:nth-child(3)").html();
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Semiproduction/Semiproductiondetails',
			success: function (result) { //alert(result);
				$('#viewproduction').html(result);
				$('#exampleModalCenter').modal('show');
			}
		});
	});
});

function deactive_confirm() {
	return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
	return confirm("Are you sure you want to approve this production, Please double check befor appove?");
}

function delete_confirm() {
	return confirm("Are you sure you want to remove this?");
}

function transfer_confirm() {
	return confirm("Are you sure you want to transfer this?");
}
</script>
<?php include "include/footer.php"; ?>