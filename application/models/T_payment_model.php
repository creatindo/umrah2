<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_payment_model extends MY_Model
{

    public $table = 't_payment';
    public $view = 'v_payment';
    public $primary_key = 'id';
    public $label = 'id';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

    function __construct()
    {
        parent::__construct();
        $this->soft_deletes = TRUE;
        $this->has_one['m_customer'] = array('M_customer_model','customer_id','customer_id');
    }
    
    // get total rows
    function get_limit_data($limit, $start) {
        $order            = $this->input->post('order');
        $dataorder = array();
        $where = array();

        $i=1;
        $dataorder[$i++] = 'customer_id';
        $dataorder[$i++] = 'no_transaction';
        $dataorder[$i++] = 'payment_date';
        $dataorder[$i++] = 'payment_value';
        $dataorder[$i++] = 'payment_kurs_dollar';
        if(!empty($this->input->post('customer_id'))){
            $where['customer_id'] = $this->input->post('customer_id');
        }
        if(!empty($this->input->post('no_transaction'))){
            $where['LOWER(no_transaction) LIKE'] = '%'.strtolower($this->input->post('no_transaction')).'%';
        }
        if(!empty($this->input->post('payment_date_start'))){
            $where['payment_date >='] = $this->input->post('payment_date_start');
        }
        if(!empty($this->input->post('payment_date_end'))){
            $where['payment_date <='] = $this->input->post('payment_date_end');
        }
        if(!empty($this->input->post('payment_value'))){
            $where['LOWER(payment_value) LIKE'] = '%'.strtolower($this->input->post('payment_value')).'%';
        }
        if(!empty($this->input->post('payment_kurs_dollar'))){
            $where['LOWER(payment_kurs_dollar) LIKE'] = '%'.strtolower($this->input->post('payment_kurs_dollar')).'%';
        }

        $this->where($where);
        $result['total_rows'] = $this->count_rows();
        
        $this->where($where);
        $this->order_by( $dataorder[$order[0]["column"]],  $order[0]["dir"]);
        $this->limit($start, $limit);
        $result['get_db']=$this
                            ->with_m_customer()
                            ->get_all();
        return $result;
    }

    public function _get($customer_id='')
    {
        $this->table = $this->view;
        return $this->where('customer_id', $customer_id)->get();
    }

}

/* End of file T_payment_model.php */
/* Location: ./application/models/T_payment_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */