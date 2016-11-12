<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model
{

    public $table = 'user';
    public $primary_key = 'ID_USER';
    public $label = 'ID_USER';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('ID_USER'); // ...Or you can set an array with the fields that cannot be filled by insert/update

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
        $dataorder[$i++] = 'ID_PRIVILLAGE';
        $dataorder[$i++] = 'USERNAME';
        $dataorder[$i++] = 'PASSWORD';
        if(!empty($this->input->post('ID_PRIVILLAGE'))){
            $where['LOWER(ID_PRIVILLAGE) LIKE'] = '%'.strtolower($this->input->post('ID_PRIVILLAGE')).'%';
        }
        if(!empty($this->input->post('USERNAME'))){
            $where['LOWER(USERNAME) LIKE'] = '%'.strtolower($this->input->post('USERNAME')).'%';
        }
        if(!empty($this->input->post('PASSWORD'))){
            $where['LOWER(PASSWORD) LIKE'] = '%'.strtolower($this->input->post('PASSWORD')).'%';
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

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */