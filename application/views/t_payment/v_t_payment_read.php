
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>T_payment</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class="table table-bordered">
                    <tr><td>Customer Id</td><td><?php echo $customer_id; ?></td></tr>
                    <tr><td>No Transaction</td><td><?php echo $no_transaction; ?></td></tr>
                    <tr><td>Payment Date</td><td><?php echo $payment_date; ?></td></tr>
                    <tr><td>Payment Value</td><td><?php echo $payment_value; ?></td></tr>
                    <tr><td>Payment Kurs Dollar</td><td><?php echo $payment_kurs_dollar; ?></td></tr>
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href="<?php echo site_url('t_payment') ?>" class="btn default">Kembali</a>
                                <a href="<?php echo site_url('t_payment/form/'.$id) ?>" class="btn btn-success">Edit</a>
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