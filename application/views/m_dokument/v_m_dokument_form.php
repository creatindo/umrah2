
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form M DOKUMENT </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Document Name</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="document_name" id="document_name" placeholder="Document Name" value="<?php echo $document_name; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Document Quantity</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="document_quantity" id="document_quantity" placeholder="Document Quantity" value="<?php echo $document_quantity; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="document_id" value="<?php echo $document_id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('m_dokument') ?>" class="btn default">Kembali</a>
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

