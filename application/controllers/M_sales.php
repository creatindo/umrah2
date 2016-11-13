<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_sales extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_sales_model');
        $this->load->library('form_validation');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','m_sales/v_m_sales_list', $data);
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
        
        $t              = $this->M_sales_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->sales_id.'">';
                $view    = anchor(site_url('m_sales/read/'.$d->sales_id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('m_sales/form/'.$d->sales_id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('m_sales/delete/'.$d->sales_id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->M_sales_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->sales_name, 
					$d->sales_telp, 
					$d->sales_address, 
					'<img style="width: 100px; height: 100px;" src="'. base_url("uploads/temp/".$d->sales_img).'" onerror="this.src=\''.base_url("assets/global/img/noimage.png").'\'"  alt="Image">' , 
					$d->sales_mail, 
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
        $row = $this->M_sales_model
                    ->get($id);
        if ($row) {
            $data = array(
				'sales_id' => $row->sales_id,
				'sales_name' => $row->sales_name,
				'sales_telp' => $row->sales_telp,
				'sales_address' => $row->sales_address,
				'sales_img' => $row->sales_img,
				'sales_mail' => $row->sales_mail,
			);
            $data['id'] = $id;
            $this->template->load('template','m_sales/v_m_sales_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_sales'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('m_sales/form_action'),
				'sales_id' => '',
				'sales_name' => '',
				'sales_telp' => '',
				'sales_address' => '',
				'sales_img' => '',
				'sales_mail' => '',
			);
        }else{
            $row = $this->M_sales_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('m_sales/form_action'),
                    'sales_id'     => $id,
					'sales_name' => $row->sales_name,
					'sales_telp' => $row->sales_telp,
					'sales_address' => $row->sales_address,
					'sales_img' => $row->sales_img,
					'sales_mail' => $row->sales_mail,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','m_sales/v_m_sales_form', $data);
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
				'sales_name' => $this->input->post('sales_name',TRUE),
				'sales_telp' => $this->input->post('sales_telp',TRUE),
				'sales_address' => $this->input->post('sales_address',TRUE),
				'sales_img' => $this->input->post('sales_img',TRUE),
				'sales_mail' => $this->input->post('sales_mail',TRUE),
		    );
            if (empty($this->input->post('sales_id', TRUE))) {
                $this->M_sales_model->insert($data);
            }else{
                $this->M_sales_model->update($data,$this->input->post('sales_id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->M_sales_model->get($id);

        if ($row) {
            $this->M_sales_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('m_sales'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_sales'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->M_sales_model->get($id);

            if ($row) {
                $this->M_sales_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('sales_name', 'sales name', 'trim');
		$this->form_validation->set_rules('sales_telp', 'sales telp', 'trim');
		$this->form_validation->set_rules('sales_address', 'sales address', 'trim');
		$this->form_validation->set_rules('sales_img', 'sales img', 'trim');
		$this->form_validation->set_rules('sales_mail', 'sales mail', 'trim');

		$this->form_validation->set_rules('sales_id', 'sales_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "m_sales.xls";
        $judul = "m_sales";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Telp");
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Address");
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Img");
		xlsWriteLabel($tablehead, $kolomhead++, "Sales Mail");

		foreach ($this->M_sales_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->sales_name);
		    xlsWriteLabel($tablebody, $kolombody++, $data->sales_telp);
		    xlsWriteLabel($tablebody, $kolombody++, $data->sales_address);
		    xlsWriteLabel($tablebody, $kolombody++, $data->sales_img);
		    xlsWriteLabel($tablebody, $kolombody++, $data->sales_mail);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file M_sales.php */
/* Location: ./application/controllers/M_sales.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */