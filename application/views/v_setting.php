
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption'>
            <span class='caption-subject bold uppercase'>Setting </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo site_url('setting/save'); ?>" method="post">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('active')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>Video</label>
                    <div class='col-md-9'>

                      <select name="video" class="form-control" required="required">
                        <?php $selected = ($setting["video_type"] == "offline") ? "selected" : "" ; ?>
                        <option value="offline" <?php echo $selected ?> >Offline</option>

                        <?php $selected = ($setting["video_type"] == "youtube") ? "selected" : "" ; ?>                        
                        <option value="youtube" <?php echo $selected ?> >Youtube</option>
                      </select>
                      <span class='help-block'> <?php echo form_error('active') ?> </span>
                    </div>
                  </div>
                </div>
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('active')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'>Youtube</label>
                    <div class='col-md-9'>
                      
                      <input type="input" name="youtube_id" class="form-control" value="<?php echo($setting['youtube_url']) ?>" placeholder="Youtube id">
                      <span class="help-block">contoh : VTmB32uXkFk </span>
                      <span class='help-block'> <?php echo form_error('active') ?> </span>
                    </div>
                  </div>
                </div>
              
                
              </div>
              <div class="row">
                <div class='col-md-6'>
                  <div class='form-group <?php if(form_error('logo')){echo 'has-error';} ?>'>
                    <label class='col-md-3 control-label'> Logo</label>
                    <div class='col-md-9'>
                      <input type="hidden" class="form-control" name="logo" id="logo" placeholder="Logo" value="<?php echo $setting['logo']; ?>" />
                      <img class="btn no-space upload_img_single" data-name="logo" id="logo_preview" width="300px" height="100px" src="<?php echo base_url('uploads/image/'.$setting['logo']); ?>" onerror="this.src='<?php echo base_url("assets/global/img/noimage.png") ?>'" alt="Image">
                      <span class='help-block'> <?php echo form_error('logo') ?> </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <button type='submit' class='btn green' name='mode' value='new' >Simpan
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