<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends MY_Model
{

    public $table = 'menu';
    public $primary_key = 'id';
    public $label = 'menu_nama';
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
        $dataorder[$i++] = 'menu_nama';
        $dataorder[$i++] = 'link';
        $dataorder[$i++] = 'icon';
        $dataorder[$i++] = 'order';
        $dataorder[$i++] = 'is_active';
        $dataorder[$i++] = 'is_parent';
        $dataorder[$i++] = 'controller';
        if(!empty($this->input->post('menu_nama'))){
            $where['LOWER(menu_nama) LIKE'] = '%'.strtolower($this->input->post('menu_nama')).'%';
        }
        if(!empty($this->input->post('link'))){
            $where['LOWER(link) LIKE'] = '%'.strtolower($this->input->post('link')).'%';
        }
        if(!empty($this->input->post('icon'))){
            $where['LOWER(icon) LIKE'] = '%'.strtolower($this->input->post('icon')).'%';
        }
        if(!empty($this->input->post('is_active'))){
            $where['LOWER(is_active) LIKE'] = '%'.strtolower($this->input->post('is_active')).'%';
        }
        if(!empty($this->input->post('is_parent'))){
            $where['LOWER(is_parent) LIKE'] = '%'.strtolower($this->input->post('is_parent')).'%';
        }
        if(!empty($this->input->post('controller'))){
            $where['LOWER(controller) LIKE'] = '%'.strtolower($this->input->post('controller')).'%';
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

/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */