
<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='portlet light portlet-fit portlet-datatable bordered'>
        <div class='portlet-title'>
            <div class="caption">
                <i class="icon-settings font-dark"></i>
                <span class="caption-subject font-dark sbold uppercase">M CUSTOMER  </span>
            </div>
            <div class="actions">
                <div class="btn-group" >
                        <?php echo anchor('m_customer/form/','<i class="fa fa-pencil"></i> Create',array('class'=>'btn btn-circle btn-info btn-sm'));?>
                </div>
                <div class="btn-group">
                    <a class="btn red btn-circle" href="javascript:;" data-toggle="dropdown">
                        <i class="fa fa-share"></i>
                        <span class="hidden-xs"> Tools </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <?php echo anchor(site_url('m_customer/excel'), ' Export to Excel', ''); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.box-header -->
        <div class='portlet-body table-container'>
        <div class="table-actions-wrapper">
            <span> </span>
            <select class="table-group-action-input form-control input-inline input-small input-sm">
                <option value="">Select...</option>
                <option value="delete">Delete</option>
            </select>
            <button class="btn btn-sm green table-group-action-submit">
                <i class="fa fa-check"></i> Submit</button>
        </div>
        <table class="table table-striped table-bordered table-hover" id="mytable">
            <thead>
                <tr role="row" class="heading">
                    <th width="2%"><input type="checkbox" class="group-checkable"> </th>
                    
                    <th width="2%">Action</th>
                    <th>Customer Name</th>
                    <th>Customer Address</th>
                    <th>Mother Name</th>
                    <th>Customer Birth Place</th>
                    <th>Customer Birth Date</th>
                    <th>Customer Gender</th>
                    <th>Customer Jobs</th>
                    <th>Customer Passport No</th>
                    <th>Customer Passport Date</th>
                    <th>Customer Img</th>
                    <th>Kota</th>
                    <th>Kecamatan</th>
                    <th>Propinsi</th>
                    <th>Periode</th>
                    <th>Sales</th>
                </tr>
                <tr role="row" class="filter">
                    <td></td>
                    
                    <td>
                        <div class="margin-bottom-5">
                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                            <i class="fa fa-search"></i> Search</button>
                        </div>
                        <button class="btn btn-sm red btn-outline filter-cancel">
                        <i class="fa fa-times"></i> Reset</button>
                    </td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_name"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_address"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="mother_name"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_birth_place"></td>
                    <td>
                        <input class="form-control form-control form-filter input-sm date-decade " readonly name="customer_birth_date_start"  type="text" value="" />
                        <input class="form-control form-control form-filter input-sm date-decade " readonly name="customer_birth_date_end"  type="text" value="" />
                    </td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_gender"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_jobs"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_passport_no"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_passport_date"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="customer_img"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="kota_id"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="kecamatan_id"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="propinsi_id"></td>
                    <td>
                    <?php 
                      $ddajax = array(
                          'url' => site_url('form/dd/M_periode_model'), 
                          'name' =>'periode_id',
                          'class' => 'form-control form-filter input-sm',
                          );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE);
                    ?>
                    </td>
                    <td>
                    <?php 
                      $ddajax = array(
                          'url' => site_url('form/dd/M_sales_model'), 
                          'name' =>'sales_id',
                          'class' => 'form-control form-filter input-sm',
                          );
                      $this->load->view('form/v_dropdown_ajax', array('ddajax' => $ddajax ), FALSE);
                    ?>
                    </td>
                </tr>
            </thead>
	    <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            var TableDatatablesAjax = function () {
                var grid = new Datatable();
                grid.init({
                    src: $("#mytable"),
                    dataTable: {  
                        "ajax": {
                            "url": "<?php echo site_url('m_customer/getDatatable/') ?>", // ajax source
                        },
                        "order": [
                            [1, "asc"]
                        ]// set first column as a default sort by asc
                    }
                });
            }
            jQuery(document).ready(function() {
               TableDatatablesAjax();
            });
        </script>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->