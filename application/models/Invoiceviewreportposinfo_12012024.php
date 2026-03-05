<?php
class Invoiceviewreportposinfo extends CI_Model{
    public function printreportpos($x){

        $recordID=$x;
        $cashier=$_SESSION['name'];
    
        $sqlinvoiceinfo="SELECT `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`invdate`, `tbl_invoice`.`grosstotal`, `tbl_invoice`.`discount`, `tbl_invoice`.`nettotal`, `tbl_invoice`.`paycomplete`, `tbl_customer`.`name`, `tbl_customer`.`address` FROM `tbl_invoice` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`  LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_invoice`.`status`=1 AND `tbl_invoice`.`idtbl_invoice`=?";
        $invoiceinforespond=$this->db->query($sqlinvoiceinfo, array($recordID));
        $invdate=$invoiceinforespond->row(0)->invdate;
        $invid=$invoiceinforespond->row(0)->idtbl_invoice;
        $name=$invoiceinforespond->row(0)->name;
        $address=$invoiceinforespond->row(0)->address;
        $grosstotal=$invoiceinforespond->row(0)->grosstotal;
        $discount=$invoiceinforespond->row(0)->discount;
        $nettotal=$invoiceinforespond->row(0)->nettotal;
    
        $tblinvoice='';
    
        $sqlproduct="SELECT `tbl_product`.`productcode`, `tbl_product`.`barcode`, `tbl_product`.`desc`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=1";
        $productrespond=$this->db->query($sqlproduct, array($recordID));
    
        $qty=$productrespond->row(0)->qty;
        $saleprice=$productrespond->row(0)->saleprice;
    
        $sqlproductcount="SELECT COUNT(`tbl_product`.`productcode`) AS itemcount, `tbl_product`.`barcode`, `tbl_product`.`desc`, SUM(`tbl_invoice_detail`.`qty`) AS sumqty, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=1";
        $productcountrespond=$this->db->query($sqlproductcount, array($recordID));
    
        $itemcount=$productcountrespond->row(0)->itemcount;
        $sumqty=$productcountrespond->row(0)->sumqty;
    
        $sqlpayment="SELECT SUM(`nettotal`) AS `sumpayment` FROM `tbl_invoice_payment` LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` ON `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_payment_idtbl_invoice_payment`=`tbl_invoice_payment`.`idtbl_invoice_payment` WHERE `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_idtbl_invoice`=?";
        $paymentrespond=$this->db->query($sqlpayment, array($recordID));
    
        if(empty($paymentrespond)){$totalpay=0;}
        else{$totalpay=$paymentrespond->row(0)->sumpayment;}
    
    
        foreach($productrespond->result() as $rowlist){
            $tblinvoice.='
            <tr>
            <td style="font-size:7px; border-bottom:1px dotted black; text-align:left;">'.$rowlist->productcode.' <br> '.$rowlist->barcode.' <br> '.$rowlist->desc.'</td>
            <td style="font-size:7px; border-bottom:1px dotted black; text-align:right;">'.$rowlist->qty.'</td>
            <td style="font-size:7px; border-bottom:1px dotted black; text-align:right;">'.number_format(($rowlist->saleprice), 2).'</td>
            <td style="font-size:7px; border-bottom:1px dotted black; text-align:right;" class="totalrawcost">'.number_format(($rowlist->qty * $rowlist->saleprice), 2).'</td>             
        </tr>
            
            ';
        }
    
        $sqlinvoicedetail="SELECT `tbl_product`.`productcode`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`='$recordID' AND `tbl_invoice_detail`.`status`=1";
        $respond2=$this->db->query($sqlinvoicedetail, array());
    
    $html='';
    
    $html ='
    
    <!doctype html>
    <html lang="en">

    <head>
    	<!-- Required meta tags -->
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<!-- <link href="https://fonts.googleapis.com/css2?family=Cutive+Mono&display=swap" rel="stylesheet"> -->
    	<link href="https://fonts.googleapis.com/css2?family=Fira+Mono&display=swap" rel="stylesheet">
    	<link rel="stylesheet"
    		href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    	<title>Invoice</title>
    	<style media="print">
    		* {
    			font-family: "Fira Mono", monospace;
    		}

    		table,
    		tr,
    		th,
    		td {
    			font-family: "Fira Mono", monospace;
    		}

    		img {
    			width: 200px;
    			height: 100px;
    		}

    		@page {
    			size: 80mm 100mm;
    			/* Set the print size width to 80mm and height to 100mm */
    		}

    		body {
    			width: 80mm;
    			/* Set the body width to 80mm */
    		}

    		#DivIdToPrint {
    			border: 1px solid black;
    			padding: 10px;
    			width: 100%;
    			/* Set the div width to 100% */
    		}
    	</style>
    	<style>
    		* {
    			font-family: "Fira Mono", monospace;
    		}

    		table,
    		tr,
    		th,
    		td {
    			font-family: "Fira Mono", monospace;
    		}

    		img {
    			width: 100px;
    			height: 100px;
    		}

    		#DivIdToPrint {
    			width: 100%;
    			/* Set the div width to 100% */
    		}
    	</style>
    	<style>
    		* {
    			font-family: "Cutive Mono", monospace;
    		}

    		table,
    		tr,
    		th,
    		td {
    			font-family: "Cutive Mono", monospace;
    		}

    		img {
    			width: 100px;
    			height: 100px;
    		}
    	</style>
    </head>

    <body>
    	<div id="DivIdToPrint">
    		<table style="width:100%;">
    			<tr>
    				<td style="padding-left: 35%; font-size:6px;" colspan="2">
    					<h6 class="font-weight-light" style="margin-top:0;margin-bottom:0;">
    						<span style="font-size:10px;vertical-align: top;">
    							<img src="'.base_url().'images/CH-removebg-preview.png" alt=""
    								style="width:50%; height:40px;"><br>
    							<br>
    						</span>
    					</h6>
    					<h6 style=" padding-right:20%;">No-63, Jaya Mawatha, Ratmalana, 011-2635185</h6>
    					<h3 class="font-weight-light" style="margin-top:0;margin-bottom:0; padding-left:20%;">INVOICE
    					</h3>
    				</td>
    			</tr>
    			<tr>
    				<td style="text-align: left; font-size:7px;">Date: '.$invdate.'</td>
    				<td style="padding-left:130px; font-size:7px;">Invoice No: INV/OT-000'.$invid.'</td>
    			</tr>
    			<tr>
    				<td style="text-align: left; font-size:7px;">Cashier: '.$cashier.'</td>
    			</tr>
    			<tr>
    				<td style="text-align: center; margin-bottom:50px" colspan="2">
    					<table class="tg" style="table-layout: fixed; width: 100%">
    						<tr style="text-align:right; font-weight:bold; font-size:5px;">
    							<td style="text-align: center; font-size:10px;border-bottom:1px dotted black;">Name</td>
    							<td style="text-align: right; font-size:10px;border-bottom:1px dotted black;">Qty</td>
    							<td style="text-align: right; font-size:10px;border-bottom:1px dotted black;">Price</td>
    							<td style="text-align: right; font-size:10px;border-bottom:1px dotted black;">Total</td>
    						</tr>
    						<tbody>
    							'.$tblinvoice.'
    						</tbody>
    					</table>
    				</td>
    			</tr>
    			<tr>
    				<td>&nbsp;</td>
    				<td>
    					<table style="width:100%;">
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">Total</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:</td>
    							<td style="text-align: right; font-size:6px;font-weight: bold;">
    								'.number_format(($grosstotal), 2).'</td>
    						</tr>
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">Total Discount</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:</td>
    							<td style="text-align: right; font-size:6px;font-weight: bold;">
    								'.number_format(($discount), 2).'</td>
    						</tr>
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">Net Total</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:</td>
    							<td
    								style="text-align: right; font-size:6px;font-weight: bold; border-bottom:1px double black; border-top:1px solid black;">
    								'.number_format(($nettotal), 2).'</td>
    						</tr>
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">
    								Payment
    								Method</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:
    							</td>
    							<td style="text-align: right; font-size:6px;font-weight: bold;">
    								Cash</td>
    						</tr>
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">No. of Items</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:</td>
    							<td style="text-align: right; font-size:6px;font-weight: bold;">
    								'.$itemcount.'</td>
    						</tr>
    						<tr>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">No. of Quantity</td>
    							<td style="text-align: left; font-size:6px;font-weight: bold;">:</td>
    							<td style="text-align: right; font-size:6px;font-weight: bold;">
    								'.$sumqty.'</td>
    						</tr>
    				</td>
    			</tr>
    			<tr>
    				<td style=font-size: 12px; padding-top: 5px; padding-right: 10px" colspan="2">

    				</td>
    			</tr>
    			<tr style="margin-top:5px;">
    				<td style="text-align: center; font-size:7px; padding-top: 10px; padding-right: 30px" colspan="2">
    					<span style="font-size: 7px; font-weight: bold;">Thank You! Come
    						again!</span><br>
    					<span style="font-size:7px;">Important Notice : In case of
    						returns, return the
    						bill within 7 days.</span><br></td>
    			</tr>
    			<tr>
    			<tr>
    				<td style="text-align: center; font-size:7px; padding-top: 5px; padding-right: 30px" colspan="2">
    					<span style="font-size:7px;">CEYLON’Z HARVEST by UNISTAR INTENATIONAL PVT LTD
    						53, 3rd LANE, RATMALANA, 011-2635185 </span><br><i style="font-size:7px;"
    						class="lab la-facebook"></i>
    					Unistar International (PVT) Ltd / Copyright © ERav Technology</td>
    			</tr>
    		</table>
    	</div>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    	<script>
    		window.print();
    		setTimeout(() => {
    			window.close();
    		}, 5000);
    	</script>
    </body>

    </html>';
    
    echo $html;
    }
}