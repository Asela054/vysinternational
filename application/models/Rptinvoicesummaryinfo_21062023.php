<?php
class Rptinvoicesummaryinfo extends CI_Model{
    public function Getinvoicelist(){
        $this->db->select('`idtbl_invoice`');
        $this->db->from('tbl_invoice');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getinvoicedetail()
    {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('`tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`,`tbl_invoice_detail`.`idtbl_invoice_detail`,`tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`, `tbl_product`.`productcode`,`tbl_product`.`idtbl_product`');
        $this->db->from('tbl_invoice_detail');
        $this->db->join('tbl_invoice', 'tbl_invoice.idtbl_invoice = tbl_invoice_detail.tbl_invoice_idtbl_invoice', 'left');
        $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_invoice.tbl_customer_porder_idtbl_customer_porder', 'left');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_invoice_detail.tbl_product_idtbl_product', 'left');
        $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
        $this->db->where('tbl_invoice_detail.status', 1);
        $productDetails = $this->db->get()->result();
        
        $html='';
        foreach ($productDetails as $product) {
            $html .= '
            <div class="row">
                <div class="col-12">
                    <h6 class="title-style mb-2 text-primary text-uppercase"><span>Invoice Details</span></h6><br>          
                    <div class="row">
                        <div class="col"><label class="text-dark font-weight-bold text-uppercase">Invoice No:</label> INV/DT-0000' . $recordID . '</div>
                        <div class="col"><label class="text-dark font-weight-bold text-uppercase">Quantity:</label> ' . $product->qty . '</div>
                        <div class="col"><label class="text-dark font-weight-bold text-uppercase">Sale Price:</label> ' . $product->saleprice . '</div>
                        <div class="col"><label class="text-dark font-weight-bold text-uppercase">Total:</label> ' . $product->total . '</div>
                        <div class="col"><label class="text-dark font-weight-bold text-uppercase">Product:</label> ' . $product->productcode . '</div>
                    </div>';

                    $sql = "SELECT `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`,`tbl_production_material_issue`.`qty`, `tbl_production_material_issue`.`batchno`,`tbl_material_info`.`materialinfocode` FROM `tbl_production_material_issue` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_material_issue`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order`=`tbl_production_material_issue`.`tbl_production_order_idtbl_production_order` LEFT JOIN `tbl_production_orderdetail` ON `tbl_production_order`.`idtbl_production_order`=`tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_invoice` ON `tbl_invoice`.`idtbl_invoice`=`tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder` WHERE `tbl_invoice`.`idtbl_invoice`=?  AND `tbl_production_material_issue`.`tbl_product_idtbl_product`=? AND `tbl_production_material_issue`.`status`=? GROUP BY `tbl_production_material_issue`.`idtbl_production_material_issue`";
                    $materials = $this->db->query($sql, array($recordID, $product->idtbl_product, 1))->result(); 

                    $html .= '<br><h6 class="title-style mb-2 text-primary text-uppercase"><span>Materials issued to Production Order</span></h6><br>';

                    foreach ($materials as $material) {
                        $html .= '
                        <div class="row">
                            <div class="col"><label class="text-dark font-weight-bold text-uppercase"></label></div>
                            <div class="col"><label class="text-dark font-weight-bold text-uppercase">Material:</label>' . $material->materialinfocode . '</div>
                            <div class="col"><label class="text-dark font-weight-bold text-uppercase">Batch No.:</label> ' . $material->batchno . '</div>
                            <div class="col"><label class="text-dark font-weight-bold text-uppercase">Quantity:</label> ' . $material->qty . '</div>
                        </div>';
                    }

                    if ($productDetails && $materials && $productDetails[0]->tbl_customer_porder_idtbl_customer_porder == $materials[0]->tbl_customer_porder_idtbl_customer_porder) {
                        $sqlrawmaterial = "SELECT `tbl_material_info`.`idtbl_material_info`,`tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_production_material_issue`.batchno FROM `tbl_production_material_issue` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info` = `tbl_production_material_issue`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code` = `tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_production_material_issue`.`tbl_product_idtbl_product` = ?  AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=1 AND `tbl_production_material_issue`.`status`=1";

                        $rawmaterials = $this->db->query($sqlrawmaterial, array($product->idtbl_product))->result();
            
                        $materialinfocode = '';
                        $materialinfocodeid = '';

                        foreach ($rawmaterials as $rawmaterial) {
                            $materialinfocode = $rawmaterial->materialinfocode;
                            $materialname = $rawmaterial->materialname;
                            $materialinfocodeid = $rawmaterial->idtbl_material_info;
                            $materialinfobatchno = $rawmaterial->batchno;
                            // Perform any necessary operations with the materialinfocode variable
                        }

                        if (!empty($materialinfocode)) {
                            $html .= '
                            <br><h6 class="title-style mb-2 text-primary text-uppercase"><span>Raw Material issued to Production Order</span></h6><br>  
                            <div class="row">
                                <div class="col" style="padding-left:26%"><label class="text-dark font-weight-bold text-uppercase">Raw Material:    &nbsp;</label>' . $materialname . ' -   ' . $materialinfocode . '</div>
                            </div>';
                        }

                        $html .= '<br><h6 class="title-style mb-2 text-primary text-uppercase"><span>GRN Details of Materials</span></h6><br>';

                        $sqlgrn = "SELECT `tbl_grn`.`batchno`, `tbl_grn`.`grndate`, `tbl_grndetail`.`unitprice`, `tbl_supplier`.`suppliername` FROM `tbl_grn` LEFT JOIN `tbl_grndetail` ON `tbl_grn`.`idtbl_grn` = `tbl_grndetail`.`tbl_grn_idtbl_grn` LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier` = `tbl_grn`.`tbl_supplier_idtbl_supplier` WHERE `tbl_grndetail`.`tbl_material_info_idtbl_material_info` = ? AND `tbl_grn`.`batchno`=? AND `tbl_grndetail`.`status`=1";
                        $grn = $this->db->query($sqlgrn, array($materialinfocodeid, $materialinfobatchno))->result();

                        foreach ($grn as $grn) {
                            $html .= '
                            <div class="row">
                                <div class="col"><label class="text-dark font-weight-bold text-uppercase">GRN Date:</label> ' . $grn->grndate . '</div>
                                <div class="col"><label class="text-dark font-weight-bold text-uppercase">Batch No.:</label> ' . $grn->batchno . '</div>
                                <div class="col"><label class="text-dark font-weight-bold text-uppercase">Unit Price:</label> ' . $grn->unitprice . '</div>
                                <div class="col"><label class="text-dark font-weight-bold text-uppercase">Supplier:</label> ' . $grn->suppliername . '</div>
                            </div>';
                        }
                    }

                $html .= '</div>
            </div><br>
            <hr>';
        }
    
        echo $html;
    
    }
}