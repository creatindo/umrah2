<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_periode extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_periode_model');
        $this->load->library('form_validation');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','m_periode/v_m_periode_list', $data);
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
        
        $t              = $this->M_periode_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->id.'">';
                $view    = anchor(site_url('m_periode/read/'.$d->id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('m_periode/form/'.$d->id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('m_periode/delete/'.$d->id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->M_periode_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->name, 
					$d->depart_date, 
					$d->arrival_date, 
					$d->quantity, 
					$d->keterangan, 
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
        $row = $this->M_periode_model
                    ->get($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'name' => $row->name,
				'depart_date' => $row->depart_date,
				'arrival_date' => $row->arrival_date,
				'quantity' => $row->quantity,
				'keterangan' => $row->keterangan,
			);
            $data['id'] = $id;
            $this->template->load('template','m_periode/v_m_periode_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_periode'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('m_periode/form_action'),
				'id' => '',
				'name' => '',
				'depart_date' => '',
				'arrival_date' => '',
				'quantity' => '',
				'keterangan' => '',
			);
        }else{
            $row = $this->M_periode_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('m_periode/form_action'),
                    'id'     => $id,
					'name' => $row->name,
					'depart_date' => $row->depart_date,
					'arrival_date' => $row->arrival_date,
					'quantity' => $row->quantity,
					'keterangan' => $row->keterangan,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','m_periode/v_m_periode_form', $data);
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
				'name' => $this->input->post('name',TRUE),
				'depart_date' => $this->input->post('depart_date',TRUE),
				'arrival_date' => $this->input->post('arrival_date',TRUE),
				'quantity' => $this->input->post('quantity',TRUE),
				'keterangan' => $this->input->post('keterangan',TRUE),
		    );
            if (empty($this->input->post('id', TRUE))) {
                $this->M_periode_model->insert($data);
            }else{
                $this->M_periode_model->update($data,$this->input->post('id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->M_periode_model->get($id);

        if ($row) {
            $this->M_periode_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('m_periode'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('m_periode'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->M_periode_model->get($id);

            if ($row) {
                $this->M_periode_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('name', 'name', 'trim');
		$this->form_validation->set_rules('depart_date', 'depart date', 'trim');
		$this->form_validation->set_rules('arrival_date', 'arrival date', 'trim');
		$this->form_validation->set_rules('quantity', 'quantity', 'trim|numeric');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "m_periode.xls";
        $judul = "m_periode";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Depart Date");
		xlsWriteLabel($tablehead, $kolomhead++, "Arrival Date");
		xlsWriteLabel($tablehead, $kolomhead++, "Quantity");
		xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

		foreach ($this->M_periode_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->name);
		    xlsWriteLabel($tablebody, $kolombody++, $data->depart_date);
		    xlsWriteLabel($tablebody, $kolombody++, $data->arrival_date);
		    xlsWriteNumber($tablebody, $kolombody++, $data->quantity);
		    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file M_periode.php */
/* Location: ./application/controllers/M_periode.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */