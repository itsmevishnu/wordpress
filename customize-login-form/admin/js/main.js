jQuery(document).ready(function($){
  $('.clf-color-field').wpColorPicker();
  $('.clf-need-image').click(function(){
    if ($('.clf-need-image').is(':checked')) {
      $('.bg-color .wp-picker-container').css('pointer-events','none');
      $('clf-bg-image').css('pointer-events','auto');
    }
  });
  $('#upload_logo_button,#upload_bg_image_button').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    var image = wp.media({
      title: 'Upload Image',
      // mutiple: true if you want to upload multiple files at once
      multiple: false
    }).open()
    .on('select', function(e){
      // This will return the selected image from the Media Uploader, the result is an object
      var uploaded_image = image.state().get('selection').first();
      // We convert uploaded_image to a JSON object to make accessing it easier
      // Output to the console uploaded_image

      var image_url = uploaded_image.toJSON().url;
      // Let's assign the url value to the input field
      switch( id ) {
        case 'upload_logo_button' : {
          $('#clf_logo_image').val(image_url);
          $('img').attr('src', image_url);
          break;
        }
        case 'upload_bg_image_button' : {
          $('#clf_bg_image').val(image_url);
          $('img').attr('src', image_url);
          break;
        }
      }

    });
  });
});
