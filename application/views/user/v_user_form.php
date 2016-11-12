
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form USER </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>ID PRIVILLAGE</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="ID_PRIVILLAGE" id="ID_PRIVILLAGE" placeholder="ID PRIVILLAGE" value="<?php echo $ID_PRIVILLAGE; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>USERNAME</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="USERNAME" id="USERNAME" placeholder="USERNAME" value="<?php echo $USERNAME; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>PASSWORD</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="PASSWORD" id="PASSWORD" placeholder="PASSWORD" value="<?php echo $PASSWORD; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="ID_USER" value="<?php echo $ID_USER; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('user') ?>" class="btn default">Kembali</a>
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

