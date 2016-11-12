<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_dokument extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_dokument_model');
        $this->load->library('form_validation');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','m_dokument/v_m_dokument_list', $data);
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
        
        $t              = $this->M_dokument_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->document_id.'">';
                $view    = anchor(site_url('m_dokument/read/'.$d->document_id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('m_dokument/form/'.$d->document_id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('m_dokument/delete/'.$d->document_id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->M_dokument_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->document_name, 
					$d->document_quantity, 
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
        $row = $this->M_dokument_model
                    ->get($id);
        if ($row) {
            $data = array(
				'document_id' => $row->document_id,
				'document_name' => $row->document_name,
				'document_quantity' => $row->document_quantity,
			);
            $data['id'] = $id;
            $this->template->load('template','m_dokument/v_m_dokument_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_dokument'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('m_dokument/form_action'),
				'document_id' => '',
				'document_name' => '',
				'document_quantity' => '',
			);
        }else{
            $row = $this->M_dokument_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('m_dokument/form_action'),
                    'id'     => $id,
					'document_name' => $row->document_name,
					'document_quantity' => $row->document_quantity,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','m_dokument/v_m_dokument_form', $data);
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
				'document_name' => $this->input->post('document_name',TRUE),
				'document_quantity' => $this->input->post('document_quantity',TRUE),
		    );
            if (empty($this->input->post('document_id', TRUE))) {
                $this->M_dokument_model->insert($data);
            }else{
                $this->M_dokument_model->update($data,$this->input->post('document_id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->M_dokument_model->get($id);

        if ($row) {
            $this->M_dokument_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('m_dokument'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_dokument'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->M_dokument_model->get($id);

            if ($row) {
                $this->M_dokument_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('document_name', 'document name', 'trim');
		$this->form_validation->set_rules('document_quantity', 'document quantity', 'trim|numeric');

		$this->form_validation->set_rules('document_id', 'document_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "m_dokument.xls";
        $judul = "m_dokument";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Document Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Document Quantity");

		foreach ($this->M_dokument_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->document_name);
		    xlsWriteNumber($tablebody, $kolombody++, $data->document_quantity);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file M_dokument.php */
/* Location: ./application/controllers/M_dokument.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */