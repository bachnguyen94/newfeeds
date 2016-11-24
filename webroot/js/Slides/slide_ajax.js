$("document").ready(function() {
    $("select[name='table_name']").on('change', function(){
        if($(this).val()){
            $.ajax({
                url : BASE_URL + 'admin/slides/getAjax',
                data : {
                    'model_index' : $(this).val(),
                },
                dataType : 'JSON',
                type : 'POST',
                success: function(data){
                    $('#appendRecord').empty();
                    $.each(data, function(key, value){
                        $('#appendRecord').append("<option value='"+ key +"'>"+ value +"</option>")
                    });
                }
            })
        }
    });
});