
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject uppercase'>
                <h2><?php echo $cust->customer_name ?><small style="font-size: 12px"><i>Customer Name</i> </small></h2>
            </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <div class="row">
            <div class="col-md-3 col-md-offset-2">
              <label class="label label-info">Total</label>
              <h2><?php echo number_format($payment->cost,0,'.','.') ?></h2>
            </div>
            <div class="col-md-3">
              <label class="label label-success">Bayar</label>
              <h2><?php echo number_format($payment->bayar,0,'.','.') ?></h2>
            </div>
            <div class="col-md-3">
              <label class="label label-danger">sisa</label>
              <h2><?php echo number_format($payment->sisa,0,'.','.') ?></h2>
            </div>
          </div>
          <hr>
          <form action="<?php echo site_url('t_payment/cek_action') ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                
                  <div class='form-group'>
                    <label class='col-md-5 control-label'>Payment Value</label>
                    <div class='col-md-3'>
                      <input type="text" class="form-control mask-number" name="payment_value" id="payment_value" placeholder="Payment Value" value="" />
                    </div>
                  </div>
                
              </div>

                <input type="hidden" name="customer_id" value="<?php echo $cust->customer_id ?>">
              
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

