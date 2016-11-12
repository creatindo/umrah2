<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_document extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('T_document_model');
        $this->load->library('form_validation');
		$this->load->model('M_customer_model');
		$this->load->model('M_dokument_model');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','t_document/v_t_document_list', $data);
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
        
        $t              = $this->T_document_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->id.'">';
                $view    = anchor(site_url('t_document/read/'.$d->id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('t_document/form/'.$d->id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('t_document/delete/'.$d->id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->T_document_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					@$d->m_dokument->{$this->M_dokument_model->label}, 
					@$d->m_customer->{$this->M_customer_model->label}, 
					$d->quantity, 
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
        $row = $this->T_document_model
                    ->with_m_customer()
                    ->with_m_dokument()
                    ->get($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'document_id' => @$row->m_dokument->{$this->M_dokument_model->label},
				'customer_id' => @$row->m_customer->{$this->M_customer_model->label},
				'quantity' => $row->quantity,
			);
            $data['id'] = $id;
            $this->template->load('template','t_document/v_t_document_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t_document'));
        }
    }


    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('t_document/form_action'),
				'id' => '',
				'document_id' => '',
				'customer_id' => '',
				'quantity' => '',
			);
        }else{
            $row = $this->T_document_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('t_document/form_action'),
                    'id'     => $id,
					'document_id' => $row->document_id,
					'customer_id' => $row->customer_id,
					'quantity' => $row->quantity,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','t_document/v_t_document_form', $data);
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
				'document_id' => $this->input->post('document_id',TRUE),
				'customer_id' => $this->input->post('customer_id',TRUE),
				'quantity' => $this->input->post('quantity',TRUE),
		    );
            if (empty($this->input->post('id', TRUE))) {
                $this->T_document_model->insert($data);
            }else{
                $this->T_document_model->update($data,$this->input->post('id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->T_document_model->get($id);

        if ($row) {
            $this->T_document_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t_document'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t_document'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->T_document_model->get($id);

            if ($row) {
                $this->T_document_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('document_id', 'document id', 'trim|numeric');
		$this->form_validation->set_rules('customer_id', 'customer id', 'trim|numeric');
		$this->form_validation->set_rules('quantity', 'quantity', 'trim|numeric');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_document.xls";
        $judul = "t_document";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Document Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Customer Id");
		xlsWriteLabel($tablehead, $kolomhead++, "Quantity");

		foreach ($this->T_document_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteNumber($tablebody, $kolombody++, $data->document_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->customer_id);
		    xlsWriteNumber($tablebody, $kolombody++, $data->quantity);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function cek($id=null) 
    {
        $data['cust'] = $this->M_customer_model->get($id);
        $data['tdoc'] = $this->M_dokument_model->get_all();
        $this->template->load('template','t_document/v_t_document_form2', $data);
    }

    public function cek_action()
    {
        $customer_id = $this->input->post('customer_id');
        $dok         = $this->input->post('dok');
        foreach ($dok as $key => $value) {
            $data = array('document_id' => $key, 'customer_id' => $customer_id);
            if ($this->T_document_model->get($data)) {
            } else {
                $this->T_document_model->insert($data);
            }
        }
        $res['success'] = true;
        $res['message'] = 'Simpan berhasil';

        $this->output->set_content_type('application/json')->set_output(json_encode($res));

    }


}

/* End of file T_document.php */
/* Location: ./application/controllers/T_document.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */