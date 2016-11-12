<?php

$hasil = array();

if (isset($_POST['generate']))
{
    // get form data
    $table_name = safe($_POST['table_name']);
    $jenis_tabel = safe($_POST['jenis_tabel']);
    $export_excel = safe($_POST['export_excel']);
    $export_word = safe($_POST['export_word']);
    $export_pdf = safe($_POST['export_pdf']);
    $controller = safe($_POST['controller']);
    $model = safe($_POST['model']);

    if ($table_name <> '')
    {
        // set data 1
        $table_name = $table_name;
        $c = $controller <> '' ? ucfirst($controller) : ucfirst($table_name);

        // url
        $c_url = strtolower($c);

        // set data 2
        $m = $model <> '' ? ucfirst($model) : ucfirst($table_name) . "_model";
        $v_list = "v_". $c_url . "_list";
        $v_read = "v_". $c_url . "_read";
        $v_form = "v_". $c_url . "_form";
        $v_doc = "v_". $c_url . "_doc";
        $v_pdf = "v_". $c_url . "_pdf";
        
        
        // filename
        $c_file = $c.'.php';
        $m_file = $m.'.php';
        $v_list_file = $v_list.'.php';
        $v_read_file = $v_read.'.php';
        $v_form_file = $v_form.'.php';
        $v_doc_file = $v_doc.'.php';
        $v_pdf_file = $v_pdf.'.php';
        
        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
        $target_view = $target."views/".$c_url."/";
        
        $pk        = $hc->primary_field($table_name);
        $non_pk    = $hc->not_primary_field($table_name);
        $all       = $hc->all_field($table_name);
        $reference = $hc->reference_field($table_name);
        
        $non_pk    = $hc->with_reference($non_pk,$reference);
        $all       = $hc->with_reference($all,$reference);
        
        // create view direktory
        mkdir($target_view);

        //find label
        $label = $pk;
        foreach ($non_pk as $row) {
            if (strpos($row['column_name'], '_nama') !== false || strpos($row['column_name'], '_name') !== false) {
                $label = $row['column_name'];
                break;
            }
        }
        if($label == $pk){
            foreach ($non_pk as $row) {
                if ($row["data_type"] == 'varchar') {
                    $label = $row['column_name'];
                    break;
                }
            }
        }
        
        // generate
        include 'core/create_config_pagination.php';
        include 'core/create_controller.php';
        include 'core/create_model.php';
        $jenis_tabel == 'reguler_table' ? include 'core/create_view_list.php' : include 'core/create_view_list_datatables.php';       
        include 'core/create_view_form_ajax.php';
        include 'core/create_view_read.php';
        
        $export_excel == 1 ? include 'core/create_exportexcel_helper.php' : '';
        $export_word == 1 ? include 'core/create_view_list_doc.php' : '';
        $export_pdf == 1 ? include 'core/create_pdf_library.php' : '';
        $export_pdf == 1 ? include 'core/create_view_list_pdf.php' : '';
        
        $hasil[] = $hasil_controller;
        $hasil[] = $hasil_model;
        $hasil[] = $hasil_view_list;
        $hasil[] = $hasil_view_form;
        $hasil[] = $hasil_view_read;
        $hasil[] = $hasil_view_doc;
        $hasil[] = $hasil_view_pdf;
        $hasil[] = $hasil_config_pagination;
        $hasil[] = $hasil_exportexcel;
        $hasil[] = $hasil_pdf;

    }
    else
    {
        $hasil[] = 'No table selected.';
    }
} 

if (isset($_POST['generateall'])) {
    
    $jenis_tabel = safe($_POST['jenis_tabel']);
    $export_excel = safe($_POST['export_excel']);
    $export_word = safe($_POST['export_word']);
    $export_pdf = safe($_POST['export_pdf']);

    $table_list = $hc->table_list();
    foreach ($table_list as $row) {
        
        $table_name = $row['table_name'];
        $c = ucfirst($table_name);
        $m = ucfirst($table_name) . '_model';
        $v_list = "v_" . $table_name . "_list";
        $v_read = "v_" . $table_name . "_read";
        $v_form = "v_" . $table_name . "_form";
        $v_doc = "v_" . $table_name . "_doc";
        $v_pdf = "v_" . $table_name . "_pdf";
        
        // url
        $c_url = strtolower($c);
        
        // filename
        $c_file = $c.'.php';
        $m_file = $m.'.php';
        $v_list_file = $v_list.'.php';
        $v_read_file = $v_read.'.php';
        $v_form_file = $v_form.'.php';
        $v_doc_file = $v_doc.'.php';
        $v_pdf_file = $v_pdf.'.php';
        
        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
        $target_view = $target."views/".$c_url."/";
        
        // create view direktory
        mkdir($target_view);
        
        $pk        = $hc->primary_field($table_name);
        $non_pk    = $hc->not_primary_field($table_name);
        $all       = $hc->all_field($table_name);
        $reference = $hc->reference_field($table_name);
        
        $non_pk    = $hc->with_reference($non_pk,$reference);
        $all       = $hc->with_reference($all,$reference);
        
        //find label
        $label = $pk;
        foreach ($non_pk as $row) {
            if (strpos($row['column_name'], '_nama') !== false || strpos($row['column_name'], '_name') !== false ) {
                $label = $row['column_name'];
                break;
            }
        }


        // generate
        include 'core/create_config_pagination.php';
        include 'core/create_controller.php';
        include 'core/create_model.php';
        $jenis_tabel == 'reguler_table' ? include 'core/create_view_list.php' : include 'core/create_view_list_datatables.php';       
        include 'core/create_view_form_ajax.php';
        include 'core/create_view_read.php';
        
        $export_excel == 1 ? include 'core/create_exportexcel_helper.php' : '';
        $export_word == 1 ? include 'core/create_view_list_doc.php' : '';
        $export_pdf == 1 ? include 'core/create_pdf_library.php' : '';
        $export_pdf == 1 ? include 'core/create_view_list_pdf.php' : '';
        
        $hasil[] = $hasil_controller;
        $hasil[] = $hasil_model;
        $hasil[] = $hasil_view_list;
        $hasil[] = $hasil_view_form;
        $hasil[] = $hasil_view_read;
        $hasil[] = $hasil_view_doc;

    }
    
    $hasil[] = $hasil_config_pagination;
    $hasil[] = $hasil_exportexcel;
    $hasil[] = $hasil_pdf;
}
?>