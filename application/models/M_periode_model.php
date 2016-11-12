<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_periode_model extends MY_Model
{

    public $table = 'm_periode';
    public $primary_key = 'id';
    public $label = 'name';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

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
        $dataorder[$i++] = 'name';
        $dataorder[$i++] = 'depart_date';
        $dataorder[$i++] = 'arrival_date';
        $dataorder[$i++] = 'quantity';
        $dataorder[$i++] = 'keterangan';
        if(!empty($this->input->post('name'))){
            $where['LOWER(name) LIKE'] = '%'.strtolower($this->input->post('name')).'%';
        }
        if(!empty($this->input->post('depart_date_start'))){
            $where['depart_date >='] = $this->input->post('depart_date_start');
        }
        if(!empty($this->input->post('depart_date_end'))){
            $where['depart_date <='] = $this->input->post('depart_date_end');
        }
        if(!empty($this->input->post('arrival_date_start'))){
            $where['arrival_date >='] = $this->input->post('arrival_date_start');
        }
        if(!empty($this->input->post('arrival_date_end'))){
            $where['arrival_date <='] = $this->input->post('arrival_date_end');
        }
        if(!empty($this->input->post('quantity'))){
            $where['LOWER(quantity) LIKE'] = '%'.strtolower($this->input->post('quantity')).'%';
        }
        if(!empty($this->input->post('keterangan'))){
            $where['LOWER(keterangan) LIKE'] = '%'.strtolower($this->input->post('keterangan')).'%';
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

/* End of file M_periode_model.php */
/* Location: ./application/models/M_periode_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */