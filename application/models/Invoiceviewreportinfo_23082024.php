<?php
class Invoiceviewreportinfo extends CI_Model{
    public function printreport($x){

		function numberToWords($number) {
			$dictionary = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'forty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion'
			);
		
			if (!is_numeric($number)) {
				return false;
			}
		
			if ($number < 0) {
				return 'negative ' . numberToWords(abs($number));
			}
		
			$string = '';
			$number = number_format($number, 2, '.', '');
			$parts = explode('.', $number);
			$integerPart = intval($parts[0]);
			$decimalPart = isset($parts[1]) ? intval($parts[1]) : 0;
		
			if ($integerPart > 0) {
				$string .= convertNumberToWords($integerPart, $dictionary);
			} else {
				$string .= 'zero';
			}
		
			if ($decimalPart > 0) {
				$string .= ' point ' . convertNumberToWords($decimalPart, $dictionary);
			}
		
			return $string;
		}
		
		function convertNumberToWords($number, $dictionary) {
			$string = '';
		
			if ($number < 20) {
				$string .= $dictionary[$number];
			} elseif ($number < 100) {
				$string .= $dictionary[intval($number / 10) * 10];
				$string .= $number % 10 ? '-' . $dictionary[$number % 10] : '';
			} elseif ($number < 1000) {
				$string .= $dictionary[intval($number / 100)] . ' hundred';
				$string .= $number % 100 ? ' and ' . convertNumberToWords($number % 100, $dictionary) : '';
			} elseif ($number < 1000000) {
				$string .= convertNumberToWords(intval($number / 1000), $dictionary) . ' thousand';
				$string .= $number % 1000 ? ' ' . convertNumberToWords($number % 1000, $dictionary) : '';
			} elseif ($number < 1000000000) {
				$string .= convertNumberToWords(intval($number / 1000000), $dictionary) . ' million';
				$string .= $number % 1000000 ? ' ' . convertNumberToWords($number % 1000000, $dictionary) : '';
			} else {
				$string .= convertNumberToWords(intval($number / 1000000000), $dictionary) . ' billion';
				$string .= $number % 1000000000 ? ' ' . convertNumberToWords($number % 1000000000, $dictionary) : '';
			}
		
			return $string;
		}
		
		

        $recordID=$x;


        $tblinvoice='';

        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_product`.`weight`,`tbl_customer_porder_detail`.`unitprice`
        FROM `tbl_invoice_detail`
        LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice`.`idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=? GROUP BY `tbl_invoice_detail`.`idtbl_invoice_detail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $sqlcus = "SELECT `u`.`idtbl_invoice`, `u`.`invdate`, `ud`.`name`, `ud`.`customercode` AS customercode, `ud`.`address` AS cusaddress, `ud`.`contact`, `ud`.`email` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_detail` AS `ua` ON `ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice` LEFT JOIN `tbl_product` AS `ub` ON `ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product` LEFT JOIN `tbl_customer_porder` AS `uc` ON `uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` AS `ud` ON `ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer` LEFT JOIN `tbl_location` AS `ue` ON `ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
    	$respondsus = $this->db->query($sqlcus, array($recordID));

        $sqlbank = "SELECT `ua`.`account_name`, `ua`.`account_no`, `ua`.`bank_name`, `ua`.`bank_branch`, `ua`.`swift_code`, `ua`.`branch_code`, `ua`.`bank_code` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_bank` AS `ua` ON `ua`.`idtbl_invoice_bank` = `u`.`tbl_invoice_bank_idtbl_invoice_bank` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
    	$respondbank = $this->db->query($sqlbank, array($recordID));

		$sqltotal="SELECT SUM(`total`) AS total, SUM(`qty`) AS qty FROM `tbl_invoice_detail` WHERE `tbl_invoice_idtbl_invoice`=?";
		$respondtotal = $this->db->query($sqltotal, array($recordID));
		
		$row2 = $respondtotal->row();
		$qty = $row2->qty;

		$total = floatval(number_format($row2->total, 2, '.', ''));
		$amountInWords = numberToWords($total);
    
    if ($respondsus->num_rows() > 0) {
        $row = $respondsus->row();
        $cusname = $row->name;
        $cusaddress = $row->cusaddress;
		$customercode = $row->customercode;
        $contact = $row->contact;
        $email = $row->email;
        $invdate = $row->invdate;
        $invid = $row->idtbl_invoice;
    }
	if ($respondbank->num_rows() > 0) {
        $row = $respondbank->row();
        $accname = $row->account_name;
        $accnum = $row->account_no;
        $bank = $row->bank_name;
        $branch = $row->bank_branch;
        $swiftcode = $row->swift_code;
        $branchcode = $row->branch_code;
		$bankcode = $row->bank_code;
    }
    $i=1;
        foreach($respond->result() as $rowlist){
            $tblinvoice.='
            <tr>
                    <td style="text-align: center;">'.$i++.'</td>
                    <td>'.$rowlist->desc.'</td>
                    <td style="text-align: center;">'.$rowlist->weight.'</td>
                    <td style="text-align: center;">'.number_format($rowlist->saleprice, 2).'</td>
                    <td style="text-align: center;">'.$rowlist->qty.'</td>
                    <td style="text-align: right;">'.number_format($rowlist->total, 2).'</td>
                </tr>
            
            ';
        } 

    $html = '
    <!DOCTYPE html>
    <html>

    <head>
    	<title>Unistar - By Erav Technology</title>
    	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    	<style>
    		body {
    			margin: 0;
    			padding: 0;
    			font-family: Arial, sans-serif;
    			font-size: 12px;
    			box-sizing: border-box;
    		}

    		.container {
    			max-width: 794px;
    			margin: 20px auto;
    			padding: 0 30px;
    		}

			.content {
    			margin-top: 140px;
    		}

    		.header,
    		.footer {
    			margin: 0px;
    			padding: 10px;
    		}

    		.logo {
    			display: inline-block;
    			float: left;
    			margin-top: 5px;
				margin-right: 170px;
    		}

    		.logo img {
    			width: 150px;
    			height: 100px;
    		}

    		.logo2 {
    			display: inline-block;
    			float: right;
    			margin-top: 20px;
    		}

    		.logo2 img {
    			width: 170px;
    			height: 100px;
    		}

    		.address {
    			display: inline-block;
    			margin-top: 10px;
    			margin-left: 150px;
    		}

    		.address h3 {
    			margin: 0;
    			padding: 0;
    			text-decoration: underline;
    			font-size: 14px;
    		}

    		.address2 {
    			display: inline-block;
    			margin-top: 10px;
    			margin-left: 5px;
    		}

    		.address2 h3 {
    			margin: 0;
    			padding: 0;
    			text-decoration: underline;
    			font-size: 14px;
    		}

    		h1 {
    			font-size: 28px;
    			text-align: center;
    		}

    		.invoice-table {
    			margin-top: 10px;
    			table-layout: fixed;
    			width: 100%;
    			border-collapse: collapse;
    		}

    		.invoice-table th,
    		.invoice-table td {
    			padding: 3px;
    			border: 1px solid #000;
    			text-align: left;
    			font-size: 12px;
    		}

    		.invoice-table th {
    			background-color: #70ad47;
    			color: #fff;
    			font-weight: bold;
    			font-size: 12px;
    		}

    		.invoice-table tbody {
    			background-color: #c5e0b3;
    		}

    		.invoice-table tfoot th {
    			text-align: right;
    			font-weight: bold;
    			font-size: 12px;
    		}

    		.customer-details {
    			margin-top: 30px;
    			font-size: 12px;
    		}

    		.payment-terms {
    			margin-top: 20px;
    			font-size: 12px;
    			text-align: right;
    		}
    	</style>
    </head>

    <body>
    	<div class="header">
    		<div class="container">
    			<div class="logo">
    				<img src="images/Ch.jpg" alt="Logo">
    			</div>
    			&nbsp; &nbsp;
    			<div class="address">
    				<h3>HEAD OFFICE</h3>
    				<b>Unistar International Pvt Ltd</b><br>
    				<table>
    					<tr>
    						<th>No.</th>
    						<td>-</td>
    						<td>53, 3rd Lane, Ratmalana, Sri Lanka</td>
    					</tr>
    					<tr>
    						<th>TEL.</th>
    						<td>-</td>
    						<td>+94 112635 185</td>
    					</tr>
    					<tr>
    						<th>MOBILE</th>
    						<td>-</td>
    						<td>+94 77 966 2165 / +94 77 888 1631</td>
    					</tr>
    					<tr>
    						<th>Email</th>
    						<td>-</td>
    						<td>admin@unistar-international.com</td>
    					</tr>
    				</table>
    			</div>
    			<div class="address2">
    				<h3 style="margin-bottom:5px;">SHOWROOM</h3>
    				<b>CEYLONZ HARVEST</b>
    				<table>
    					<tr>
    						<th>No.</th>
    						<td>-</td>
    						<td>63, Jaya Mawatha, Ratmalana</td>
    					</tr>
    					<tr>
    						<th>TEL.</th>
    						<td>-</td>
    						<td>077 966 2165 / +94 77 888 1631</td>
    					</tr>
    					<tr>
    						<th>Web</th>
    						<td>-</td>
    						<td>www.admin@unistar-international.com</td>
    					</tr>
    				</table>
    			</div>
    		</div>
    	</div>
    	<hr>

