<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_customer extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_customer_model');
        $this->load->library('form_validation');
		$this->load->model('M_periode_model');
		$this->load->model('M_sales_model');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','m_customer/v_m_customer_list', $data);
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
        
        $t              = $this->M_customer_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->customer_id.'">';
                $view    = anchor(site_url('m_customer/read/'.$d->customer_id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('m_customer/form/'.$d->customer_id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('m_customer/delete/'.$d->customer_id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->M_customer_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->customer_name, 
					$d->customer_address, 
					$d->mother_name, 
					$d->customer_birth_place, 
					$d->customer_birth_date, 
					$d->customer_gender, 
					$d->customer_jobs, 
					$d->customer_passport_no, 
					$d->customer_passport_date, 
					'<img style="width: 100px; height: 100px;" src="'. base_url("uploads/temp/".$d->customer_img).'" onerror="this.src=\''.base_url("assets/global/img/noimage.png").'\'"  alt="Image">' , 
					$d->kota_id, 
					$d->kecamatan_id, 
					$d->propinsi_id, 
					@$d->m_periode->{$this->M_periode_model->label}, 
					@$d->m_sales->{$this->M_sales_model->label}, 
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
        $row = $this->M_customer_model
                    ->with_m_periode()
                    ->with_m_sales()
                    ->get($id);
        if ($row) {
            $data = array(
				'customer_id' => $row->customer_id,
				'customer_name' => $row->customer_name,
				'customer_address' => $row->customer_address,
				'mother_name' => $row->mother_name,
				'customer_birth_place' => $row->customer_birth_place,
				'customer_birth_date' => $row->customer_birth_date,
				'customer_gender' => $row->customer_gender,
				'customer_jobs' => $row->customer_jobs,
				'customer_passport_no' => $row->customer_passport_no,
				'customer_passport_date' => $row->customer_passport_date,
				'customer_img' => $row->customer_img,
				'kota_id' => $row->kota_id,
				'kecamatan_id' => $row->kecamatan_id,
				'propinsi_id' => $row->propinsi_id,
				'periode_id' => @$row->m_periode->{$this->M_periode_model->label},
				'sales_id' => @$row->m_sales->{$this->M_sales_model->label},
			);
            $data['id'] = $id;
            $this->template->load('template','m_customer/v_m_customer_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_customer'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('m_customer/form_action'),
				'customer_id' => '',
				'customer_name' => '',
				'customer_address' => '',
				'mother_name' => '',
				'customer_birth_place' => '',
				'customer_birth_date' => '',
				'customer_gender' => '',
				'customer_jobs' => '',
				'customer_passport_no' => '',
				'customer_passport_date' => '',
				'customer_img' => '',
				'kota_id' => '',
				'kecamatan_id' => '',
				'propinsi_id' => '',
				'periode_id' => '',
				'sales_id' => '',
			);
        }else{
            $row = $this->M_customer_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('m_customer/form_action'),
                    'id'     => $id,
					'customer_name' => $row->customer_name,
					'customer_address' => $row->customer_address,
					'mother_name' => $row->mother_name,
					'customer_birth_place' => $row->customer_birth_place,
					'customer_birth_date' => $row->customer_birth_date,
					'customer_gender' => $row->customer_gender,
					'customer_jobs' => $row->customer_jobs,
					'customer_passport_no' => $row->customer_passport_no,
					'customer_passport_date' => $row->customer_passport_date,
					'customer_img' => $row->customer_img,
					'kota_id' => $row->kota_id,
					'kecamatan_id' => $row->kecamatan_id,
					'propinsi_id' => $row->propinsi_id,
					'periode_id' => $row->periode_id,
					'sales_id' => $row->sales_id,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','m_customer/v_m_customer_form', $data);
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
				'customer_name' => $this->input->post('customer_name',TRUE),
				'customer_address' => $this->input->post('customer_address',TRUE),
				'mother_name' => $this->input->post('mother_name',TRUE),
				'customer_birth_place' => $this->input->post('customer_birth_place',TRUE),
				'customer_birth_date' => $this->input->post('customer_birth_date',TRUE),
				'customer_gender' => $this->input->post('customer_gender',TRUE),
				'customer_jobs' => $this->input->post('customer_jobs',TRUE),
				'customer_passport_no' => $this->input->post('customer_passport_no',TRUE),
				'customer_passport_date' => $this->input->post('customer_passport_date',TRUE),
				'customer_img' => $this->input->post('customer_img',TRUE),
				'kota_id' => $this->input->post('kota_id',TRUE),
				'kecamatan_id' => $this->input->post('kecamatan_id',TRUE),
				'propinsi_id' => $this->input->post('propinsi_id',TRUE),
				'periode_id' => $this->input->post('periode_id',TRUE),
				'sales_id' => $this->input->post('sales_id',TRUE),
		    );
            if (empty($this->input->post('customer_id', TRUE))) {
                $this->M_customer_model->insert($data);
            }else{
                $this->M_customer_model->update($data,$this->input->post('customer_id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->M_customer_model->get($id);

        if ($row) {
            $this->M_customer_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('m_customer'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_customer'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->M_customer_model->get($id);

            if ($row) {
                $this->M_customer_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('customer_name', 'customer name', 'trim');
		$this->form_validation->set_rules('customer_address', 'customer address', 'trim');
		$this->form_validation->set_rules('mother_name', 'mother name', 'trim');
		$this->form_validation->set_rules('customer_birth_place', 'customer birth place', 'trim');
		$this->form_validation->set_rules('customer_birth_date', 'customer birth date', 'trim');
		$this->form_validation->set_rules('customer_gender', 'customer gender', 'trim');
		$this->form_validation->set_rules('customer_jobs', 'customer jobs', 'trim');
		$this->form_validation->set_rules('customer_passport_no', 'customer passport no', 'trim');
		$this->form_validation->set_rules('customer_passport_date', 'customer passport date', 'trim');
		$this->form_validation->set_rules('customer_img', 'customer img', 'trim');
		$this->form_validation->set_rules('kota_id', 'kota id', 'trim|numeric');
		$this->form_validation->set_rules('kecamatan_id', 'kecamatan id', 'trim|numeric');
		$this->form_validation->set_rules('propinsi_id', 'propinsi id', 'trim|numeric');
		$this->form_validation->set_rules('periode_id', 'periode id', 'trim|numeric');
		$this->form_validation->set_rules('sales_id', 'sales id', 'trim|numeric');

		$this->form_validation->set_rules('customer_id', 'customer_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "m_customer.xls";
        $judul = "m_customer";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Address");
		xlsWriteLabel($tablehead, $kolomhead++, "Mother Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Birth Place");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Birth Date");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Gender");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Jobs");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Passport No");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Passport Date");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Img");
		xlsWriteLabel($tablehead, $kolomhead++, "Kota Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Kecamatan Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Propinsi Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Periode Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Id");

		foreach ($this->M_customer_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_name);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_address);
		    xlsWriteLabel($tablebody, $kolombody++, $data->mother_name);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_birth_place);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_birth_date);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_gender);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_jobs);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_passport_no);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_passport_date);
		    xlsWriteLabel($tablebody, $kolombody++, $data->customer_img);
		    xlsWriteNumber($tablebody, $kolombody++, $data->kota_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->kecamatan_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->propinsi_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->periode_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->sales_id);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file M_customer.php */
/* Location: ./application/controllers/M_customer.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */