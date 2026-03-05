<?php
class Customerporderreportinfo extends CI_Model{
    public function printreport($x){

        $recordID = $x;

        $htmlcusdetail = '';
        
        $sql = "SELECT tbl_customer_porder_detail.*, tbl_customer_porder.*, tbl_product.productcode, tbl_material_code.materialname
                FROM tbl_customer_porder_detail
                LEFT JOIN tbl_customer_porder ON tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder
                LEFT JOIN tbl_product ON tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product
                LEFT JOIN tbl_material_code ON tbl_material_code.idtbl_material_code = tbl_product.materialid
                WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder = ?
                AND tbl_customer_porder_detail.status = ?";
        $respond = $this->db->query($sql, array($recordID, 1));

        $sql2 = "SELECT `prostartdate`,`proenddate` FROM `tbl_production_order` WHERE `tbl_customer_porder_idtbl_customer_porder`=?";
        $respond2 = $this->db->query($sql2, array($recordID));
        
        if ($respond2->num_rows() > 0) {
            $prostartdate = $respond2->row(0)->prostartdate;
            $proenddate = $respond2->row(0)->proenddate;
        } else {
            // Handle the case when no rows are returned
            // You can assign default values or display an error message
            $prostartdate = "N/A";
            $proenddate = "N/A";
        }
        
        $sqlcus = "SELECT `u`.*, `ua`.`name`, `ua`.`contact`, `ua`.`customercode`,`ua`.`contact2`, `ua`.`address`, `ua`.`email` FROM `tbl_customer_porder` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status`=? AND `u`.`idtbl_customer_porder`=?";
        $respondcus = $this->db->query($sqlcus, array(1, $recordID));
        
        $htmlcusdetail .= '
        <div class="col-7" style="font-size:12px; margin-top:5px;">
            <label style="font-weight:bold;">Sales Order: &nbsp;</label>
            <label>UN/SOD-0000' . ($respond ? $respond->row(0)->idtbl_customer_porder : '') . '</label><br><br>
            <label style="font-weight:bold;">Customer Name: &nbsp;</label>' . ($respondcus ? $respondcus->row(0)->name : '') . '<br>
            <label style="font-weight:bold;">Customer Code: &nbsp;</label>' . ($respondcus ? $respondcus->row(0)->customercode : '') . '<br><br>
            <label style="font-weight:bold;">Due Date: &nbsp;</label>' . ($respond ? $respond->row(0)->duedate : '') . '<br><br>
            <label style="font-weight:bold;">Production Start Date: &nbsp;</label>'.$prostartdate.'<br>
            <label style="font-weight:bold;">Production End Date: &nbsp;</label>'.$proenddate.'<br><br><br>
        </div>';

        $tblporder='';

        $sqltable = "SELECT tbl_customer_porder_detail.*, tbl_customer_porder.*, tbl_product.productcode, tbl_product.weight, tbl_material_code.materialname
        FROM tbl_customer_porder_detail
        LEFT JOIN tbl_customer_porder ON tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder
        LEFT JOIN tbl_product ON tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product
        LEFT JOIN tbl_material_code ON tbl_material_code.idtbl_material_code = tbl_product.materialid
        WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder = ?
        AND tbl_customer_porder_detail.status = ?";
        $respondtable = $this->db->query($sqltable, array($recordID, 1));

        foreach($respondtable->result() as $rowlist){
            $tblporder.='
            <tr style="text-align:right; border: 1px solid black;">
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="text-left">
                '.$rowlist->idtbl_customer_porder_detail.'
            </td>
            <td style="font-size:10px; text-align:left; border: 1px solid black;" class="text-left">
                '.$rowlist->productcode.'
            </td>
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                '.$rowlist->weight.'
            </td>
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                '.$rowlist->qty.'
            </td>
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                '.$rowlist->qty.'
            </td>
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                '.$rowlist->qty.'
            </td>
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
    		.tg td {
    			font-family: Arial, sans-serif;
    			font-size: 14px;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg th {
    			font-family: Arial, sans-serif;
    			font-size: 14px;
    			font-weight: normal;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg .tg-btmp {
    			color: #000;
    			text-align: left;
    			vertical-align: top
    		}

    		.tg .tg-0lax {
    			text-align: left;
    			vertical-align: top
    		}
    	</style>
    </head>

    <body>

    	<table>
    		<tr>
    			<td><img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px;">
    			</td>
    			<td>
    				<address style="font-size:9px; font-weight:bold; margin-left:245px;">
    					<h3><u>HEAD OFFICE</u></h3>
    					UNISTAR INTERNATIONAL PVT LTD<br>
    					53, 3rd LANE, RATMALANA<br>
    					0112635185, 0779662165<br>
    					0112635185, 0779662165<br>
    				</address>
    			</td>
    			<td>
    				<address style="font-size:9px; font-weight:bold; margin-left:20px;">
    					<h3><u>SHOWROOM</u></h3>
    					CEYLON`Z HARVEST<br>
    					63, JAYA MAWATHA,<br>
    					RATMALANA<br>
    					0112635185, 0779662165<br>
    				</address>
    			</td>
    		</tr>
    	</table>
    	<table>
    		<tr>
    			<td>
    				<h2 style="font-size:15px; margin-left:290px; margin-right:290px;">SALES ORDER</h2>
    			</td>
    		</tr>
    	</table>
    	<div class="container">

		<div class="row">
		'.$htmlcusdetail.'
        </div>
    		<div class="row">
    			<div class="col-12" style="padding:0;">
                <table class="tg" style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                <tr style="text-align: center; font-weight: bold; font-size: 25px;">
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">#</th>
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">Item Code</th>
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">Unit Weight</th>
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">Quantity</th>
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">Excess Onhand Quantity</th>
                    <th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">Quantity to be produced</th>
                </tr>
                <tbody>
                    '.$tblporder.'
                </tbody>
            </table>

    			</div>
    		</div>

    	</div>

    </body>

    </html>
';

// echo $html;
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL COSTLIST SHEET.pdf", array("Attachment"=>0));

    }

}