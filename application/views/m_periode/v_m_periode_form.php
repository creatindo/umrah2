
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form M PERIODE </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Name</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Depart Date</label>
                    <div class='col-md-9'>
                      <div class='input-group date date-decade' >
                        <input type='text' class='form-control ' readonly name="depart_date" value="<?php echo $depart_date; ?>">
                        <span class='input-group-btn'>
                          <button class='btn default' type='button'>
                            <i class='fa fa-calendar'></i>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Arrival Date</label>
                    <div class='col-md-9'>
                      <div class='input-group date date-decade' >
                        <input type='text' class='form-control ' readonly name="arrival_date" value="<?php echo $arrival_date; ?>">
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
                    <label class='col-md-3 control-label'>Quantity</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Keterangan</label>
                    <div class='col-md-9'>
                      <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('m_periode') ?>" class="btn default">Kembali</a>
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

