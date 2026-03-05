<?php
class Rptinvoicesummaryinfo extends CI_Model{
    public function Getinvoicelist(){
        $this->db->select('`idtbl_invoice`');
        $this->db->from('tbl_invoice');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getinvoicedetail(){
        $recordID = $this->input->post('recordID');
        $html='';

        if(!empty($recordID)){
            $mainarray=array();

            $this->db->select('`tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`invdate`, `tbl_invoice`.`nettotal`, `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`, `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer`.`name`');
            $this->db->from('tbl_invoice');
            $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_invoice.tbl_customer_porder_idtbl_customer_porder', 'left');
            $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customer_porder.tbl_customer_idtbl_customer', 'left');
            $this->db->where('tbl_invoice.idtbl_invoice', $recordID);
            $this->db->where('tbl_invoice.status', 1);
            $respond = $this->db->get();

            // print_r($this->db->last_query());    
            $this->db->select('`tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`, `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_product`.`desc`');
            $this->db->from('tbl_invoice_detail');
            $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_invoice_detail.tbl_product_idtbl_product', 'left');
            $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
            $this->db->where('tbl_invoice_detail.status', 1);
            $respondinvdetail = $this->db->get();
            
            foreach($respondinvdetail->result() AS $rowinvetail){
                $obj=new stdClass();
                $obj->productcode=$rowinvetail->productcode;
                $obj->desc=$rowinvetail->desc;
                $obj->idtbl_product=$rowinvetail->idtbl_product;
                $obj->qty=$rowinvetail->qty;
                $obj->saleprice=$rowinvetail->saleprice;
                $obj->total=$rowinvetail->total;

                $productID=$rowinvetail->idtbl_product;

                $this->db->select('`tbl_production_material_issue`.`batchno`, `tbl_production_material_issue`.`qty, `tbl_production_material_issue`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`, `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`');
                $this->db->from('tbl_production_material_issue');
                $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_material_issue.tbl_production_order_idtbl_production_order', 'left');
                $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_production_material_issue.tbl_material_info_idtbl_material_info', 'left');
                $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                $this->db->join('tbl_invoice', 'tbl_invoice.tbl_customer_porder_idtbl_customer_porder = tbl_production_order.tbl_customer_porder_idtbl_customer_porder', 'left');
                $this->db->join('tbl_invoice_detail', 'tbl_invoice_detail.tbl_invoice_idtbl_invoice = tbl_invoice.idtbl_invoice', 'left');
                $this->db->where('tbl_production_material_issue.tbl_product_idtbl_product', $productID);
                $this->db->where('tbl_invoice_detail.tbl_product_idtbl_product', $productID);
                $this->db->where('tbl_production_material_issue.status', 1);
                $this->db->where('tbl_material_info.tbl_material_category_idtbl_material_category', 1);
                $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
                $respondissuematerial = $this->db->get();

                $obj->issuematerial=$respondissuematerial->result();

                foreach($respondissuematerial->result() AS $rowissuematerial){
                    if($rowissuematerial->tbl_customer_porder_idtbl_customer_porder==$respond->row(0)->idtbl_customer_porder){
                        $materialbatchno=$rowissuematerial->batchno;
                        $materialID=$rowissuematerial->idtbl_material_info;

                        $this->db->select('`tbl_grn`.`grndate`, `tbl_grn`.`batchno`, `tbl_grndetail`.`unitprice`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_supplier`.`suppliername`');
                        $this->db->from('tbl_grn');
                        $this->db->join('tbl_grndetail', 'tbl_grndetail.tbl_grn_idtbl_grn = tbl_grn.idtbl_grn', 'left');
                        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
                        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                        $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_grn.tbl_supplier_idtbl_supplier', 'left');
                        $this->db->where('tbl_grn.batchno', $materialbatchno);
                        $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $materialID);
                        $this->db->where('tbl_grndetail.status', 1);
                        $respondgrninfo = $this->db->get();
                        
                        $obj->grninfo=$respondgrninfo->result();
                    }
                    else{
                        $obj->grninfo='';
                    }
                }

                array_push($mainarray, $obj);
            }

            // print_r($mainarray);
            $html.='
            <table class="table table-striped table-bordered table-sm small w-100">
                <tr>
                    <th colspan="5" class="text-uppercase table-primary">Invoice Information</th>
                </tr>
                <tr>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Invoice No:</label> INV/DT-0000' . $respond->row(0)->idtbl_invoice . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Invoice Date:</label> ' . $respond->row(0)->invdate . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Customer:</label> ' . $respond->row(0)->name . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Sales OR/ NO:</label> UN/SOD-0000' . $respond->row(0)->idtbl_customer_porder . '</th>
                    <th nowrap class="text-right"><label class="text-dark font-weight-bold text-uppercase">Net Total:</label> ' . number_format($respond->row(0)->nettotal, 2) . '</th>
                </tr>';
                foreach($mainarray as $rowmaininfo){
                    $html.='
                    <tr>
                        <th colspan="5" class="text-uppercase table-pink">Invoice Product Information</th>
                    </tr>
                    <tr>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Prodcut Code:</label> ' . $rowmaininfo->productcode . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Product Name:</label> ' . $rowmaininfo->desc . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $rowmaininfo->qty . '</th>
                        <th nowrap class="text-right"><label class="text-dark font-weight-bold text-uppercase">Unit:</label> ' . number_format($rowmaininfo->saleprice, 2) . '</th>
                        <th nowrap class="text-right"><label class="text-dark font-weight-bold text-uppercase">Total:</label> ' . number_format($rowmaininfo->total, 2) . '</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-uppercase table-orange">Issue Material Information</th>
                    </tr>';
                    foreach($rowmaininfo->issuematerial as $rowissuemate){
                        $html.='
                        <tr>
                            <th nowrap>&nbsp;</th>
                            <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Name:</label> ' . $rowissuemate->materialname . '</th>
                            <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $rowissuemate->materialinfocode . '</th>
                            <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $rowissuemate->batchno . '</th>
                            <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $rowissuemate->qty . '</th>
                        </tr>
                        ';
                    }
                    $html.='
                    <tr>
                        <th colspan="5" class="text-uppercase table-success">GRN Material Information</th>
                    </tr>';
                    if(!empty($rowmaininfo->grninfo)){
                        foreach($rowmaininfo->grninfo as $rowgrninfo){
                            $html.='
                            <tr>
                                <th nowrap>&nbsp;</th>
                                <th nowrap><label class="text-dark font-weight-bold text-uppercase">GRN Date:</label> ' . $rowgrninfo->grndate . '</th>
                                <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $rowgrninfo->materialinfocode . '</th>
                                <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $rowgrninfo->batchno . '</th>
                                <th nowrap><label class="text-dark font-weight-bold text-uppercase">Supplier:</label> ' . $rowgrninfo->suppliername . '</th>
                            </tr>
                            ';
                        }
                    }
                }
            $html.='  
            </table>
            ';
        }    
        echo $html;
    
    }
}