<?php
class Productionpackingqualityreportinfo extends CI_Model{
    public function Productionpackingqualityreport($x){

        $recordID=$x;

		$html = '';
		
        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) As descstatus,`tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_production_order_idtbl_production_order`=? AND `tbl_quality_info`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));
		$qualities = $respond->result();
		
		$qualityhtml = '';
		$qualityhtml .= '<table style="width:100%">';
        $i=0;
        $j=0;
        foreach($qualities as $rowlist){
            if($j==26){
                $qualityhtml.='<tr><td style="border: thin solid #000;">'.$rowlist->qualitysubcategory.'</td><td style="border: thin solid #000;" colspan="3">'.$rowlist->descstatus.'</td><td style="border: thin solid #000;">PASS</td></tr>';
            }
            else if($j==27){
                $qualityhtml.='<tr><td style="border: thin solid #000;">'.$rowlist->qualitysubcategory.'</td><td style="border: thin solid #000;" colspan="3">'.$rowlist->descstatus.'</td><td style="border: thin solid #000;">FAIL</td></tr>';
            }
            else{
                if($i==0){
                    $qualityhtml.='<tr><td style="border: thin solid #000;">'.$rowlist->qualitysubcategory.'</td><td style="border: thin solid #000;">'.$rowlist->descstatus.'</td>';
                    $i++;
                }
                else if($i==1){
                    $qualityhtml.='<td style="border: thin solid #000;">'.$rowlist->qualitysubcategory.'</td><td style="border: thin solid #000;">'.$rowlist->descstatus.'</td><tr>';
                    $i++;
                }
                else if($i==2){
                    $qualityhtml.='<tr><td style="border: thin solid #000;">'.$rowlist->qualitysubcategory.'</td><td style="border: thin solid #000;" colspan="3">'.$rowlist->descstatus.'</td></tr>';
                    $i=0;
                }
            }
            $j++;
        }
        $qualityhtml .= '</table>';
		


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

    	<table style="width:100%; border: 2px solid;">
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
    	<table style="width:100%; border: 1px solid">
    		<tr>
    			<td  style=" background-color:#000; color:#fff; width=50%">
    				<h2 style="font-size:15px; margin-left:50px; margin-right:105px">QUALITY EXAMINE WORK SHEET</h2>
    			</td>
				<td  style=" background-color:#fff; color:#000;  width=50%">
				<h2 style="font-size:15px; padding-right:50px">| RM | PM | LM | PD | FG | DIRECT |
				</h2>
			</td>
    		</tr>
    	</table>
    	<div class="container">

		';

		$html.='

        <br>
        <div class="form-row">
        	<table style="width:100%; border: 1px solid">
        		<tr>
        			<td style=" background-color:#A2A2A0; color:#000;">
        				<h2 style="font-size:15px; margin-left:260px; margin-right:300px">PACKING & FG</h2>
        			</td>
        		</tr>
        	</table>
        </div>

    		<div class="row">
    			'.$qualityhtml.'
    		</div>

    	</div>

    </body>

    </html>
';

// echo $html;
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));

    }
}