    <!-- Jcrop -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/global/plugins/jcrop/js/jquery.Jcrop.min.js" type="text/javascript"></script>


    <style type="text/css">
    /* Box Upload */
    .box-upload {
        min-height: 400px;
        position: relative;
    }
    .box-upload .img-responsive {
        margin: 0 auto;
    }
    .box-upload.dragover {
        border: 3px dashed #CCC;
    }
    .box-upload.dragover * {
        opacity: 0.5;
    }
    .box-upload .box-upload-text {
        position: absolute;
        width: 100%;
        text-align: center;
        top: 50%;
        margin-top: -80px;
    }
    .box-upload .box-upload-text .glyphicon {
        display: block;
        font-size: 5em;
        margin-bottom: 25px;
    }
    .box-upload input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
        opacity: 0;
        top: 0;
        left: 0;
    }
    .box-upload .box-preview .jcrop-holder {
        margin: 0 auto;
    }
    .modal.modal-scroll {
        overflow-y: auto;
    }
    </style>

    <div id="ubah_foto_modal" class="modal fade" tabindex="-1" data-width="680">
    <?php echo form_open_multipart($upload_url, array('id' => 'upload_form')); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $title ?></h4>
        </div>
        <div class="modal-body">
            <div class="box-upload">
                <div class="box-preview">
                    <?php if ($photo): ?>
                        
                    <img src="<?php echo $photo; ?>" class="img-responsive">
                    <?php endif ?>
                </div>
                <div class="box-upload-text">
                    <span class="glyphicon glyphicon-camera"></span>
                    Klik atau drag dan drop foto di sini
                </div>
                <input type="hidden" name="x" />
                <input type="hidden" name="y" />
                <input type="hidden" name="w" />
                <input type="hidden" name="h" />
                <input type="hidden" name="new_name" value="<?php echo $new_name; ?>" />
                <input type="hidden" name="folder" value="<?php echo $folder; ?>" />
                <input type="hidden" name="upload_url" value="<?php echo $upload_url; ?>" />
                <input type="file" name="cover_dokumen" accept="image/*" id="ubah_foto_file">
            </div>
            <div id="fileUploadProgressTemplate" style="display:none">
                <div class="">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-info" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    <?php echo form_close(); ?>
    </div>
    
    <script type="text/javascript">
        
        var memberProfile = {
            init: function() {
                //load modal
                $('#ubah_foto_modal').modal({show:true});
                // Ubah foto profil
                $('#upload_form').on('submit', function(e) {
                    e.preventDefault();
                    memberProfile.ubahFotoProfile($(this));
                });

                // Remove dragover style on drop
                $('#ubah_foto_file').on('drop', function(e){
                    $(this).parents('#ubah_foto_modal .box-upload').removeClass('dragover');
                });
                // Add dragover style 
                $('#ubah_foto_file').on('dragover', function(e){
                    $(this).parents('#ubah_foto_modal .box-upload').addClass('dragover');
                });
                // Remove dragover style on mouse leave
                $('#ubah_foto_modal .box-upload').on('mouseleave', function(e){
                    $(this).removeClass('dragover');
                });
                window.addEventListener("dragover",function(e){
                    e = e || event;
                    e.preventDefault();
                }, false);
                window.addEventListener("drop",function(e){
                    e = e || event;
                    if ($(e.target).attr('type') != 'file') {
                        e.preventDefault();
                        toastr.error('Upload foto profil pada bagian drap & drop.');
                    }
                }, false);

                // Preview image
                $('#ubah_foto_file').on('change', function(e){
                    var files = e.target.files;
                    if (files && files[0]) {
                        if ( ! files[0].type.match('image.*')) {
                            toastr.error('Pastikan file berupa gambar.');
                        } else {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                $('#ubah_foto_modal')
                                    .find('.box-preview')
                                    .html('<img src="'+ e.target.result + '" id="jcrop_target">');

                                memberProfile.initJCrop();
                            }

                            reader.readAsDataURL(files[0]);
                        }
                    }
                });
            },
            initJCrop: function() {
                var $jcropTarget = $('#jcrop_target');
                $jcropTarget.Jcrop({
                    boxWidth: 538,   
                    boxHeight: 538,
                    setSelect: [200, 200, 100, 100 ],
                    aspectRatio: <?php echo $ratio; ?>,
                    allowSelect : false,
                    minSize: [200, 200],
                    onSelect: function(c) {
                        $('input[name=x]').val(c.x);
                        $('input[name=y]').val(c.y);
                        $('input[name=w]').val(c.w);
                        $('input[name=h]').val(c.h);
                    }
                });
            },
            ubahFotoProfile: function(formObj) {
                var formData = new FormData(formObj[0]);
                var btnObj = formObj.find('button[type=submit]');

                $("#fileUploadProgressTemplate").find(".progress-bar").width( 0 + "%");
                $("#fileUploadProgressTemplate").show();

                $.ajax({
                    url: formObj.attr('action'),
                    dataType: 'json',
                    data: formData,
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    beforeSend: function (e) {
                        btnObj.button('loading');
                    },
                    xhr: function() {
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', function(evt) {
                                var percent = (evt.loaded / evt.total) * 100;
                                $("#fileUploadProgressTemplate").find(".progress-bar").width(percent + "%");
                            }, false);
                        }
                        return xhr;
                    },
                    error: function (e) {
                        console.log(e);
                        btnObj.button('reset');
                        toastr.error('Oops!', 'Maaf, telah terjadi kesalahan');
                    },
                    success: function(response) {
                        console.log(response);
                        btnObj.button('reset');

                        if (response.success == true) {
                            $('#ubah_foto_modal').modal('hide');
                            toastr.success(response.message);
                            $("<?php echo $targetImgId ?>").attr("src", response.url_image);
                            <?php if ($hiddenInputId): ?>                                        
                                $("<?php echo $hiddenInputId ?>").val(response.file_name);
                            <?php endif ?>
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        };

        $(function() {
            memberProfile.init();
        });
    </script>