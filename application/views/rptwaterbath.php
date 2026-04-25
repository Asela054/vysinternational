<?php 
include "include/header.php"; 

include "include/topnavbar.php"; 
?>

<style>
    content-display {
        display: none;
    }
</style>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i class="fas fa-cart-arrow-down"></i></div>
                                    <span>Water Bath Report</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label class="small font-weight-bold">Select Date</label>
                                <input type="date" id="filter_date" class="form-control form-control-sm">
                            </div>

                            <!-- <div class="col-md-3">
                                <label class="small font-weight-bold">Select Drier</label>
                                <select id="drier" class="form-control form-control-sm">
                                    <option value="">Batch No</option>
                                    <?php // foreach($drierlist->result() as $row){ ?>
                                        <option value="<?php //echo $row->idtbl_drier; ?>">
                                            <?php //echo $row->name; ?>
                                        </option>
                                    <?php //} ?>
                                </select>
                            </div> -->

                            <div class="col-md-2 d-flex align-items-end">
                                <button id="btn_filter" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="row">

                                </div>
                                <hr class="border-dark">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-striped table-bordered table-sm nowrap" id="waterBathTable"
                                        style="width:100%">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Batch No</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Exhausting Temperature</th>
                                                <th>Capping Temperature</th>
                                                <th>Steritisation Temperature</th>
                                                <th>Steam On Time</th>
                                                <th>Steam Of Time</th>
                                                <th>Number Of Rejections</th>
                                                <th>Remarks</th>
                                                <th>Check By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
<?php include "include/footerscripts.php"; ?>


<script type="text/javascript">
    let today = new Date().toISOString().slice(0, 10)


    $(document).ready(function () {
    	const table = $('#waterBathTable').DataTable({
    		"destroy": true,
    		"processing": true,
    		"serverSide": true,
            "deferLoading": 0,
    		ajax: {
    			url: "scripts/rptwaterbath.php",
    			type: "POST",
                data: function (d) {
                    d.filter_date = $('#filter_date').val();
                }
    		},
    		"order": [
    			[0, "desc"]
    		],
    		"columns": [{
    				"data": "idtbl_water_bath"
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
                    "data": "exhasting_temp"
                },
                {
                    "data": "capping_temp"
                },
                {
                    "data": "sterlization_temp"
                },
                {
                    "data": "steam_on_time"
                },
                {
                    "data": "steam_off_time"
                },
                {
                    "data": "number_of_rejection"
                },
                {
                    "data": "remark"
                },
                {
                    "data": "name"
                }
                
    		],
    		dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
    			"<'row'<'col-sm-12'tr>>" +
    			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
    		responsive: true,
    		lengthMenu: [
    			[10, 25, 50, -1],
    			[10, 25, 50, 'All'],
    		],
            buttons: [
                {
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    filename: 'Water Bath Inseption Report' + today,
                    text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                    footer: true,
                    title: 'Mico Ceylon Organics Pvt ltd',
                    messageTop: 'Water Bath Inseption Report'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    filename: 'Water Bath Inseption Report' + today,
                    text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                    footer: true,
                    title: 'Mico Ceylon Organics Pvt ltd',
                    messageTop: 'water Bath Inseption Report'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    filename: 'Water Bath Inseption Report' + today,
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    footer: true,
                    title: 'Mico Ceylon Organics Pvt ltd',
                    messageTop: {
                        text: 'water Bath Inseption Report',
                        fontSize: 20,
                        bold: true,
                        alignment: 'center'
                    },
                    customize: function (doc) {

                        doc.pageSize = 'A4'; 
                        doc.pageOrientation = 'landscape';

                        doc.styles.title = {
                            bold: true,
                            color: '#2F5233',
                            fontSize: 18,
                            alignment: 'center',
                        };

                        var tableNode;
                        for (var i = 0; i < doc.content.length; i++) {
                            if (doc.content[i].table) {
                                tableNode = doc.content[i];
                                break;
                            }
                        }

                        if (tableNode) {

                            tableNode.table.body.forEach(function(row) {
                                row.splice(0, 1);
                            });

                            tableNode.table.widths = ['*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*'];
                        }
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-primary btn-sm',
                    filename: 'Drier Temperature Report' + today,
                    text: '<i class="fas fa-print mr-2"></i> PRINT',
                    footer: true,
                    title: 'Mico Organics Pvt ltd',
                    messageTop: 'Drier Daily Temperature Report',
                    customize: function (doc) {
                        doc.styles.title = {
                            color: 'black',
                            fontSize: '30',
                            alignment: 'center',
                        }
                    }
                }
            ],
    		drawCallback: function (settings) {
    			$('[data-toggle="tooltip"]').tooltip();
    		}
    	});

        $('#btn_filter').click(function () {
            $('#waterBathTable').DataTable().ajax.reload();
        });

    });


    function addCommas(nStr){
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
</script>

<?php include "include/footer.php"; ?>