<!-- <link href="{!! asset('backend/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script src="{!! asset('backend/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') !!}" type="text/javascript"></script>-->
<script type="text/javascript">
    function example_image_upload_handler (blobInfo, success, failure, progress) {
  var xhr, formData;

  xhr = new XMLHttpRequest();
  xhr.withCredentials = false;
  xhr.open('POST', '/admin/image/upload');

  xhr.upload.onprogress = function (e) {
    progress(e.loaded / e.total * 100);
  };

  xhr.onload = function() {
    var json;

    if (xhr.status === 403) {
      failure('HTTP Error: ' + xhr.status, { remove: true });
      return;
    }

    if (xhr.status < 200 || xhr.status >= 300) {
      failure('HTTP Error: ' + xhr.status);
      return;
    }

    json = JSON.parse(xhr.responseText);

    if (!json || typeof json.path != 'string') {
      failure('Invalid JSON: ' + xhr.responseText);
      return;
    }

    success(json.path);
  };

  xhr.onerror = function () {
    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
  };

  formData = new FormData();
  formData.append('file', blobInfo.blob(), blobInfo.filename());
  formData.append('_token',document.getElementsByName('_token')[0].value);
  formData.append('thumb','path_original');
  xhr.send(formData);
};

    function initTinymce() {
        tinymce.init({
            selector: '.wysihtml5',  // change this value according to your HTML
            plugins: 'image code link',
            a11y_advanced_options: true,
            images_upload_handler: example_image_upload_handler,
            height: 400,
            image_class_list: [
                {title: 'None', value: ''},
                {title: 'Left', value: 'alignleft'},
                {title: 'Right', value: 'alignright'},
                {title: 'Center', value: 'alignnone size-full'}
            ]
        });
    }
</script>