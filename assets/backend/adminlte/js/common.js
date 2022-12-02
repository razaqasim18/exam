

jQuery(document).ready(function(){

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
	
    //Colorpicker
    $(".colorpicker").colorpicker();
	
});

// Use for upload image show on the same page 
function readURL(input, id, limit, allow_type) {

    var type = input.files[0].type.split('/').pop().toLowerCase();
    var ValidImageTypes = allow_type.split("|");

    if ($.inArray(type, ValidImageTypes) < 0) {
        alert('File type ('+type+') is not supported. The file type allowed ('+ValidImageTypes+')');
        input.value = ''; 
    }else{

        var size = input.files[0].size;
        var file_size = Math.round(size/1024);
         
        if(file_size < limit){
           
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery('#preview_'+id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }else{
            alert('File size ('+file_size+'KB) is too large. The maximum file size allowed '+limit+'KB');
            input.value = ''; 
        }

    }
 
}





