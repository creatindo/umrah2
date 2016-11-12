
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form T PAYMENT </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Customer Id</label>
                    <div class='col-md-9'>
                      <?php 
                      $v_name_1 = '';
                      if (!empty($customer_id)) {                                
                        $v_name_1 = $this->M_customer_model->get($customer_id)->{$this->M_customer_model->label};
                      }
                      $ddajax = array(
                        'url' => site_url('form/dd/M_customer_model'), 
                        'name' =>'customer_id',
                        'current_selected_id' => $customer_id, 
                        'current_selected_name' => $v_name_1, 
                        );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE); ?>
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>No Transaction</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="no_transaction" id="no_transaction" placeholder="No Transaction" value="<?php echo $no_transaction; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Payment Date</label>
                    <div class='col-md-9'>
                      <div class='input-group date date-decade' >
                        <input type='text' class='form-control ' readonly name="payment_date" value="<?php echo $payment_date; ?>">
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
                    <label class='col-md-3 control-label'>Payment Value</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="payment_value" id="payment_value" placeholder="Payment Value" value="<?php echo $payment_value; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Payment Kurs Dollar</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="payment_kurs_dollar" id="payment_kurs_dollar" placeholder="Payment Kurs Dollar" value="<?php echo $payment_kurs_dollar; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('t_payment') ?>" class="btn default">Kembali</a>
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

