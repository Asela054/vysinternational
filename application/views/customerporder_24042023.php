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
                            <div class="page-header-icon"><i class="fas fa-shopping-cart"></i></div>
                            <span>Sales Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Sales Order</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sales Order Type</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Confirm Status</th>
                                                <!-- <th>Transfer Status</th> -->
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
<div class="modal fade" id="productionorder" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered ">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Production Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    	<form action="<?php echo base_url() ?>Customerporder/Porderinsertupdate" method="post"
                    		autocomplete="off">
                    		<div class="form-row mb-1 p-1">
                    			<input type="hidden" class="form-control form-control-sm" name="orderid" id="orderid">
                    			<label class="small font-weight-bold text-dark">Product*</label><br>
                    			<select class="form-control form-control-sm" style="width: 100%;" name="productlist"
                    				id="productlist" required>
                    			</select>
                    		</div>
                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold">Order Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="orderqty" id="orderqty"
                    					readonly>
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Production Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="proqty" id="proqty"
                    					required>
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Balance Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="balanceqty"
                    					id="balanceqty" readonly>
                    			</div>
                    		</div>
                            

                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold d-none">Material Unit Cost*</label>
                    				<input type="text" class="form-control form-control-sm d-none" name="uprice" id="uprice"
                    					required>
                    			</div>
                    		</div>
                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold">Production Start Date</label>
                    				<input type="date" class="form-control form-control-sm" name="startdate" id="startdate">
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Production End Date</label>
                    				<input type="date" class="form-control form-control-sm" name="enddate" id="enddate">
                    			</div>
                    		</div>
                    		<div class="form-group mt-3 text-right">
                    			<button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm fa-pull-right"
                    				<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Create
                    				Production Order</button>
                    		</div>
                    	</form>
                    </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Sales Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Sales Order Type*</label>
                                <select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
                                    <option value="">Select</option>
                                    <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                    <option value="<?php echo $rowordertypelist->idtbl_order_type ?>"><?php echo $rowordertypelist->type ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="orderdate" id="orderdate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Due Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="duedate" id="duedate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">                                
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Sale Type*</label>
                                    <select class="form-control form-control-sm" name="saletype" id="saletype" required>
                                        <option value="">Select</option>
                                        <option value="1">Local</option>
                                        <option value="2">Export</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Customer*</label>
                                    <select class="form-control form-control-sm" name="customer" id="customer" required>
                                        <option value="">Select</option>
                                        <?php foreach($customerlist->result() as $rowcustomerlist){ ?>
                                        <option value="<?php echo $rowcustomerlist->idtbl_customer ?>"><?php echo $rowcustomerlist->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label><br>
                                    <select class="form-control form-control-sm" style="width: 100%;" name="product" id="product" required>
                                        <option value="">Select</option>
                                        <?php foreach($prodcutlist->result() as $rowprodcutlist){ ?>
                                        <option value="<?php echo $rowprodcutlist->idtbl_product ?>"><?php echo $rowprodcutlist->materialname.' - '.$rowprodcutlist->productcode ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="text" id="newqty" name="newqty" class="form-control form-control-sm" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark d-none">Material Unit Cost</label>
                                    <input type="text" id="unitprice" name="unitprice" class="form-control form-control-sm d-none" value="0">

                                    <label class="small font-weight-bold text-dark">Suggest Price</label>
                            		<input type="text" id="suggestprice" name="suggestprice"
                            			class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                            	<div class="col">
                            		<!-- <label class="small font-weight-bold text-dark">Suggest Price</label>
                            		<input type="text" id="suggestprice" name="suggestprice"
                            			class="form-control form-control-sm"> -->
                            	</div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <table class="table table-striped table-bordered table-sm small" id="tableorder">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unitprice</th>
                                    <th class="text-right d-none">Material Unit Cost</th>
                                    <th class="text-center">Qty</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Suggest Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create Sales
                                Order</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">View Sales Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <h4 class="text-right">UN/SOD-0000<label id="salesordercode"></label></h4>
                <div id="viewhtml"></div>
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
        $('#product').select2({dropdownParent: $('#staticBackdrop')});

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Purchase Order Information',
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
                url: "<?php echo base_url() ?>scripts/customerpurchaseorderlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_customer_porder"
                },
                {
                    "data": "type"
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "name"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';}
                        else{return 'Not Confirm Order';}
                    }
                },
                // {
                //     "targets": -1,
                //     "className": '',
                //     "data": null,
                //     "render": function(data, type, full) {
                //         if(full['transproductionstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Transfer to production';}
                //         else{return 'Not Transfer to production';}
                //     }
                // },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        //button+='<button class="btn btn-warning btn-sm btnAddCosting mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-list"></i></button>';
                        button+='<button class="btn btn-primary btn-sm btnAdd mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-plus"></i></button>';
                        button+='<button class="btn btn-dark btn-sm btnview mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-eye"></i></button>';
                        if(full['confirmstatus']==1){
                            button+='<button class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></button>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Customerporder/Customerporderstatus/'+full['idtbl_customer_porder']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        if(full['transproductionstatus']==0){
                            // button+='<a href="<?php echo base_url() ?>Customerporder/Customerporderstatus/'+full['idtbl_customer_porder']+'/2" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-random"></i></a>';
                        }
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnview', function() {
            var id = $(this).attr('id');
            $('#salesordercode').html(id);
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Customerporder/Customerporderview',
                success: function(result) { //alert(result);
                    $('#porderviewmodal').modal('show');
                    $('#viewhtml').html(result);
                }
            });
        });  
        $('#dataTable tbody').on('click', '.btnAdd', function () {
        	var id = $(this).attr('id');
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Customerporder/Getcustomerporderdetails',
        		success: function (result) { //alert(result);
        			var obj = JSON.parse(result);
        			var html1 = '';
        			html1 += '<option value="">Select</option>';
        			$.each(obj, function (i) {
        				html1 += '<option value="' + obj[i].idtbl_product + '">';
        				html1 += obj[i].materialname + ' - ' + obj[i].productcode;
        				html1 += '</option>';
        			});
        			$('#productlist').empty().append(html1);
        			$('#orderid').val(obj[0].idtbl_customer_porder);
        			$('#productionorder').modal('show');
        		}
        	});
        });
        $("#productlist").change(function (event) {
            event.preventDefault();
            var productid = $('#productlist').val();
            var orderid = $('#orderid').val();
            $.ajax({
                type: "POST",
                data: {
                product:productid,
                orderid:orderid,
                  },
                url: '<?php echo base_url() ?>Customerporder/Getorderqty',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#orderqty').val(obj[0].qty);
                    $('#uprice').val(obj[0].unitprice);

                }
            });
        });
        $("#productlist").change(function (event) {
            event.preventDefault();
            var productid = $('#productlist').val();
            var orderid = $('#orderid').val();
            $.ajax({
                type: "POST",
                data: {
                product:productid,
                orderid:orderid,
                  },
                url: '<?php echo base_url() ?>Customerporder/Getbalanceqty',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#balanceqty').val(obj[0].qtydiff);

                    

                }
            });
        });
        $('#product').change(function () {
            let productID = $(this).val();
            let saletype = $('#saletype').val();

            if(productID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: productID,
                        saletype: saletype
                    },
                    url: 'Customerporder/Getproductpriceaccoproduct',
                    success: function (result) { //alert(result);
                        $('#unitprice').val(result);
                        $('#newqty').focus();
                    }
                });
            }
        });
        $('#newqty').keypress(function (e){
            var key = e.which;
            if(key == 13){
                $('#comment').focus();
                return false;  
            }            
        });
        $('#comment').keypress(function (e){
            var key = e.which;
            if(key == 13){
                $('#formsubmit').click();
                return false;  
            }    
        });
        $("#formsubmit").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn").click();
            } else {
                var productID = $('#product').val();
                var comment = $('#comment').val();
                var product = $("#product option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var suggestprice = $('#suggestprice').val();
                var newqty = parseFloat($('#newqty').val());

                var newtotal = parseFloat(suggestprice * newqty);


                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + unitprice + '</td><td class="text-right d-none">' + addCommas(parseFloat(unitprice).toFixed(2)) + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + suggestprice + '</td><td class="text-right">' + showtotal + '</td></tr>');

                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#product').val('').trigger('change');
                $('#comment').val('');
                $('#suggestprice').val('');
                $('#newqty').val('0');


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
        $('#tableorder').on('click', 'tr', function () {
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
        $('#btncreateorder').click(function () { //alert('IN');
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
            var tbody = $("#tableorder tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tableorder tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                 console.log(jsonObj);

                var orderdate = $('#orderdate').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var customer = $('#customer').val();
                var ordertype = $('#ordertype').val();
                var wastage = $('#wastage').val();
                var othercost = $('#othercost').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        orderdate: orderdate,
                        duedate: duedate,
                        total: total,
                        remark: remark,
                        customer: customer,
                        ordertype: ordertype,
                        wastage: wastage,
                        othercost: othercost,
                    },
                    url: 'Customerporder/Customerporderinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            $('#modalgrnadd').modal('hide');
                            setTimeout(window.location.reload(), 3000);
                        }
                        action(obj.action);
                    }
                });
            }

        });
    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to confirm this purchase order?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
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
