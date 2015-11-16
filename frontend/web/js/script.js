$(document).ready(function(){

    $(".numericOnly").numeric();

    $(document).on('click', '.create-category', function(){
        $('.new-category').slideToggle('fast');
        $('.select-category').slideToggle('fast');
        $('.select-category').val('');
    })

    $(document).on('change', '.select-category' , function(){
        $('.new-category > input[type="text"]').val('');
    });

});

