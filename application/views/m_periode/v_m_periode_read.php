
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>M_periode</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class="table table-bordered">
                    <tr><td>Name</td><td><?php echo $name; ?></td></tr>
                    <tr><td>Depart Date</td><td><?php echo $depart_date; ?></td></tr>
                    <tr><td>Arrival Date</td><td><?php echo $arrival_date; ?></td></tr>
                    <tr><td>Quantity</td><td><?php echo $quantity; ?></td></tr>
                    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href="<?php echo site_url('m_periode') ?>" class="btn default">Kembali</a>
                                <a href="<?php echo site_url('m_periode/form/'.$id) ?>" class="btn btn-success">Edit</a>
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