<script>
  const imageDropArea = $('div#profileImage');
  const inputImage = imageDropArea.parent().find('input#image');

  inputImage.on('change', function(e) {
    const imageBLOB = URL.createObjectURL(e.target.files[0]);
    imageDropArea.html(`<label class="m-0" for="image">
        <img alt="image" src="${imageBLOB}" class="rounded-circle ml-0 shadow" style="width: 200px; height: 200px; background-size: cover">
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 right-0 rounded-circle" style="width: 30px; height: 30px">
          <i class="fas fa-times" id="removeProfileImage"></i>
        </button>
      </label>
    `);
  });

  imageDropArea.on('click', function(e) {
    if ( e.target.id == 'removeProfileImage' ) {
      inputImage.val('');
      $(this).html(`<label class="m-0 pt-3 text-break" for="image">
          <h6 class="mb-0">Select your profile image</h6>
          <p class="mb-0 text-center">500 &times; 500</p>
        </label>
      `);
    }
  });  
</script>