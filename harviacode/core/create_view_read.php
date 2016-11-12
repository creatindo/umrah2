<?php 

$string = "
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='portlet light'>
                <div class='portlet-title'>
                  <div class='caption font-green'>
                    <span class='caption-subject bold uppercase'>".ucfirst($c)."</span>
                  </div>
                </div><!-- /.title -->
                <div class='portlet-body'>
                  <table class=\"table table-bordered\">";
                    foreach ($non_pk as $row) {
                      $string .= "
                    <tr><td>".label($row["column_name"])."</td><td><?php echo $".$row["f_name"]."; ?></td></tr>";
                    }
                      $string .= "
                    <tr>
                      <td colspan='2'>
                        <div class='form-actions'>
                          <div class='row'>
                            <div class='col-md-offset-5 col-md-7'>
                                <a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn default\">Kembali</a>
                                <a href=\"<?php echo site_url('".$c_url."/update/'.\$id) ?>\" class=\"btn btn-success\">Edit</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>";
                      $string .= "
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.col -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->";



$hasil_view_read = createFile($string, $target_view. $v_read_file);

?>
