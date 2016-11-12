
$(document).on("click", "[data-toggle=\"confirm\"]", function (e) {
    e.preventDefault();
    var lHref = $(this).attr('href');
    var lText = this.attributes.getNamedItem("data-title") ? 'Hapus <b>' + this.attributes.getNamedItem("data-title").value + '</b> ?' : "Hapus ?"; // If data-title is not set use default text
    bootbox.confirm(lText, function (confirmed) {
        if (confirmed) {
            //window.location.replace(lHref); // similar behavior as an HTTP redirect (DOESN'T increment browser history)
            window.location.href = lHref; // similar behavior as clicking on a link (Increments browser history)
        }
    });
});
// App.startPageLoading();
//================================
$(".upload_img_single").click(function (e) {
    var imgId = '#'+$(this).attr("id");
    var photo_before = $(this).attr("src");
    var hiddenInputId = '#'+$(this).parent().find( 'input:hidden' ).attr("id");
    var modal_upload_options={
        "targetImgId": imgId,
        "photo":photo_before, 
        "hiddenInputId" : hiddenInputId,
    };

    if (document.getElementById('div_upload') === null){
        var iDiv = document.createElement('div');
        iDiv.id = 'div_upload';
        $(this).parent().append(iDiv);
    }

    $('#div_upload').load("<?php echo site_url('upload/single') ?>",modal_upload_options ,
        function(){
        /* Stuff to do after the page is loaded */
    });
});
//================================
function upload_file(objt) {
    console.log("hai");
    var data_file = objt.parent("div").find("input[type=file]");
    var data_hidden = objt.parent("div").find("input[type=hidden]");
    var data_progress = objt.parent("div").find(".upload-progres");
    var data_filename = objt.parent("div").find(".upload-filename");
    var formData = new FormData();
    formData.append('x_upload_file', data_file.prop('files')[0]);
    formData.append('folder', 'video');
    
    $.ajax({
            url: data_file.data("url"),
            dataType: 'json',
            data: formData,
            method: 'POST',
            contentType: false,
            processData: false,
            beforeSend: function (e) {
                data_progress.html('\
                    <div>\
                        <div class="progress progress-striped active">\
                            <div class="progress-bar progress-bar-info" style="width: 0%;"></div>\
                        </div>\
                    </div>\
                ');
            },
            xhr: function() {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(evt) {
                        var percent = (evt.loaded / evt.total) * 100;
                        data_progress.find(".progress-bar").width(percent + "%");
                        if (percent === 100) {
                            data_progress.html("");
                        }
                    }, false);
                }
                return xhr;
            },
            error: function (e) {
                console.log(e);
                // btnObj.button('reset');
                toastr.error('Oops!', 'Maaf, telah terjadi kesalahan');
            },
            success: function(response) {
                console.log(response);
                // btnObj.button('reset');

                if (response.success == true) {
                    data_filename.html(response.file_name);
                    data_hidden.val(response.file_name);
                } else {
                    toastr.error(response.message);
                }
            },
        });
}