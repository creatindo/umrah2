<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_customer_model extends MY_Model
{

    public $table = 'm_customer';
    public $primary_key = 'customer_id';
    public $label = 'customer_name';
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array('customer_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update

    function __construct()
    {
        parent::__construct();
        $this->soft_deletes = TRUE;
        $this->has_one['m_periode'] = array('M_periode_model','id','periode_id');
        $this->has_one['m_sales'] = array('M_sales_model','sales_id','sales_id');
    }
    
    // get total rows
    function get_limit_data($limit, $start) {
        $order            = $this->input->post('order');
        $dataorder = array();
        $where = array();

        $i=1;
        $dataorder[$i++] = 'customer_name';
        $dataorder[$i++] = 'customer_address';
        $dataorder[$i++] = 'mother_name';
        $dataorder[$i++] = 'customer_birth_place';
        $dataorder[$i++] = 'customer_birth_date';
        $dataorder[$i++] = 'customer_gender';
        $dataorder[$i++] = 'customer_jobs';
        $dataorder[$i++] = 'customer_passport_no';
        $dataorder[$i++] = 'customer_passport_date';
        $dataorder[$i++] = 'customer_img';
        $dataorder[$i++] = 'kota_id';
        $dataorder[$i++] = 'kecamatan_id';
        $dataorder[$i++] = 'propinsi_id';
        $dataorder[$i++] = 'periode_id';
        $dataorder[$i++] = 'sales_id';
        if(!empty($this->input->post('customer_name'))){
            $where['LOWER(customer_name) LIKE'] = '%'.strtolower($this->input->post('customer_name')).'%';
        }
        if(!empty($this->input->post('customer_address'))){
            $where['LOWER(customer_address) LIKE'] = '%'.strtolower($this->input->post('customer_address')).'%';
        }
        if(!empty($this->input->post('mother_name'))){
            $where['LOWER(mother_name) LIKE'] = '%'.strtolower($this->input->post('mother_name')).'%';
        }
        if(!empty($this->input->post('customer_birth_place'))){
            $where['LOWER(customer_birth_place) LIKE'] = '%'.strtolower($this->input->post('customer_birth_place')).'%';
        }
        if(!empty($this->input->post('customer_birth_date_start'))){
            $where['customer_birth_date >='] = $this->input->post('customer_birth_date_start');
        }
        if(!empty($this->input->post('customer_birth_date_end'))){
            $where['customer_birth_date <='] = $this->input->post('customer_birth_date_end');
        }
        if(!empty($this->input->post('customer_gender'))){
            $where['LOWER(customer_gender) LIKE'] = '%'.strtolower($this->input->post('customer_gender')).'%';
        }
        if(!empty($this->input->post('customer_jobs'))){
            $where['LOWER(customer_jobs) LIKE'] = '%'.strtolower($this->input->post('customer_jobs')).'%';
        }
        if(!empty($this->input->post('customer_passport_no'))){
            $where['LOWER(customer_passport_no) LIKE'] = '%'.strtolower($this->input->post('customer_passport_no')).'%';
        }
        if(!empty($this->input->post('customer_passport_date'))){
            $where['LOWER(customer_passport_date) LIKE'] = '%'.strtolower($this->input->post('customer_passport_date')).'%';
        }
        if(!empty($this->input->post('customer_img'))){
            $where['LOWER(customer_img) LIKE'] = '%'.strtolower($this->input->post('customer_img')).'%';
        }
        if(!empty($this->input->post('kota_id'))){
            $where['LOWER(kota_id) LIKE'] = '%'.strtolower($this->input->post('kota_id')).'%';
        }
        if(!empty($this->input->post('kecamatan_id'))){
            $where['LOWER(kecamatan_id) LIKE'] = '%'.strtolower($this->input->post('kecamatan_id')).'%';
        }
        if(!empty($this->input->post('propinsi_id'))){
            $where['LOWER(propinsi_id) LIKE'] = '%'.strtolower($this->input->post('propinsi_id')).'%';
        }
        if(!empty($this->input->post('periode_id'))){
            $where['periode_id'] = $this->input->post('periode_id');
        }
        if(!empty($this->input->post('sales_id'))){
            $where['sales_id'] = $this->input->post('sales_id');
        }

        $this->where($where);
        $result['total_rows'] = $this->count_rows();
        
        $this->where($where);
        $this->order_by( $dataorder[$order[0]["column"]],  $order[0]["dir"]);
        $this->limit($start, $limit);
        $result['get_db']=$this
                            ->with_m_periode()
                            ->with_m_sales()
                            ->get_all();
        return $result;
    }

}

/* End of file M_customer_model.php */
/* Location: ./application/models/M_customer_model.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */