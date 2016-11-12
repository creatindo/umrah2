<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','user/v_user_list', $data);
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
        
        $t              = $this->User_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->ID_USER.'">';
                $view    = anchor(site_url('user/read/'.$d->ID_USER),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('user/form/'.$d->ID_USER),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('user/delete/'.$d->ID_USER),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->User_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->ID_PRIVILLAGE, 
					$d->USERNAME, 
					$d->PASSWORD, 
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
        $row = $this->User_model
                    ->get($id);
        if ($row) {
            $data = array(
				'ID_USER' => $row->ID_USER,
				'ID_PRIVILLAGE' => $row->ID_PRIVILLAGE,
				'USERNAME' => $row->USERNAME,
				'PASSWORD' => $row->PASSWORD,
			);
            $data['id'] = $id;
            $this->template->load('template','user/v_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('user/form_action'),
				'ID_USER' => '',
				'ID_PRIVILLAGE' => '',
				'USERNAME' => '',
				'PASSWORD' => '',
			);
        }else{
            $row = $this->User_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('user/form_action'),
                    'id'     => $id,
					'ID_PRIVILLAGE' => $row->ID_PRIVILLAGE,
					'USERNAME' => $row->USERNAME,
					'PASSWORD' => $row->PASSWORD,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','user/v_user_form', $data);
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
				'ID_PRIVILLAGE' => $this->input->post('ID_PRIVILLAGE',TRUE),
				'USERNAME' => $this->input->post('USERNAME',TRUE),
				'PASSWORD' => $this->input->post('PASSWORD',TRUE),
		    );
            if (empty($this->input->post('ID_USER', TRUE))) {
                $this->User_model->insert($data);
            }else{
                $this->User_model->update($data,$this->input->post('ID_USER', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get($id);

        if ($row) {
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->User_model->get($id);

            if ($row) {
                $this->User_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('ID_PRIVILLAGE', 'id privillage', 'trim|numeric');
		$this->form_validation->set_rules('USERNAME', 'username', 'trim');
		$this->form_validation->set_rules('PASSWORD', 'password', 'trim');

		$this->form_validation->set_rules('ID_USER', 'ID_USER', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "user.xls";
        $judul = "user";
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
		xlsWriteLabel($tablehead, $kolomhead++, "ID PRIVILLAGE");
		xlsWriteLabel($tablehead, $kolomhead++, "USERNAME");
		xlsWriteLabel($tablehead, $kolomhead++, "PASSWORD");

		foreach ($this->User_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteNumber($tablebody, $kolombody++, $data->ID_PRIVILLAGE);
		    xlsWriteLabel($tablebody, $kolombody++, $data->USERNAME);
		    xlsWriteLabel($tablebody, $kolombody++, $data->PASSWORD);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */