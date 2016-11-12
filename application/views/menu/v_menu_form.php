
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light'>
        <div class='portlet-title'>
          <div class='caption font-green'>
            <span class='caption-subject bold uppercase'>Form MENU </span>
          </div>
        </div>
        <div class='portlet-body form'>
          <form action="<?php echo $action; ?>" method="post" id="input_form" class="form-horizontal">
            <div class='form-body'>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Menu Nama</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="menu_nama" id="menu_nama" placeholder="Menu Nama" value="<?php echo $menu_nama; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Link</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?php echo $link; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Icon</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Order</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="order" id="order" placeholder="Order" value="<?php echo $order; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Is Active</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="is_active" id="is_active" placeholder="Is Active" value="<?php echo $is_active; ?>" />
                    </div>
                  </div>
                </div>
                
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Is Parent</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control mask-number" name="is_parent" id="is_parent" placeholder="Is Parent" value="<?php echo $is_parent; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <div class='form-group'>
                    <label class='col-md-3 control-label'>Controller</label>
                    <div class='col-md-9'>
                      <input type="text" class="form-control" name="controller" id="controller" placeholder="Controller" value="<?php echo $controller; ?>" />
                    </div>
                  </div>
                </div>
                
              </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
              </div>
              <div class='form-actions'>
                <div class='row'>
                  <div class='col-md-offset-5 col-md-7'>
                    <a href="<?php echo site_url('menu') ?>" class="btn default">Kembali</a>
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

