jQuery(document).ready(function( $ ) {
  $('form').submit(function (e){
    e.preventDefault();
    var data = $(this).serialize();
    jQuery.ajax({
           type   : "POST",
           url    : Htaccess.ajax_url,
           data   : ({"action": 'htaccess_ajax_submit', "formdata": data }),
           success: function(data){
            $('#result').html(data);
           }
       });
  });
  $('#reset').click(function(){
    $('#result').hide();
  })
});
