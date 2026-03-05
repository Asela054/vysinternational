<?php
class Qualitycheckreportinfo extends CI_Model {
    public function Qualitycheckreport($x, $y) {
        $recordID = $x;
        $materialid = $y;

        $html = '';

        $sql = "SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) AS descstatus, `tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 AS el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 AS el) AS tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_grn_idtbl_grn`=? AND `tbl_quality_info`.`status`=?";

        $respond = $this->db->query($sql, array($recordID, 1));
        $qualities = $respond->result();

        $sqlgrn = "SELECT `idtbl_grn`, `grndate` FROM `tbl_grn` WHERE `status`=? AND `idtbl_grn`=?";
        $respondgrn = $this->db->query($sqlgrn, array(1, $recordID));

		$qualitySets = array_chunk($qualities, 3); // Change array_chunk size to match the number of records in each set

		$qualityhtml = '';
		foreach ($qualitySets as $set) {
			$qualityhtml .= '<br><div style="display: flex; margin-right: 1000px;">';
			foreach ($set as $index => $rowlist) {
				$qualityhtml .= '
				<div style="flex: 1; margin-right: 10px;">
					<label style="font-size: 10px;">' . $rowlist->qualitysubcategory . ' :</label>
					<input type="text" name="grn' . $index . '" id="grn' . $index . '"  value="' . $rowlist->descstatus . '" readonly>
				</div>';
			}
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
                            vertical-align: top;
                        }

                        .tg .tg-0lax {
                            text-align: left;
                            vertical-align: top;
                        }
                    </style>
                </head>
                <body>
                    <table style="border: 2px solid;">
                        <tr>
                            <td>
                                <img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px;">
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
                            <td style="background-color:#000; color:#fff; width:50%">
                                <h2 style="font-size:15px; margin-left:50px; margin-right:105px">QUALITY EXAMINE WORK SHEET</h2>
                            </td>
                            <td style="background-color:#fff; color:#000; width:50%">
                                <h2 style="font-size:15px; padding-right:50px">| RM | PM | LM | PD | FG | DIRECT |</h2>
                            </td>
                        </tr>
                    </table>
                    <div class="container">
                        <div class="form-row">
                            <br>
                            <div class="col">
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">GRN#:</label>
                                <input type="text" name="grn" id="grn" class="form-control form-control-sm" value="'.$respondgrn->row(0)->idtbl_grn.'" readonly>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">GRN DATE:</label>
                                <input type="text" name="grndate" id="grndate" class="form-control form-control-sm" value="'.$respondgrn->row(0)->grndate.'" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">ITEM DESCRIPTION:</label>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">GRN QUANTITY:</label>
                                <input type="text" name="grnqty" id="grnqty" class="form-control form-control-sm" value="" readonly>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">PACKAGE DETAILS (GRN):</label>
                                <input type="text" name="grnpackinfo" id="grnpackinfo" class="form-control form-control-sm" value="">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">ACTUAL QUANTITY:</label>
                                <input type="text" name="actualqty" id="actualqty" class="form-control form-control-sm" value="">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="small font-weight-bold text-dark" style="font-size:10px;">PACKAGE DETAILS (ACTUAL):</label>
                                <input type="text" name="actualpackinfo" id="actualpackinfo" class="form-control form-control-sm" value="">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <table style="border: 1px solid">
                                <tr>
                                    <td style="background-color:#A2A2A0; color:#000;">
                                        <h2 style="font-size:15px; margin-left:260px; margin-right:300px">QUALITY PARAMETERS:</h2>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            '.$qualityhtml.'
                        </div>
                    </div>
                </body>
            </html>';

        // echo $html;
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));
    }
}