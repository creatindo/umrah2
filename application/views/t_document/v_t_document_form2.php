
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
          <div class='row'>
            <form action="<?php echo site_url('t_document/cek_action') ?>" method="post" id="input_form" class="form-horizontal">

              <?php foreach ($tdoc as $doc): ?>
                <div class='col-md-12'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'><?php echo $doc->document_name ?>
                      <span class="badge badge-primary"><?php echo $doc->document_quantity ?></span>
                    </label>
                    <div class='col-md-2'>
                      <?php 
                        $data = array('document_id' => $doc->document_id, 'customer_id' => $cust->customer_id, 'status' => 1);
                        $cek = ($this->T_document_model->get($data)) ? 'checked' : '' ;
                        
                        $data2 = array('document_id' => $doc->document_id, 'customer_id' => $cust->customer_id );
                        $d = $this->T_document_model->get($data2);
                        $nilai = ($d) ? $d->quantity : '' ;
                      ?>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox" <?php echo $cek ?> class="form-control " name="dok[<?php echo $doc->document_id ?>]" value="<?php echo $doc->document_id ?>" />
                        </span>
                        <input type="text" class="form-control mask-number" name="q[<?php echo $doc->document_id ?>]" value="<?php echo $nilai ?>">
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>

              <input type="hidden" name="customer_id" value="<?php echo $cust->customer_id ?>">

              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('m_customer') ?>" class="btn default">Kembali</a>
                    <button type='submit' class='btn green' name='mode' value='new' >Simpan</button>
                  </div>
                </div>
              </div>
            </form>

          </div><!-- /.box-body -->
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

