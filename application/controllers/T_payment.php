<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_payment extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('T_payment_model');
        $this->load->library('form_validation');
		$this->load->model('M_customer_model');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','t_payment/v_t_payment_list', $data);
    }

    public function getDatatable()
    {
        $customActionName=$this->input->post('customActionName');
        $records         = array();

        if ($customActionName == "delete") {
            $records=$this-> delete_checked();
        }

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart  = intval($_REQUEST['start']);
        $sEcho          = intval($_REQUEST['draw']);
        
        $t              = $this->T_payment_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->id.'">';
                $view    = anchor(site_url('t_payment/read/'.$d->id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('t_payment/form/'.$d->id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('t_payment/delete/'.$d->id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->T_payment_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					@$d->m_customer->{$this->M_customer_model->label}, 
					$d->no_transaction, 
					$d->payment_date, 
					$d->payment_value, 
					$d->payment_kurs_dollar, 
                    $view.$edit.$delete
                );
            }
        }
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        $this->output->set_content_type('application/json')->set_output(json_encode($records));
    }

    public function read($id) 
    {
        $row = $this->T_payment_model
                    ->with_m_customer()
                    ->get($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'customer_id' => @$row->m_customer->{$this->M_customer_model->label},
				'no_transaction' => $row->no_transaction,
				'payment_date' => $row->payment_date,
				'payment_value' => $row->payment_value,
				'payment_kurs_dollar' => $row->payment_kurs_dollar,
			);
            $data['id'] = $id;
            $this->template->load('template','t_payment/v_t_payment_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t_payment'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('t_payment/form_action'),
				'id' => '',
				'customer_id' => '',
				'no_transaction' => '',
				'payment_date' => '',
				'payment_value' => '',
				'payment_kurs_dollar' => '',
			);
        }else{
            $row = $this->T_payment_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('t_payment/form_action'),
                    'id'     => $id,
					'customer_id' => $row->customer_id,
					'no_transaction' => $row->no_transaction,
					'payment_date' => $row->payment_date,
					'payment_value' => $row->payment_value,
					'payment_kurs_dollar' => $row->payment_kurs_dollar,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','t_payment/v_t_payment_form', $data);
    }

    public function form_action()
    {
        $this->_rules();
        $res['success'] = false;
        $res['message'] = 'Simpan gagal';
        
        if ($this->form_validation->run() == FALSE) {
            $res['message'] = 'Lengkapi form dengan benar';
            $res['field_error'] = $this->form_validation->error_array();
        } else {
            $data = array(
				'customer_id' => $this->input->post('customer_id',TRUE),
				'no_transaction' => $this->input->post('no_transaction',TRUE),
				'payment_date' => $this->input->post('payment_date',TRUE),
				'payment_value' => $this->input->post('payment_value',TRUE),
				'payment_kurs_dollar' => $this->input->post('payment_kurs_dollar',TRUE),
		    );
            if (empty($this->input->post('id', TRUE))) {
                $this->T_payment_model->insert($data);
            }else{
                $this->T_payment_model->update($data,$this->input->post('id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->T_payment_model->get($id);

        if ($row) {
            $this->T_payment_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t_payment'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t_payment'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->T_payment_model->get($id);

            if ($row) {
                $this->T_payment_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('customer_id', 'customer id', 'trim|numeric');
		$this->form_validation->set_rules('no_transaction', 'no transaction', 'trim');
		$this->form_validation->set_rules('payment_date', 'payment date', 'trim');
		$this->form_validation->set_rules('payment_value', 'payment value', 'trim|numeric');
		$this->form_validation->set_rules('payment_kurs_dollar', 'payment kurs dollar', 'trim|numeric');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_payment.xls";
        $judul = "t_payment";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Id");
		xlsWriteLabel($tablehead, $kolomhead++, "No Transaction");
		xlsWriteLabel($tablehead, $kolomhead++, "Payment Date");
		xlsWriteLabel($tablehead, $kolomhead++, "Payment Value");
		xlsWriteLabel($tablehead, $kolomhead++, "Payment Kurs Dollar");

		foreach ($this->T_payment_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteNumber($tablebody, $kolombody++, $data->customer_id);
		    xlsWriteLabel($tablebody, $kolombody++, $data->no_transaction);
		    xlsWriteLabel($tablebody, $kolombody++, $data->payment_date);
		    xlsWriteNumber($tablebody, $kolombody++, $data->payment_value);
		    xlsWriteNumber($tablebody, $kolombody++, $data->payment_kurs_dollar);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function cek($id=null) 
    {
        $data['cust']    = $this->M_customer_model->get($id);
        $data['payment'] = $this->T_payment_model->_get($id);
        $this->template->load('template','t_payment/v_t_payment_form2', $data);
    }

     public function cek_action()
    {
        $res['success'] = false;
        $res['message'] = 'Terjadi Kesalahan';

        $customer_id   = $this->input->post('customer_id');
        $dok           = $this->input->post('dok');
        $payment_value = $this->input->post('payment_value');

        $data = array(
            'payment_value' => str_replace('.','',$payment_value),
            'customer_id' => $customer_id,
        );

        if ($this->T_payment_model->insert($data))
        {
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($res));

    }

}

/* End of file T_payment.php */
/* Location: ./application/controllers/T_payment.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */