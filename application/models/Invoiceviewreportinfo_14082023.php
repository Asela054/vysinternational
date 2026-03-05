<?php
class Invoiceviewreportinfo extends CI_Model{
    public function printreport($x){

        $recordID=$x;


        $tblinvoice='';

        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_product`.`weight`,`tbl_customer_porder_detail`.`unitprice`
        FROM `tbl_invoice_detail`
        LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice`.`idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=? GROUP BY `tbl_invoice_detail`.`idtbl_invoice_detail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $sqlcus = "SELECT `u`.`idtbl_invoice`, `u`.`invdate`, `ud`.`name`, `ud`.`address` AS cusaddress, `ud`.`contact`, `ud`.`email`
        FROM `tbl_invoice` AS `u`
        LEFT JOIN `tbl_invoice_detail` AS `ua`
            ON `ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice`
        LEFT JOIN `tbl_product` AS `ub`
            ON `ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product`
        LEFT JOIN `tbl_customer_porder` AS `uc`
            ON `uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_customer` AS `ud`
            ON `ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer`
        LEFT JOIN `tbl_location` AS `ue`
            ON `ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location`
            WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
    $respondsus = $this->db->query($sqlcus, array($recordID));

    $sqltotal="SELECT SUM(`total`) AS total, SUM(`qty`) AS qty FROM `tbl_invoice_detail` WHERE `tbl_invoice_idtbl_invoice`=?";
    $respondtotal = $this->db->query($sqltotal, array($recordID));
    
    $row2 = $respondtotal->row();
    $total = number_format($row2->total, 2);
    $qty = $row2->qty;
    
    if ($respondsus->num_rows() > 0) {
        $row = $respondsus->row();
        $cusname = $row->name;
        $cusaddress = $row->cusaddress;
        $contact = $row->contact;
        $email = $row->email;
        $invdate = $row->invdate;
        $invid = $row->idtbl_invoice;
    }
    $i=1;
        foreach($respond->result() as $rowlist){
            $tblinvoice.='
            <tr>
                    <td>'.$i++.'</td>
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
    
            .logo {
                display: inline-block;
                float: left;
                margin-top: 10px;
            }
    
            .logo img {
                width: 160px;
                height: 110px;
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
                margin-left: 380px;
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
                margin-left: 350px;
            }
    
            .address2 h3 {
                margin: 0;
                padding: 0;
                text-decoration: underline;
                font-size: 14px;
            }
    
            h1 {
                margin-top: 30px;
                font-size: 18px;
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
        <div class="container">
            <div class="logo">
                <img src="images/Ch.jpg" alt="">
            </div>
            <div class="address">
                <h3>HEAD OFFICE</h3>
                <b>Unistar International Pvt Ltd</b><br>
                <b>No -</b> 53, 3rd Lane, Ratmalana, Sri Lanka <br>
                <b>TEL -</b> +94 112635 185<br>
                <b>MOBILE -</b> +94 77 966 2165 / +94 77 888 1631<br>
                <b>Email -</b> admin@unistar-international.com<br>
                <br>
                <br>
                <h3 style="margin-bottom:5px;">SHOWROOM</h3>
                <b>CEYLONZ HARVEST</b><br>
                <b>No -</b> 63, Jaya Mawatha, Ratmalana <br>
                <b>TEL -</b> 077 966 2165 / +94 77 888 1631<br>
			<b>Web -</b> www.admin@unistar-international.com
		</div>
		<h1><b>INVOICE</b></h1>
		<div class="">
			<b>Date -</b> '.$invdate.' <br>
			<b>Invoice No. -</b>  INV/DT-000'.$invid.'<br>
		</div>
		<table class="invoice-table">
			<thead>
				<tr>
					<th style="text-align: center;" scope="col">ITEM NO</th>
                    <th style="text-align: center;" scope="col">Item</th>
                    <th style="text-align: center;" scope="col">Pack Weight</th>
                    <th style="text-align: center;" scope="col">Unit Price(LKR)</th>
					<th style="text-align: center;" scope="col">Order Quantity</th>
					<th style="text-align: center;" scope="col">Amount(LKR)</th>
				</tr>
			</thead>
			<tbody>
				'.$tblinvoice.'
			</tbody>
			<tfoot>
				<tr>
					<th colspan="1"></th>
					<th style="text-align: left;">TOTAL:</th>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;"><label>'.$qty.'</label></th>
                    <th style="text-align: right;"><label>'.$total.'</label></th>
                    				</tr>
			</tfoot>
		</table>
		<div class="">
			<h3 style="margin-bottom:5px; margin-top:20px;"><u>CUSTOMER DETIALS</u></h3>
			<b>CONGSIGNEE -</b> '.$cusname.'<br>
			<b>Address -</b> '.$cusaddress.'<br>
			<b>Contact No. -</b> '.$contact.'<br>
			<b>Email -</b> '.$email.'<br>
		</div>
        <div class="" style="margin-bottom:5px; margin-top:50px;">
        <b>PAYMENT TERMS -</b> <br>
        <b>DELIVERY -</b> <br>
    </div>
    <div class="">
    <h3 style="margin-bottom:5px; margin-top:50px;"><u>BANK DETAILS FOR PAYMENT</u></h3>
    <b>Name -</b> Unistar International Pvt. Ltd<br>
    <b>Account No. -</b> 100270005115<br>
    <b>Bank Name -</b> Nations Trust PLC, Wellawaththa<br>
    <b>Swift Code -</b> NTBCLKLX<br>
    <b>Branch Code -</b> 027<br>
    <b>Bank Code -</b> 7162<br>
    <div class="logo2">
    <img src="images/unistarimg.jpeg" class="img-fluid" alt="">
</div>
	</div>
</body>
</html>
';

// echo $html;

    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));

    }

}