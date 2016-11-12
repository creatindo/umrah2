
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>M_sales</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class="table table-bordered">
                    <tr><td>Sales Name</td><td><?php echo $sales_name; ?></td></tr>
                    <tr><td>Sales Telp</td><td><?php echo $sales_telp; ?></td></tr>
                    <tr><td>Sales Address</td><td><?php echo $sales_address; ?></td></tr>
                    <tr><td>Sales Img</td><td><?php echo $sales_img; ?></td></tr>
                    <tr><td>Sales Mail</td><td><?php echo $sales_mail; ?></td></tr>
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href="<?php echo site_url('m_sales') ?>" class="btn default">Kembali</a>
                                <a href="<?php echo site_url('m_sales/form/'.$id) ?>" class="btn btn-success">Edit</a>
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