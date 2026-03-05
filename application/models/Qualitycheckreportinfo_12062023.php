<?php
class Qualitycheckreportinfo extends CI_Model{
    public function Qualitycheckreport($x,$y){

        $recordID=$x;
        $materialid=$y;

        $html='';

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) As descstatus,`tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
         LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_quality_info`.`tbl_material_info_idtbl_material_info`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_grn_idtbl_grn`=? AND `tbl_quality_info`.`tbl_material_info_idtbl_material_info`=? AND `tbl_quality_info`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, $materialid, 1));

            $qualityhtml = '';
            foreach ($respond->result() as $rowlist) {
                $qualityhtml .= '
                <ul>
                    <li style="font-size:10px;">
                        <label for="">' . $rowlist->qualitysubcategory . ' : <span>&nbsp;' . $rowlist->descstatus . '</span></label>
                    </li>
                </ul>
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

    	<table style="border: 2px solid;">
    		<tr>
    			<td><img src="images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px;">
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
    		<tr style=" background-color:#000; color:#fff;">
    			<td>
    				<h2 style="font-size:15px; margin-left:290px; margin-right:290px;">QUALITY SHEET</h2>
    			</td>
    		</tr>
    	</table>
    	<div class="container">

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