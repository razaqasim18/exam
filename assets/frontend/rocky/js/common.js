/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	
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



