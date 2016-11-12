    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?php echo base_url(); ?>theme/m4/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <div id="ubah_foto_multi_modal" class="modal fade" tabindex="-1" data-width="760">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Upload</h4>
        </div>
        <div class="modal-body">

            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <form id="fileuploadmulti" action="<?php echo site_url('member/upload/do_upload_multi') ?>" method="POST" enctype="multipart/form-data">
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-12">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn green fileinput-button">
                                        <i class="fa fa-plus"></i>
                                        <span> Add files... </span>
                                        <input type="file" name="cover_dokumen" multiple=""> </span>
                                        <input type="hidden" name="folder" value="<?php echo $folder ?>">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                    <button type="submit" class="btn blue start">
                                        <i class="fa fa-upload"></i>
                                        <span> Start upload </span>
                                    </button>
                                    <button type="reset" class="btn warning cancel">
                                        <i class="fa fa-ban-circle"></i>
                                        <span> Cancel upload </span>
                                    </button>
                                    <button type="button" class="btn red delete">
                                        <i class="fa fa-trash"></i>
                                        <span> Delete All</span>
                                    </button>
                                    <input type="checkbox" class="toggle">
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"> </span>
                                </div>
                                <!-- The global progress information -->
                                <div class="col-lg-4 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
                                    </div>
                                    <!-- The extended global progress information -->
                                    <div class="progress-extended"> &nbsp; </div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped clearfix">
                                <tbody class="files"> </tbody>
                            </table>
                        </form>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Notes</h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li> Maksimal ukuran file untuk upload 
                                        <strong>5 MB</strong>. </li>
                                    <li> Hanya gambar (
                                        <strong>JPG, GIF, PNG</strong>) yang bisa diupload. </li>
                                    <li>Gunakan tombol Ctrl untuk multi upload</li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The blueimp Gallery widget -->
                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                    <div class="slides"> </div>
                    <h3 class="title"></h3>
                    <a class="prev"> ‹ </a>
                    <a class="next"> › </a>
                    <a class="close white"> </a>
                    <a class="play-pause"> </a>
                    <ol class="indicator"> </ol>
                </div>
                <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
                <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                    <tr class="template-upload fade">
                        <td>
                            <span class="preview"></span>
                        </td>
                        <td>
                            <p class="name">{%=file.name%}</p>
                            <strong class="error text-danger label label-danger"></strong>
                        </td>
                        <td>
                            <p class="size">Processing...</p>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                        </td>
                        <td> {% if (!i && !o.options.autoUpload) { %}
                            <button class="btn blue start" disabled>
                                <i class="fa fa-upload"></i>
                                <span>Start</span>
                            </button> {% } %} {% if (!i) { %}
                            <button class="btn red cancel">
                                <i class="fa fa-ban"></i>
                                <span>Cancel</span>
                            </button> {% } %} </td>
                    </tr> {% } %} </script>
                <!-- The template to display files available for download -->
                <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                    <tr class="template-download fade">
                        <td>
                            <span class="preview"> {% if (file.thumbnailUrl) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                                    <img src="{%=file.thumbnailUrl%}">
                                </a> {% } %} </span>
                        </td>
                        <td>
                            <p class="name"> {% if (file.url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
                                <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
                            <div>
                                <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
                        <td>
                            <span class="size">{%=o.formatFileSize(file.size)%}</span>
                        </td>
                        <td> {% if (file.deleteUrl) { %}
                            <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {%
                            } %}>
                                <i class="fa fa-trash-o"></i>
                                <span>Delete</span>
                            </button>
                            <input type="checkbox" name="delete" value="1" class="toggle"> {% } else { %}
                            <button class="btn yellow cancel btn-sm">
                                <i class="fa fa-ban"></i>
                                <span>Cancel</span>
                            </button> {% } %} </td>
                    </tr> {% } %} </script>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
    </div>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>theme/m4/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
    
    <!-- END PAGE LEVEL PLUGINS -->
    <script type="text/javascript">
        var FormFileUpload = function () {
            return {
                //main function to initiate the module
                init: function () {

                     // Initialize the jQuery File Upload widget:
                    $('#fileuploadmulti').fileupload({
                        disableImageResize: false,
                        autoUpload: false,
                        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
                        maxFileSize: 5000000,
                        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                        // Uncomment the following to send cross-domain cookies:
                        //xhrFields: {withCredentials: true},                
                    });

                    // Enable iframe cross-domain access via redirect option:
                    $('#fileuploadmulti').fileupload(
                        'option',
                        'redirect',
                        window.location.href.replace(
                            /\/[^\/]*$/,
                            '/cors/result.html?%s'
                        )
                    );

                    // Upload server status check for browsers with CORS support:
                    if ($.support.cors) {
                        $.ajax({
                            type: 'HEAD'
                        }).fail(function () {
                            $('<div class="alert alert-danger"/>')
                                .text('Upload server currently unavailable - ' +
                                        new Date())
                                .appendTo('#fileuploadmulti');
                        });
                    }

                    // Load & display existing files:
                    $('#fileuploadmulti').addClass('fileupload-processing');
                    $.ajax({
                        // Uncomment the following to send cross-domain cookies:
                        //xhrFields: {withCredentials: true},
                        url: $('#fileuploadmulti').attr("action"),
                        dataType: 'json',
                        context: $('#fileuploadmulti')[0]
                    }).always(function () {
                        $(this).removeClass('fileupload-processing');
                    }).done(function (result) {
                        $(this).fileupload('option', 'done')
                        .call(this, $.Event('done'), {result: result});
                    });
                }

            };

        }();

        jQuery(document).ready(function() {
            FormFileUpload.init();
             $('#ubah_foto_multi_modal').modal({show:true});
        });

    </script>