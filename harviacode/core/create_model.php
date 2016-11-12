<?php 

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $m . " extends MY_Model
{

    public \$table = '$table_name';
    public \$primary_key = '$pk';
    public \$label = '$label';
    public \$fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public \$protected = array('$pk'); // ...Or you can set an array with the fields that cannot be filled by insert/update

    function __construct()
    {
        parent::__construct();
        \$this->soft_deletes = TRUE;";
foreach ($reference as $row) {
    $string .= "
        \$this->has_one['". $row['r_table'] ."'] = array('". ucfirst($row['r_model']) ."','".$row['r_column']."','".$row['column_name']."');";
}
$string .="
    }
    
    // get total rows
    function get_limit_data(\$limit, \$start) {
        \$order            = \$this->input->post('order');
        \$dataorder = array();
        \$where = array();

        \$i=1;";
foreach ($non_pk as $row) {
    $string .= "
        \$dataorder[\$i++] = '". $row['column_name'] ."';";
}
foreach ($non_pk as $row) {
    if ($row["data_type"] == 'numeric') {
        $string .= "
        if(!empty(\$this->input->post('" . $row['column_name'] ."_start'))){
            \$where['" . $row['column_name'] ." >='] = \$this->input->post('" . $row['column_name'] ."_start');
        }
        if(!empty(\$this->input->post('" . $row['column_name'] ."_end'))){
            \$where['" . $row['column_name'] ." <='] = \$this->input->post('" . $row['column_name'] ."_end');
        }";
    }else if ($row["data_type"] == 'date' || $row["data_type"] == 'year' ) {
        $string .= "
        if(!empty(\$this->input->post('" . $row['column_name'] ."_start'))){
            \$where['" . $row['column_name'] ." >='] = \$this->input->post('" . $row['column_name'] ."_start');
        }
        if(!empty(\$this->input->post('" . $row['column_name'] ."_end'))){
            \$where['" . $row['column_name'] ." <='] = \$this->input->post('" . $row['column_name'] ."_end');
        }";
    }else if ($row['r_table']){
        $string .= "
        if(!empty(\$this->input->post('" . $row['column_name'] ."'))){
            \$where['" . $row['column_name'] ."'] = \$this->input->post('" . $row['column_name'] ."');
        }";
    }else{
        $string .= "
        if(!empty(\$this->input->post('" . $row['column_name'] ."'))){
            \$where['LOWER(" . $row['column_name'] .") LIKE'] = '%'.strtolower(\$this->input->post('" . $row['column_name'] ."')).'%';
        }";
    }
}    

$string .= "

        \$this->where(\$where);
        \$result['total_rows'] = \$this->count_rows();
        
        \$this->where(\$where);
        \$this->order_by( \$dataorder[\$order[0][\"column\"]],  \$order[0][\"dir\"]);
        \$this->limit(\$start, \$limit);
        \$result['get_db']=\$this";
foreach ($reference as $row) {
    $string .= "
                            ->with_".$row['r_table']."()";
}
$string.="
                            ->get_all();
        return \$result;
    }

}

/* End of file $m_file */
/* Location: ./application/models/$m_file */
/* Please DO NOT modify this information : */
/* http://harviacode.com */";




$hasil_model = createFile($string, $target."models/" . $m_file);

?>