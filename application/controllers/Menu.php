<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('form_validation');        
    }

    public function index()
    {
        $data = array(
        );

        $this->template->load('template','menu/v_menu_list', $data);
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
        
        $t              = $this->Menu_model->get_limit_data($iDisplayStart, $iDisplayLength);
        $iTotalRecords  = $t['total_rows'];
        $get_data       = $t['get_db'];

        $records["data"] = array(); 

        $i=$iDisplayStart+1;
        if ($get_data) {
            foreach ($get_data as $d) {
                $checkbok= '<input type="checkbox" name="id[]" value="'.$d->id.'">';
                $view    = anchor(site_url('menu/read/'.$d->id),'<i class="fa fa-eye fa-lg"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                $edit    = anchor(site_url('menu/form/'.$d->id),'<i class="fa fa-pencil-square-o fa-lg"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                $delete  = anchor(site_url('menu/delete/'.$d->id),'<i class="fa fa-trash-o fa-lg"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>$d->{$this->Menu_model->label}));

                $records["data"][] = array(
                    $checkbok,
                
					$d->menu_nama, 
					$d->link, 
					$d->icon, 
					$d->order, 
					$d->is_active, 
					$d->is_parent, 
					$d->controller, 
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
        $row = $this->Menu_model
                    ->get($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'menu_nama' => $row->menu_nama,
				'link' => $row->link,
				'icon' => $row->icon,
				'order' => $row->order,
				'is_active' => $row->is_active,
				'is_parent' => $row->is_parent,
				'controller' => $row->controller,
			);
            $data['id'] = $id;
            $this->template->load('template','menu/v_menu_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function form($id=null) 
    {
        if (empty($id)) {
            $data = array(
                'button' => 'Create',
                'action' => site_url('menu/form_action'),
				'id' => '',
				'menu_nama' => '',
				'link' => '',
				'icon' => '',
				'order' => '',
				'is_active' => '',
				'is_parent' => '',
				'controller' => '',
			);
        }else{
            $row = $this->Menu_model->get($id);

            if ($row) {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url('menu/form_action'),
                    'id'     => $id,
					'menu_nama' => $row->menu_nama,
					'link' => $row->link,
					'icon' => $row->icon,
					'order' => $row->order,
					'is_active' => $row->is_active,
					'is_parent' => $row->is_parent,
					'controller' => $row->controller,
				);
                  
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        $this->template->load('template','menu/v_menu_form', $data);
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
				'menu_nama' => $this->input->post('menu_nama',TRUE),
				'link' => $this->input->post('link',TRUE),
				'icon' => $this->input->post('icon',TRUE),
				'order' => $this->input->post('order',TRUE),
				'is_active' => $this->input->post('is_active',TRUE),
				'is_parent' => $this->input->post('is_parent',TRUE),
				'controller' => $this->input->post('controller',TRUE),
		    );
            if (empty($this->input->post('id', TRUE))) {
                $this->Menu_model->insert($data);
            }else{
                $this->Menu_model->update($data,$this->input->post('id', TRUE));
            }
            $res['success'] = true;
            $res['message'] = 'Simpan berhasil';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    
    public function delete($id) 
    {
        $row = $this->Menu_model->get($id);

        if ($row) {
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function delete_checked()
    {
        $id_array=$this->input->post('id[]');
        foreach ($id_array as $id) {
            $row = $this->Menu_model->get($id);

            if ($row) {
                $this->Menu_model->delete($id);
            } 
        }
        $result["customActionStatus"]="OK";
        $result["customActionMessage"]="Delete Record Success";
        return $result;
    }

    public function _rules() 
    {
		$this->form_validation->set_rules('menu_nama', 'menu nama', 'trim|required');
		$this->form_validation->set_rules('link', 'link', 'trim|required');
		$this->form_validation->set_rules('icon', 'icon', 'trim|required');
		$this->form_validation->set_rules('order', 'order', 'trim|numeric');
		$this->form_validation->set_rules('is_active', 'is active', 'trim|required|numeric');
		$this->form_validation->set_rules('is_parent', 'is parent', 'trim|required|numeric');
		$this->form_validation->set_rules('controller', 'controller', 'trim');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "menu.xls";
        $judul = "menu";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Menu Nama");
		xlsWriteLabel($tablehead, $kolomhead++, "Link");
		xlsWriteLabel($tablehead, $kolomhead++, "Icon");
		xlsWriteLabel($tablehead, $kolomhead++, "Order");
		xlsWriteLabel($tablehead, $kolomhead++, "Is Active");
		xlsWriteLabel($tablehead, $kolomhead++, "Is Parent");
		xlsWriteLabel($tablehead, $kolomhead++, "Controller");

		foreach ($this->Menu_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->menu_nama);
		    xlsWriteLabel($tablebody, $kolombody++, $data->link);
		    xlsWriteLabel($tablebody, $kolombody++, $data->icon);
		    xlsWriteNumber($tablebody, $kolombody++, $data->order);
		    xlsWriteNumber($tablebody, $kolombody++, $data->is_active);
		    xlsWriteNumber($tablebody, $kolombody++, $data->is_parent);
		    xlsWriteLabel($tablebody, $kolombody++, $data->controller);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
/* Please DO NOT modify this information : */
/* http://harviacode.com */