<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_dokument_model extends MY_Model
{

    public $table = 'm_dokument';
    public $primary_key = 'document_id';
    public $label = 'document_name';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('document_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

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
        $dataorder[$i++] = 'document_name';
        $dataorder[$i++] = 'document_quantity';
        if(!empty($this->input->post('document_name'))){
            $where['LOWER(document_name) LIKE'] = '%'.strtolower($this->input->post('document_name')).'%';
        }
        if(!empty($this->input->post('document_quantity'))){
            $where['LOWER(document_quantity) LIKE'] = '%'.strtolower($this->input->post('document_quantity')).'%';
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

/* End of file M_dokument_model.php */
/* Location: ./application/models/M_dokument_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */