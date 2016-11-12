<?php

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $c . " extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        \$this->load->model('$m');
        \$this->load->library('form_validation');";
foreach ($reference as $refer) {
$string .="\n\t\t\$this->load->model('".$refer["r_model"]."');";    
}        
$string .="        
    }";

if ($jenis_tabel == 'reguler_table') {
    
$string .= "\n\n    public function index()
    {
        \$q = urldecode(\$this->input->get('q', TRUE));
        \$start = intval(\$this->input->get('start'));
        
        if (\$q <> '') {
            \$config['base_url'] = base_url() . '$c_url/index.html?q=' . urlencode(\$q);
            \$config['first_url'] = base_url() . '$c_url/index.html?q=' . urlencode(\$q);
        } else {
            \$config['base_url'] = base_url() . '$c_url/index.html';
            \$config['first_url'] = base_url() . '$c_url/index.html';
        }

        \$config['per_page'] = 10;
        \$config['page_query_string'] = TRUE;
        \$config['total_rows'] = \$this->" . $m . "->total_rows(\$q);
        \$$c_url = \$this->" . $m . "->get_limit_data(\$config['per_page'], \$start, \$q);

        \$this->load->library('pagination');
        \$this->pagination->initialize(\$config);

        \$data = array(
            '" . $c_url . "_data' => \$$c_url,
            'q' => \$q,
            'pagination' => \$this->pagination->create_links(),
            'total_rows' => \$config['total_rows'],
            'start' => \$start,
        );
        \$this->template->load('template','$c_url/$v_list', \$data);
    }";

} else {
    
$string .="\n\n    public function index()
    {
        \$data = array(
        );

        \$this->template->load('template','$c_url/$v_list', \$data);
    }";

}
$string .="\n\n    public function getDatatable()
    {
        \$customActionName=\$this->input->post('customActionName');
        \$records         = array();

        if (\$customActionName == \"delete\") {
            \$records=\$this-> delete_checked();
        }

        \$iDisplayLength = intval(\$_REQUEST['length']);
        \$iDisplayStart  = intval(\$_REQUEST['start']);
        \$sEcho          = intval(\$_REQUEST['draw']);
        
        \$t              = \$this->" . $m . "->get_limit_data(\$iDisplayStart, \$iDisplayLength);
        \$iTotalRecords  = \$t['total_rows'];
        \$get_data       = \$t['get_db'];

        \$records[\"data\"] = array(); 

        \$i=\$iDisplayStart+1;
        if (\$get_data) {
            foreach (\$get_data as \$d) {
                \$checkbok= '<input type=\"checkbox\" name=\"id[]\" value=\"'.\$d->".$pk.".'\">';
                \$view    = anchor(site_url('".$c_url."/read/'.\$d->".$pk."),'<i class=\"fa fa-eye fa-lg\"></i>',array('title'=>'detail','class'=>'btn btn-outline btn-icon-only green'));
                \$edit    = anchor(site_url('".$c_url."/form/'.\$d->".$pk."),'<i class=\"fa fa-pencil-square-o fa-lg\"></i>',array('title'=>'edit','class'=>'btn btn-outline btn-icon-only blue'));
                \$delete  = anchor(site_url('".$c_url."/delete/'.\$d->".$pk."),'<i class=\"fa fa-trash-o fa-lg\"></i>',array('title'=>'delete','class'=>'btn btn-outline btn-icon-only red', 'data-toggle'=>'confirm', 'data-title'=>\$d->{\$this->".$m."->label}));

                \$records[\"data\"][] = array(
                    \$checkbok,
                ";
                foreach ($non_pk as $row) {
                    if($row['r_table'] ) {
                        $string .= "\n\t\t\t\t\t@\$d->". $row["r_table"] ."->{".$row["r_label"]."}, ";
                    }elseif ($row["img"] ) {
                        $string .= "\n\t\t\t\t\t'<img style=\"width: 100px; height: 100px;\" src=\"'. base_url(\"uploads/temp/\".\$d->" . $row["column_name"] . ").'\" onerror=\"this.src=\''.base_url(\"assets/global/img/noimage.png\").'\'\"  alt=\"Image\">' , ";
                    }else{
                        $string .= "\n\t\t\t\t\t\$d->". $row['column_name'] .", ";
                    }
                }
                $string .= "
                    \$view.\$edit.\$delete
                );
            }
        }
        \$records[\"draw\"] = \$sEcho;
        \$records[\"recordsTotal\"] = \$iTotalRecords;
        \$records[\"recordsFiltered\"] = \$iTotalRecords;

        \$this->output->set_content_type('application/json')->set_output(json_encode(\$records));
    }";
    
$string .= "\n\n    public function read(\$id) 
    {
        \$row = \$this->" . $m ;
foreach ($reference as $row) {
    $string .= "
                    ->with_".$row['r_table']."()";
}
$string.="
                    ->get(\$id);
        if (\$row) {
            \$data = array(";
foreach ($all as $row) {
    if($row['r_table'] ) {
    $string .= "\n\t\t\t\t'" . $row['column_name'] . "' => @\$row->". $row["r_table"] ."->{".$row["r_label"]."},";
    }else{
    $string .= "\n\t\t\t\t'" . $row['column_name'] . "' => \$row->" . $row['column_name'] . ",";
    }
}
$string .= "\n\t\t\t);
            \$data['id'] = \$id;
            \$this->template->load('template','$c_url/$v_read', \$data);
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }

    public function form(\$id=null) 
    {
        if (empty(\$id)) {
            \$data = array(
                'button' => 'Create',
                'action' => site_url('$c_url/form_action'),";
            foreach ($all as $row) {
                $string .= "\n\t\t\t\t'" . $row['column_name'] . "' => '',";
            }
            $string .= "\n\t\t\t);
        }else{
            \$row = \$this->".$m."->get(\$id);

            if (\$row) {
                \$data = array(
                    'button' => 'Update',
                    'action' => site_url('$c_url/form_action'),
                    'id'     => \$id,";
            foreach ($non_pk as $row) {
                $string .= "\n\t\t\t\t\t'" . $row['column_name'] . "' => \$row->". $row['column_name'].",";
            }
            $string .= "\n\t\t\t\t);
                  
            } else {
                \$this->session->set_flashdata('message', 'Record Not Found');
            }
        }
        
        \$this->template->load('template','$c_url/$v_form', \$data);
    }

    public function form_action()
    {
        \$this->_rules();
        \$res['success'] = false;
        \$res['message'] = 'Simpan gagal';
        ";
$string .= "
        if (\$this->form_validation->run() == FALSE) {
            \$res['message'] = 'Lengkapi form dengan benar';
            \$res['field_error'] = \$this->form_validation->error_array();
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "',TRUE),";
}    
$string .= "\n\t\t    );
            if (empty(\$this->input->post('$pk', TRUE))) {
                \$this->".$m."->insert(\$data);
            }else{
                \$this->".$m."->update(\$data,\$this->input->post('$pk', TRUE));
            }
            \$res['success'] = true;
            \$res['message'] = 'Simpan berhasil';
        }
        \$this->output->set_content_type('application/json')->set_output(json_encode(\$res));
    }
    
    public function delete(\$id) 
    {
        \$row = \$this->".$m."->get(\$id);

        if (\$row) {
            \$this->".$m."->delete(\$id);
            \$this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('$c_url'));
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }

    public function delete_checked()
    {
        \$id_array=\$this->input->post('id[]');
        foreach (\$id_array as \$id) {
            \$row = \$this->".$m."->get(\$id);

            if (\$row) {
                \$this->".$m."->delete(\$id);
            } 
        }
        \$result[\"customActionStatus\"]=\"OK\";
        \$result[\"customActionMessage\"]=\"Delete Record Success\";
        return \$result;
    }

    public function _rules() 
    {";
foreach ($non_pk as $row) {
    $int = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
    $required = ($row['is_nullable'] == 'NO') ? '|required' : '' ;
    $validation= (!empty($row['validation'])) ?  '|'.$row['validation'] : '' ;
    $string .= "\n\t\t\$this->form_validation->set_rules('".$row['column_name']."', '".  strtolower(label($row['column_name']))."', 'trim$required$int$validation');";
}    
$string .= "\n\n\t\t\$this->form_validation->set_rules('$pk', '$pk', 'trim');";
$string .= "\n\t\t\$this->form_validation->set_error_delimiters('<span class=\"text-danger\">', '</span>');
    }";

if ($export_excel == '1') {
    $string .= "\n\n    public function excel()
    {
        \$this->load->helper('exportexcel');
        \$namaFile = \"$table_name.xls\";
        \$judul = \"$table_name\";
        \$tablehead = 0;
        \$tablebody = 1;
        \$nourut = 1;
        //penulisan header
        header(\"Pragma: public\");
        header(\"Expires: 0\");
        header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
        header(\"Content-Type: application/force-download\");
        header(\"Content-Type: application/octet-stream\");
        header(\"Content-Type: application/download\");
        header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
        header(\"Content-Transfer-Encoding: binary \");

        xlsBOF();

        \$kolomhead = 0;
        xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
foreach ($non_pk as $row) {
        $column_name = label($row['column_name']);
        $string .= "\n\t\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
}
$string .= "\n\n\t\tforeach (\$this->" . $m . "->get_all() as \$data) {
            \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
foreach ($non_pk as $row) {
        $column_name = $row['column_name'];
        $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
        $string .= "\n\t\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
}
$string .= "\n\n\t\t    \$tablebody++;
            \$nourut++;
        }

        xlsEOF();
        exit();
    }";
}

if ($export_word == '1') {
    $string .= "\n\n    public function word()
    {
        header(\"Content-type: application/vnd.ms-word\");
        header(\"Content-Disposition: attachment;Filename=$c_url.doc\");

        \$data = array(
            '" . $c_url . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        
        \$this->load->view('" . $c_url."/".$v_doc . "',\$data);
    }";
}

if ($export_pdf == '1') {
    $string .= "\n\n    function pdf()
    {
        \$data = array(
            '" . $c_url . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        
        ini_set('memory_limit', '32M');
        \$html = \$this->load->view('" . $c_url."/".$v_pdf . "', \$data, true);
        \$this->load->library('pdf');
        \$pdf = \$this->pdf->load();
        \$pdf->WriteHTML(\$html);
        \$pdf->Output('" . $c_url . ".pdf', 'D'); 
    }";
}

$string .= "\n\n}\n\n/* End of file $c_file */
/* Location: ./application/controllers/$c_file */
/* Please DO NOT modify this information : */
/* http://harviacode.com */";




$hasil_controller = createFile($string, $target . "controllers/" . $c_file);

?>