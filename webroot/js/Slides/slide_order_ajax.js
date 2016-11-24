$("document").ready(function() {
    $("select[name='display_order']").on('change', function(){
        var id = $(this).parent().parent().parent().attr('id');
        if($(this).val()) {
            $.ajax({
                url: BASE_URL + 'admin/slides/getOrder',
                data: {
                    'display_order': $(this).val(),
                    'id' : id
                },
                dataType: 'JSON',
                type: 'POST',
                success: function (data) {
                    console.log('1');
                     location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }
    });
});

$("document").ready(function() {
    $("select[name='status']").on('change', function(){
        var id = $(this).parent().parent().parent().attr('id');
        if($(this).val()) {
            $.ajax({
                url: BASE_URL + 'admin/slides/getStatus',
                data: {
                    'status': $(this).val(),
                    'id' : id
                },
                dataType: 'JSON',
                type: 'POST',
                success: function (data) {
                    location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }
    });
});