
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form M SALES </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Sales Name</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="sales_name" id="sales_name" placeholder="Sales Name" value="<?php echo $sales_name; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Sales Telp</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="sales_telp" id="sales_telp" placeholder="Sales Telp" value="<?php echo $sales_telp; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Sales Address</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="sales_address" id="sales_address" placeholder="Sales Address" value="<?php echo $sales_address; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'> Sales Img</label>
                    <div class='col-md-9'>
                      <input type="hidden" class="form-control" name="sales_img" id="sales_img" placeholder="Sales Img" value="<?php echo $sales_img; ?>" />
                      <img class="btn no-space upload_img_single" id="sales_img_preview" style="width: 100px; height: 100px;" src="<?php echo base_url('uploads/temp/'.$sales_img); ?>" onerror="this.src='<?php echo base_url("assets/global/img/noimage.png") ?>'" alt="Image">
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Sales Mail</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="sales_mail" id="sales_mail" placeholder="Sales Mail" value="<?php echo $sales_mail; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="sales_id" value="<?php echo $sales_id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('m_sales') ?>" class="btn default">Kembali</a>
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