    	<div class="content">
    		<hr>
    		<h1 style="margin: 0; padding: 10px 0;">INVOICE</h1>

    		<table style="width: 100%; border-collapse: collapse;">
    			<tr>
    				<td style="width: 50%; vertical-align: top; padding: 5px;">
    					<table style="width: 100%;">
    						<tr>
    							<th style="text-align: left;">Invoice Date</th>
    							<td style="text-align: left;">:</td>
    							<td>'.$invdate.'</td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Invoice No.</th>
    							<td style="text-align: left;">:</td>
    							<td>INV/DT-000'.$invid.'</td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Vendor Code</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Purchase Order</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Dispatch Note</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Payment Terms</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Delivery</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    					</table>
    				</td>
    				<td style="width: 50%; vertical-align: top; padding: 5px;">
    					<table style="width: 100%;">
    						<tr>
    							<th style="text-align: left;">Customer</th>
    							<td style="text-align: left;">:</td>
    							<td>'.$cusname.'</td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Customer Code</th>
    							<td style="text-align: left;">:</td>
    							<td>'.$customercode.'</td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Address</th>
    							<td style="text-align: left;">:</td>
    							<td>'.$cusaddress.'</td>
    						</tr>
    						<tr>
    							<th style="text-align: left;">Cus. Vat No</th>
    							<td style="text-align: left;">:</td>
    							<td></td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    		</table>
    		<table class="invoice-table">
    			<thead>
    				<tr>
    					<th style="text-align: center; width:8%" scope="col">#</th>
    					<th style="text-align: center; width:42%" scope="col">Item</th>
    					<th style="text-align: center; width:10%" scope="col">Pack Weight</th>
    					<th style="text-align: center; width:15%" scope="col">Unit Price(LKR)</th>
    					<th style="text-align: center; width:10%" scope="col">Order Quantity</th>
    					<th style="text-align: center; width:15%" scope="col">Amount(LKR)</th>
    				</tr>
    			</thead>
    			<tbody>
    				'.$tblinvoice.'
    			</tbody>
    			<tfoot>
    				<tr>
    					<th colspan="1"></th>
    					<th style="text-align: left; color: #000;">TOTAL:</th>
    					<th></th>
    					<th></th>
    					<th style="text-align: center; color: #000;"><label>'.$qty.'</label></th>
    					<th style="text-align: right; color: #000;"><label>'.number_format($total, 2).'</label></th>
    				</tr>
    			</tfoot>
    		</table>
    		<h3 style="margin-bottom:80px;">Amount in Words: <span>'.$amountInWords.' only</span></h3>
    		<table style="width:100%;">
    			<tr>
    				<th>Prepared By :</th>
    				<td>........................................</td>
    				<th>Approved By :</th>
    				<td>........................................</td>
    			</tr>
    		</table>

    	</div>

    	<br>
    	<br>
    	<br>
    	<hr>
    	<div class="footer">
    		<h3 style="margin-bottom:5px; margin-top:10px;"><u>BANK DETAILS FOR PAYMENT</u></h3>
    		<div style="display: flex; align-items: flex-start; justify-content: space-between;">
    			<div>
    				<table style="width: 100%; border-collapse: collapse;">
    					<tr>
    						<th style="text-align: left; font-size:10px;">Name</th>
    						<td style="text-align: left; font-size:10px;">'.$accname.'</td>
    					</tr>
    					<tr>
    						<th style="text-align: left; font-size:10px;">Account No.</th>
    						<td style="text-align: left; font-size:10px;">'.$accnum.'</td>
    					</tr>
    					<tr>
    						<th style="text-align: left; font-size:10px;">Bank Name</th>
    						<td style="text-align: left; font-size:10px;">'.$bank.'</td>
    						<th style="text-align: left; font-size:10px;">Branch Name</th>
    						<td style="text-align: left; font-size:10px;">'.$branch.'</td>
    					</tr>
    					<tr>
    						<th style="text-align: left; font-size:10px;">Swift Code</th>
    						<td style="text-align: left; font-size:10px;">'.$swiftcode.'</td>
    						<th style="text-align: left; font-size:10px;">Branch Cd.</th>
    						<td style="text-align: left; font-size:10px;">'.$branchcode.'</td>
    						<th style="text-align: left; font-size:10px;">Bank Cd.</th>
    						<td style="text-align: left; font-size:10px;">'.$bankcode.'</td>
    						<td><img src="images/unistarimg.jpeg" alt="Unistar Image"
    								style="width: 800%; max-width: 170px; margin-left:70px;"></td>
    					</tr>
    				</table>
    			</div>
    		</div>
    	</div>
    	<hr>
    </body>

    </html>
';

    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));

    }

}