
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form T DOCUMENT </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Document Id</label>
                    <div class='col-md-9'>
                      <?php 
                      $v_name_1 = '';
                      if (!empty($document_id)) {                                
                        $v_name_1 = $this->M_dokument_model->get($document_id)->{$this->M_dokument_model->label};
                      }
                      $ddajax = array(
                        'url' => site_url('form/dd/M_dokument_model'), 
                        'name' =>'document_id',
                        'current_selected_id' => $document_id, 
                        'current_selected_name' => $v_name_1, 
                        );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE); ?>
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Id</label>
                    <div class='col-md-9'>
                      <?php 
                      $v_name_2 = '';
                      if (!empty($customer_id)) {                                
                        $v_name_2 = $this->M_customer_model->get($customer_id)->{$this->M_customer_model->label};
                      }
                      $ddajax = array(
                        'url' => site_url('form/dd/M_customer_model'), 
                        'name' =>'customer_id',
                        'current_selected_id' => $customer_id, 
                        'current_selected_name' => $v_name_2, 
                        );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE); ?>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Quantity</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('t_document') ?>" class="btn default">Kembali</a>
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

