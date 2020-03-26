@include('admin.users.profile_dropzone')
<script>
  Dropzone.autoDiscover = false;  
  $('div#imageProfile').dropzone({
    url: '{{ $url }}',
    method: 'PUT',
    paramName: 'image',
    addRemoveLinks: true,
    dictRemoveFileConfirmation: 'Remove this file?',
    previewTemplate: $('#profileDropzoneTemplate').html(),
    resizeWidth: 500,
    resizeHeight: 500,
    maxFilesize: 2,
    acceptedFiles: 'image/*',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: true,
    init: function() {
      this.on("addedfile", function() {
        this.files.length > 1 && this.removeFile(this.files[0]);
      });
    },
    accept: function(file, done) {
      setTimeout(() => {
        if ( file.width > 500 || file.height > 500 ) {
          alert('Image size should 500 x 500');
          this.removeFile(this.files[0]);
          return;
        }
        $('.dz-details.dz-image-preview').last().find('img.dz-image').attr('src', file.dataURL);
      }, 1000);
    }
  });
</script>