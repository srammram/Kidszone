<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Db_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /*public function getLatestSales()
    {
        if ($this->Settings->restrict_user && !$this->Owner && !$this->Admin) {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }
        $this->db->where('payment_status', 'Completed');
        $this->db->order_by('id', 'desc');
        $q = $this->db->get("bils", 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            
            return $data;
        }
    }*/

    public function getLastestQuotes()
    {
        if ($this->Settings->restrict_user && !$this->Owner && !$this->Admin) {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }
        $this->db->order_by('id', 'desc');
        $q = $this->db->get("quotes", 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getLatestPurchases()
    {
        if ($this->Settings->restrict_user && !$this->Owner && !$this->Admin) {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }
        $this->db->order_by('id', 'desc');
        $q = $this->db->get("purchases", 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getLatestTransfers()
    {
        if ($this->Settings->restrict_user && !$this->Owner && !$this->Admin) {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }
        $this->db->order_by('id', 'desc');
        $q = $this->db->get("transfers", 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getLatestCustomers()
    {
        $this->db->order_by('id', 'desc');
        $q = $this->db->get_where("companies", array('group_name' => 'customer'), 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getLatestSuppliers()
    {
        $this->db->order_by('id', 'desc');
        $q = $this->db->get_where("companies", array('group_name' => 'supplier'), 5);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getChartData()
    {
        $myQuery = "SELECT S.month,
        COALESCE(S.sales, 0) as sales,
        COALESCE( P.purchases, 0 ) as purchases,
        COALESCE(S.tax1, 0) as tax1,
        COALESCE(S.tax2, 0) as tax2,
        COALESCE( P.ptax, 0 ) as ptax
        FROM (  SELECT  date_format(date, '%Y-%m') Month,
                SUM(total) Sales,
                SUM(recipe_tax) tax1,
                SUM(order_tax) tax2
                FROM " . $this->db->dbprefix('bils') . "
                WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH )
                GROUP BY date_format(date, '%Y-%m')) S
            LEFT JOIN ( SELECT  date_format(date, '%Y-%m') Month,
                        SUM(product_tax) ptax,
                        SUM(order_tax) otax,
                        SUM(total) purchases
                        FROM " . $this->db->dbprefix('purchases') . "
                        GROUP BY date_format(date, '%Y-%m')) P
            ON S.Month = P.Month
            ORDER BY S.Month";

        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStockValue()
    {
        $q = $this->db->query("SELECT SUM(qty*price) as stock_by_price, SUM(qty*cost) as stock_by_cost
        FROM (
            Select sum(COALESCE(" . $this->db->dbprefix('warehouses_products') . ".quantity, 0)) as qty, price, cost
            FROM " . $this->db->dbprefix('products') . "
            JOIN " . $this->db->dbprefix('warehouses_products') . " ON " . $this->db->dbprefix('warehouses_products') . ".product_id=" . $this->db->dbprefix('products') . ".id
            GROUP BY " . $this->db->dbprefix('warehouses_products') . ".id ) a");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getBestSeller_il($start_date = NULL, $end_date = NULL)
    {
        if (!$start_date) {
            $start_date = date('Y-m-d', strtotime('first day of this month')) . ' 00:00:00';
        }
        if (!$end_date) {
            $end_date = date('Y-m-d', strtotime('last day of this month')) . ' 23:59:59';
        }

        $this->db
            ->select("recipe_name AS product_name, recipe_code AS product_code")
            ->select_sum('quantity')
            ->from('bil_items')
            ->join('bils', 'bils.id = bil_items.bil_id', 'left')
            ->where('date >=', $start_date)
            ->where('date <', $end_date)
            ->where('payment_status', 'Completed') 
            ->group_by('recipe_name, recipe_code')
            ->order_by('sum(quantity)', 'desc')
            ->limit(10);
        $q = $this->db->get();
        /*echo "<pre>";
        print_r($q->result());die;*/
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }



    function link_permission(){

        $this->db
                ->select('*')
                ->from('group_permission')
                ->where('group_id = ', $this->session->userdata('user_id'));

        $q = $this->db->get();
        //print_r($this->db->last_query());
        //die();
        if($q->num_rows()>0){
			
			return $q->row();
		}
		return false;        
    }


    // ****************************************

	function getFormOneTotalCount() {

		$this->db->select('*');
		$this->db->from('formone');
		$this->db->join('formtwo', 'formone.refer_code = formtwo.formone_code', 'left');

		$q = $this->db->get();
		return $q->num_rows();
	}

	function getFormTwoTotalCount() {

		$this->db->select('*');
		$this->db->from('formtwo');

		$q = $this->db->get();
		return $q->num_rows();
	}

    function getFormThreeTotalCount() {

		$this->db->select('*');
		$this->db->from('formthree');

		$q = $this->db->get();
		return $q->num_rows();
    }


    public function getALLBioDigesterFormTwo() {

        $this->db->select('fone.id, fone.refer_code');
        $this->db->from('formone fone');
        $this->db->join('formtwo ftwo', 'fone.refer_code = ftwo.formone_code','left');
        $this->db->where('ftwo.formone_code IS NULL');

        $q = $this->db->get();
        //print_r($this->db->last_query());
        //die;

        if($q->num_rows() > 0){
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return count($data);
        }

        return FALSE;
    }


    public function getALLBioDigesterFormThree() {

        $this->db->select('ftwo.id,ftwo.refer_code');
        $this->db->from('formtwo ftwo');
        $this->db->join('formthree fthree', 'ftwo.refer_code = fthree.formtwo_code','left');
        $this->db->where('fthree.formtwo_code IS NULL');

        $q = $this->db->get();
        //print_r($this->db->last_query());
        //die;

        if($q->num_rows() > 0){
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return count($data);
        }

        return FALSE;
    }




	function getRegisteTotalCount($para) {

        $where_month = "YEAR(created_on) = YEAR(NOW()) AND MONTH(created_on) = MONTH(NOW())";
        $where_year = "YEAR(created_on) = YEAR(NOW())";
        $where_current_date = "DATE(created_on) = DATE(NOW())";

        if($para=="total")
        {
            $this->db->select('*');
            $this->db->from('register');
        }
        else if($para=="month")
        {
            $this->db->select('*');
            $this->db->from('register');
            $this->db->where($where_month);
        }
        else if($para=="year")
        {
            $this->db->select('*');
            $this->db->from('register');
            $this->db->where($where_year);
        }
        else if($para=="cur_date")
        {
            $this->db->select('*');
            $this->db->from('register');
            $this->db->where($where_current_date);
        }

        $q = $this->db->get();
        //print_r($this->db->last_query()); die;
		return $q->num_rows();
    }

}
