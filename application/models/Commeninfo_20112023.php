<?php
class Commeninfo extends CI_Model{
    public function Getmenuprivilege(){
        $userID=$_SESSION['userid'];

        $menuprivilegearray=array();
            
        $sql="SELECT `idtbl_menu_list`, `menu` FROM `tbl_menu_list` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));
        
        foreach($respond->result() as $row){
            $menucheckID=$row->idtbl_menu_list;
            $menuname=str_replace(" ","_",$row->menu);
            
            $sqlprivilegecheck="SELECT `add`, `edit`, `statuschange`, `remove`, `access_status`, `tbl_menu_list_idtbl_menu_list` FROM `tbl_user_privilege` WHERE `tbl_user_idtbl_user`=? AND `tbl_menu_list_idtbl_menu_list`=? AND `status`=?";
            $respondprivilegecheck=$this->db->query($sqlprivilegecheck, array($userID, $menucheckID, 1));
            
            if($respondprivilegecheck->num_rows()>0){
                $objmenu=new stdClass();
                $objmenu->add=$respondprivilegecheck->row(0)->add;
                $objmenu->edit=$respondprivilegecheck->row(0)->edit;
                $objmenu->statuschange=$respondprivilegecheck->row(0)->statuschange;
                $objmenu->remove=$respondprivilegecheck->row(0)->remove;
                $objmenu->access_status=$respondprivilegecheck->row(0)->access_status;
                $objmenu->menuid=$respondprivilegecheck->row(0)->tbl_menu_list_idtbl_menu_list;
                array_push($menuprivilegearray, $objmenu);
            }
        }

        return $menuprivilegearray;
    }
    public function Chartxline(){
        $sql = "SELECT 1 AS month_number, 'January' AS month_name
        UNION ALL
        SELECT 2 AS month_number, 'February' AS month_name
        UNION ALL
        SELECT 3 AS month_number, 'March' AS month_name
        UNION ALL
        SELECT 4 AS month_number, 'April' AS month_name
        UNION ALL
        SELECT 5 AS month_number, 'May' AS month_name
        UNION ALL
        SELECT 6 AS month_number, 'June' AS month_name
        UNION ALL
        SELECT 7 AS month_number, 'July' AS month_name
        UNION ALL
        SELECT 8 AS month_number, 'August' AS month_name
        UNION ALL
        SELECT 9 AS month_number, 'September' AS month_name
        UNION ALL
        SELECT 10 AS month_number, 'October' AS month_name
        UNION ALL
        SELECT 11 AS month_number, 'November' AS month_name
        UNION ALL
        SELECT 12 AS month_number, 'December' AS month_name";

        $respond = $this->db->query($sql);

        $list = array(); // Initialize an empty array

        foreach ($respond->result() as $rowlist) {
            $list[] = $rowlist->month_name;
        }

        return json_encode($list);

    }
    public function Chartyline(){
        $sql = "SELECT YEAR(`orderdate`) AS order_year, MONTH(`orderdate`) AS order_month, SUM(`nettotal`) AS total_nettotal
        FROM `tbl_customer_porder`
        GROUP BY order_year, order_month
        ORDER BY order_year, order_month;
        ";
    
        $respond = $this->db->query($sql);
    
        $list = array(); // Initialize an empty array
    
        foreach ($respond->result() as $rowlist) {
            $list[] = $rowlist->total_nettotal;
        }
    
        return json_encode($list);
    }
    public function Chartxlinedaily(){
        $sql = "SELECT
            DAYOFMONTH(date) AS day_number,
            DATE_FORMAT(date, '%Y-%m') AS month,
            DATE_FORMAT(date, '%Y-%m-%d') AS date
        FROM (
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 1) DAY AS date
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 2) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 3) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 4) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 5) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 6) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 7) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 8) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 9) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 10) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 11) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 12) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 13) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 14) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 15) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 16) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 17) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 18) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 19) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 20) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 21) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 22) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 23) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 24) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 25) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 26) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 27) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 28) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 29) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 30) DAY
            UNION ALL
            SELECT CURDATE() - INTERVAL (DAYOFMONTH(CURDATE()) - 31) DAY
        ) AS t
        WHERE
            t.date <= CURDATE();
        ";
    
        $respond = $this->db->query($sql);
    
        $list = array(); // Initialize an empty array
    
        foreach ($respond->result() as $rowlist) {
            $list[] = $rowlist->date;
        }
    
        return json_encode($list);
    }
    
    
    public function Chartylinedaily(){
        $sql = "SELECT DAY(`orderdate`) AS order_day, SUM(`nettotal`) AS total_nettotal
        FROM `tbl_customer_porder`
        WHERE MONTH(`orderdate`) = MONTH(CURRENT_DATE()) AND YEAR(`orderdate`) = YEAR(CURRENT_DATE())
        GROUP BY order_day
        ORDER BY order_day;";
    
        $respond = $this->db->query($sql);
    
        $list = array(); // Initialize an empty array
    
        foreach ($respond->result() as $rowlist) {
            $list[] = $rowlist->total_nettotal;
        }
    
        return json_encode($list);
    }
    public function salepricechartxline(){
        $sql = "SELECT `desc` FROM `tbl_product` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));

        foreach($respond->result() as $rowlist){
            $list[]=$rowlist->desc;
        }

        return json_encode($list);
    }
    public function salepricechartyline(){
        $sql = "SELECT `qty` FROM `tbl_product_stock` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));

        foreach($respond->result() as $rowlist){
            $list[]=$rowlist->qty;
        }

        return json_encode($list);
    }

    public function matstockchartxline(){
        $sql = "SELECT `materialinfocode` FROM `tbl_material_info` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));

        foreach($respond->result() as $rowlist){
            $list[]=$rowlist->materialinfocode;
        }

        return json_encode($list);
    }
    public function matstockchartyline(){
        $sql = "SELECT `qty` FROM `tbl_stock` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));

        foreach($respond->result() as $rowlist){
            $list[]=$rowlist->qty;
        }

        return json_encode($list);
    }
}