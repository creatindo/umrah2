
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form M CUSTOMER </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Name</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" value="<?php echo $customer_name; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Address</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_address" id="customer_address" placeholder="Customer Address" value="<?php echo $customer_address; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Mother Name</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name" value="<?php echo $mother_name; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Birth Place</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_birth_place" id="customer_birth_place" placeholder="Customer Birth Place" value="<?php echo $customer_birth_place; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Birth Date</label>
                    <div class='col-md-9'>
                      <div class='input-group date date-decade' >
                        <input type='text' class='form-control ' readonly name="customer_birth_date" value="<?php echo $customer_birth_date; ?>">
                        <span class='input-group-btn'>
                          <button class='btn default' type='button'>
                            <i class='fa fa-calendar'></i>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Gender</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_gender" id="customer_gender" placeholder="Customer Gender" value="<?php echo $customer_gender; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Jobs</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_jobs" id="customer_jobs" placeholder="Customer Jobs" value="<?php echo $customer_jobs; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Passport No</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="customer_passport_no" id="customer_passport_no" placeholder="Customer Passport No" value="<?php echo $customer_passport_no; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Passport Date</label>
                    <div class='col-md-9'>
                      <div class='input-group date date-picker' >
                        <input type='text' class='form-control ' readonly name="customer_passport_date" id="customer_passport_date"  value="<?php echo $customer_passport_date; ?>">
                        <span class='input-group-btn'>
                          <button class='btn default' type='button'>
                            <i class='fa fa-calendar'></i>
                          </button>
                        </span>  
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'> Customer Img</label>
                    <div class='col-md-9'>
                      <input type="hidden" class="form-control" name="customer_img" id="customer_img" placeholder="Customer Img" value="<?php echo $customer_img; ?>" />
                      <img class="btn no-space upload_img_single" id="customer_img_preview" style="width: 100px; height: 100px;" src="<?php echo base_url('uploads/temp/'.$customer_img); ?>" onerror="this.src='<?php echo base_url("assets/global/img/noimage.png") ?>'" alt="Image">
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Kota Id</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="kota_id" id="kota_id" placeholder="Kota Id" value="<?php echo $kota_id; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Kecamatan Id</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="kecamatan_id" id="kecamatan_id" placeholder="Kecamatan Id" value="<?php echo $kecamatan_id; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Propinsi Id</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="propinsi_id" id="propinsi_id" placeholder="Propinsi Id" value="<?php echo $propinsi_id; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Periode Id</label>
                    <div class='col-md-9'>
                      <?php 
                      $v_name_14 = '';
                      if (!empty($periode_id)) {                                
                        $v_name_14 = $this->M_periode_model->get($periode_id)->{$this->M_periode_model->label};
                      }
                      $ddajax = array(
                        'url' => site_url('form/dd/M_periode_model'), 
                        'name' =>'periode_id',
                        'current_selected_id' => $periode_id, 
                        'current_selected_name' => $v_name_14, 
                        );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE); ?>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Sales Id</label>
                    <div class='col-md-9'>
                      <?php 
                      $v_name_15 = '';
                      if (!empty($sales_id)) {                                
                        $v_name_15 = $this->M_sales_model->get($sales_id)->{$this->M_sales_model->label};
                      }
                      $ddajax = array(
                        'url' => site_url('form/dd/M_sales_model'), 
                        'name' =>'sales_id',
                        'current_selected_id' => $sales_id, 
                        'current_selected_name' => $v_name_15, 
                        );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE); ?>
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('m_customer') ?>" class="btn default">Kembali</a>
                    <button type='submit' class='btn green' name='mode' value='new' >Simpan</button>
                  </div>
                </div>
              </div>
              
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
  $('#input_form').submit(function(e) {
        e.preventDefault();
        main.submitAjaxModal($(this));
  });
</script>

