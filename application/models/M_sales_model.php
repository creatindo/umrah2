<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_sales_model extends MY_Model
{

    public $table = 'm_sales';
    public $primary_key = 'sales_id';
    public $label = 'sales_name';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('sales_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

    function __construct()
    {
        parent::__construct();
        $this->soft_deletes = TRUE;
    }
    
    // get total rows
    function get_limit_data($limit, $start) {
        $order            = $this->input->post('order');
        $dataorder = array();
        $where = array();

        $i=1;
        $dataorder[$i++] = 'sales_name';
        $dataorder[$i++] = 'sales_telp';
        $dataorder[$i++] = 'sales_address';
        $dataorder[$i++] = 'sales_img';
        $dataorder[$i++] = 'sales_mail';
        if(!empty($this->input->post('sales_name'))){
            $where['LOWER(sales_name) LIKE'] = '%'.strtolower($this->input->post('sales_name')).'%';
        }
        if(!empty($this->input->post('sales_telp'))){
            $where['LOWER(sales_telp) LIKE'] = '%'.strtolower($this->input->post('sales_telp')).'%';
        }
        if(!empty($this->input->post('sales_address'))){
            $where['LOWER(sales_address) LIKE'] = '%'.strtolower($this->input->post('sales_address')).'%';
        }
        if(!empty($this->input->post('sales_img'))){
            $where['LOWER(sales_img) LIKE'] = '%'.strtolower($this->input->post('sales_img')).'%';
        }
        if(!empty($this->input->post('sales_mail'))){
            $where['LOWER(sales_mail) LIKE'] = '%'.strtolower($this->input->post('sales_mail')).'%';
        }

        $this->where($where);
        $result['total_rows'] = $this->count_rows();
        
        $this->where($where);
        $this->order_by( $dataorder[$order[0]["column"]],  $order[0]["dir"]);
        $this->limit($start, $limit);
        $result['get_db']=$this
                            ->get_all();
        return $result;
    }

}

/* End of file M_sales_model.php */
/* Location: ./application/models/M_sales_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */