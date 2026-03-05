<?php
class Semiproductionqualityreportinfo extends CI_Model{
    public function Semiproductionqualitycheckreport($x, $y){

        $recordID=$x;
        $materialid=$y;

		$html = '';
		
		$sql = "SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) As descstatus,`tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_quality_info`.`status`=?";
		
		$respond = $this->db->query($sql, array($recordID, 1));
		$qualities = $respond->result();
		
		$qualitySets = array_chunk($qualities, 2); // Change array_chunk size to 4

		$qualityhtml = '';
		foreach ($qualitySets as $setIndex => $set) {
			$qualityhtml .= '<br><div style="display: flex; margin-right:1200px">';
			
			foreach ($set as $index => $rowlist) {
				$qualityhtml .= '
				<table>
					<tr>
						<td>
							<label style="font-size: 10px;">' . $rowlist->qualitysubcategory . ' :</label>
						</td>
						<td>
							<input type="text" name="grn' . $index . '" id="grn' . $index . '" value="' . $rowlist->descstatus . '" readonly>
						</td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				
				if (($index + 1) % 2 == 0) {
					$qualityhtml .= '</tr></table></div>';
					if ($index < count($set) - 1) {
						$qualityhtml .= '<br><div style="display: flex; margin-right:1200px">';
					}
				}
			}
		}
		
		// Add a closing div tag if necessary
		if ($qualityhtml != '') {
			$qualityhtml .= '</div>';
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

    	<table style="border: 2px solid;">
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
    	<table style="border: 1px solid">
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
        	<table style="border: 1px solid">
        		<tr>
        			<td style=" background-color:#A2A2A0; color:#000;">
        				<h2 style="font-size:15px; margin-left:260px; margin-right:300px">SEMI PRODUCTION</h2>
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