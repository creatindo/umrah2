<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_document_model extends MY_Model
{

    public $table = 't_document';
    public $primary_key = 'id';
    public $label = 'id';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

    function __construct()
    {
        parent::__construct();
        $this->soft_deletes = TRUE;
        $this->has_one['m_customer'] = array('M_customer_model','customer_id','customer_id');
        $this->has_one['m_dokument'] = array('M_dokument_model','document_id','document_id');
    }
    
    // get total rows
    function get_limit_data($limit, $start) {
        $order            = $this->input->post('order');
        $dataorder = array();
        $where = array();

        $i=1;
        $dataorder[$i++] = 'document_id';
        $dataorder[$i++] = 'customer_id';
        $dataorder[$i++] = 'quantity';
        if(!empty($this->input->post('document_id')))
        {
            $where['document_id'] = $this->input->post('document_id');
        }
        if(!empty($this->input->post('customer_id')))
        {
            $where['customer_id'] = $this->input->post('customer_id');
        }
        if(!empty($this->input->post('quantity')))
        {
            $where['LOWER(quantity) LIKE'] = '%'.strtolower($this->input->post('quantity')).'%';
        }

        $this->where($where);
        $result['total_rows'] = $this->count_rows();
        
        $this->where($where);
        $this->order_by( $dataorder[$order[0]["column"]],  $order[0]["dir"]);
        $this->limit($start, $limit);
        $result['get_db']=$this
                            ->with_m_customer()
                            ->with_m_dokument()
                            ->get_all();
        return $result;
    }

}

/* End of file T_document_model.php */
/* Location: ./application/models/T_document_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */