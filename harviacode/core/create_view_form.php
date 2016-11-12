<?php

$string = "
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form ".  label(strtoupper($c))." </span>
          </div>
        </div>
        <div class='portlet-body form'>";
$string .= "
          <form action=\"<?php echo \$action; ?>\" method=\"post\">";
$string .= "
            <div class='form-body'>";
$i=0;
foreach ($non_pk as $row) {
  $i++;
  if ($i % 2 == 1) {
      $string .="
              <div class='row'>";
  } 
  
  if ($row["data_type"] == 'text') {
      $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <textarea class=\"form-control\" rows=\"3\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" placeholder=\"" . label($row["column_name"]) . "\"><?php echo $" . $row["column_name"] . "; ?></textarea>
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  } else if($row['r_table'] ) {
      $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <?php 
                      \$v_name_".$i." = '';
                      if (!empty($".$row["column_name"].")) {                                
                        \$v_name_".$i." = \$this->".$row["r_model"]."->get($" . $row["column_name"] . ")->{".$row["r_label"]."};
                      }
                      \$ddajax = array(
                        'url' => site_url('form/dd/".$row["r_model"]."'), 
                        'name' =>'".$row["column_name"]."',
                        'current_selected_id' => $" . $row["column_name"] . ", 
                        'current_selected_name' => \$v_name_".$i.", 
                        );
                      \$this->load->view('form/v_dropdown_ajax', array('ddajax' => \$ddajax ), FALSE); ?>
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  } else if($row["data_type"] == 'date' || $row["data_type"] == 'year' ){
      if ($row["data_type"] == 'date') {
        $class_date ='date-decade';
      }elseif($row["data_type"] == 'year'){
        $class_date ='date-year';
      }
      
      $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <div class='input-group date ".$class_date."' >
                        <input type='text' class='form-control ' readonly name=\"" . $row["column_name"] . "\" value=\"<?php echo $" . $row["column_name"] . "; ?>\">
                        <span class='input-group-btn'>
                          <button class='btn default' type='button'>
                            <i class='fa fa-calendar'></i>
                          </button>
                        </span>
                      </div>
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  } else if ($row["data_type"] == 'int' ){
      $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <input type=\"text\" class=\"form-control mask-number\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" placeholder=\"" . label($row["column_name"]) . "\" value=\"<?php echo $" . $row["column_name"] . "; ?>\" />
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  } else if($row["img"] ){
        $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'> ". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <input type=\"hidden\" class=\"form-control\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" placeholder=\"" . label($row["column_name"]) . "\" value=\"<?php echo $" . $row["column_name"] . "; ?>\" />
                      <img class=\"btn no-space upload_img_single\" id=\"" . $row["column_name"] . "_preview\" style=\"width: 100px; height: 100px;\" src=\"<?php echo base_url('uploads/temp/'.$" . $row["column_name"] . "); ?>\" onerror=\"this.src='<?php echo base_url(\"assets/global/img/noimage.png\") ?>'\" alt=\"Image\">
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  } else if($row["file"] ){
      $string .= "
              <div class='col-md-6'>
                <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                  <label class='col-md-3 control-label'> ". label($row["f_name"]) . "</label>
                  <div class='col-md-9'>
                    <div>
                      <input type=\"hidden\" class=\"form-control\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" placeholder=\"" . label($row["column_name"]) . "\" value=\"<?php echo $" . $row["column_name"] . "; ?>\" />
                      <button type=\"button\" class=\"btn btn-info\" onclick=\"$(this).next().click()\">Select file</button>
                      <input data-url=\"<?php echo site_url('upload/do_upload_file') ?>\" type=\"file\" id=\"my_file\" style=\"display: none;\" onchange=\"upload_file($(this))\" />
                      <span class=\"upload-filename\"><?php echo $" . $row["column_name"] . "; ?></span>
                      <div class=\"upload-progres\"></div>
                      <span class='help-block'> <?php echo form_error('video_file') ?> </span>
                    </div>
                  </div>
                </div>
              </div>
              ";
  } else {
      $string .= "
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('" . $row["column_name"] . "')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>". label($row["f_name"]) . "</label>
                    <div class='col-md-9'>
                      <input type=\"text\" class=\"form-control\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" placeholder=\"" . label($row["column_name"]) . "\" value=\"<?php echo $" . $row["column_name"] . "; ?>\" />
                      <span class='help-block'> <?php echo form_error('" . $row["column_name"] . "') ?> </span>
                    </div>
                  </div>
                </div>
                ";
  }
  if ($i % 2 == 0) {
      $string .="
              </div>";
  }
  
}
if ($i % 2 == 1) {
    $string .="
              </div>";
}
$string .= "
                <input type=\"hidden\" name=\"" . $pk . "\" value=\"<?php echo $" . $pk . "; ?>\" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href=\"<?php echo site_url('" . $c_url . "') ?>\" class=\"btn default\">Kembali</a>
                    <?php if (\$button == 'Create'): ?>
                    <button type='submit' class='btn green' name='mode' value='new' >Simpan</button>
                    <?php endif ?>
                    <button type='submit' class='btn blue' >Selesai</button>
                  </div>
                </div>
              </div>
              ";
$string .= "
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->";

$hasil_view_form = createFile($string, $target_view . $v_form_file);
?>