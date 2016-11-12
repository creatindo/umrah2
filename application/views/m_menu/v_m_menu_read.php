
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>M_menu</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class="table table-bordered">
                    <tr><td>Menu Nama</td><td><?php echo $menu_nama; ?></td></tr>
                    <tr><td>Link</td><td><?php echo $link; ?></td></tr>
                    <tr><td>Icon</td><td><?php echo $icon; ?></td></tr>
                    <tr><td>Order</td><td><?php echo $order; ?></td></tr>
                    <tr><td>Is Active</td><td><?php echo $is_active; ?></td></tr>
                    <tr><td>Is Parent</td><td><?php echo $is_parent; ?></td></tr>
                    <tr><td>Controller</td><td><?php echo $controller; ?></td></tr>
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href="<?php echo site_url('m_menu') ?>" class="btn default">Kembali</a>
                                <a href="<?php echo site_url('m_menu/form/'.$id) ?>" class="btn btn-success">Edit</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.col -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->