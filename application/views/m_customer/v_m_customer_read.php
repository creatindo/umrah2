
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>M_customer</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class="table table-bordered">
                    <tr><td>Customer Name</td><td><?php echo $customer_name; ?></td></tr>
                    <tr><td>Customer Address</td><td><?php echo $customer_address; ?></td></tr>
                    <tr><td>Mother Name</td><td><?php echo $mother_name; ?></td></tr>
                    <tr><td>Customer Birth Place</td><td><?php echo $customer_birth_place; ?></td></tr>
                    <tr><td>Customer Birth Date</td><td><?php echo $customer_birth_date; ?></td></tr>
                    <tr><td>Customer Gender</td><td><?php echo $customer_gender; ?></td></tr>
                    <tr><td>Customer Jobs</td><td><?php echo $customer_jobs; ?></td></tr>
                    <tr><td>Customer Passport No</td><td><?php echo $customer_passport_no; ?></td></tr>
                    <tr><td>Customer Passport Date</td><td><?php echo $customer_passport_date; ?></td></tr>
                    <tr><td>Customer Img</td><td><?php echo $customer_img; ?></td></tr>
                    <tr><td>Kota Id</td><td><?php echo $kota_id; ?></td></tr>
                    <tr><td>Kecamatan Id</td><td><?php echo $kecamatan_id; ?></td></tr>
                    <tr><td>Propinsi Id</td><td><?php echo $propinsi_id; ?></td></tr>
                    <tr><td>Periode Id</td><td><?php echo $periode_id; ?></td></tr>
                    <tr><td>Sales Id</td><td><?php echo $sales_id; ?></td></tr>
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href="<?php echo site_url('m_customer') ?>" class="btn default">Kembali</a>
                                <a href="<?php echo site_url('m_customer/form/'.$id) ?>" class="btn btn-success">Edit</a>
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