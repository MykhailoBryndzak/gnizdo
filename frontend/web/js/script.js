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

function updateData(id) {


        $.ajax({
            method: "POST",
            dataType: 'html',
            url: "/costs/update",
            data: {id: id[1]},
            success: function (msg) {

                $('#osx-modal-data').html(msg);


                $('#idTourDateDetails').datepicker({
                    dateFormat: 'yy-mm-dd',
                    //minDate: '+5d',
                    changeMonth: true,
                    changeYear: true,
                    altField: "#idTourDateDetailsHidden",
                    altFormat: "yy-mm-dd"
                });

            }

        });
}

function createData(){
    $.ajax({
        method: "POST",
        dataType: 'html',
        url: "/costs/add",
        //data: {id: id[1]},
        success: function (msg) {

            $('#osx-modal-data').html(msg);


            $('#idTourDateDetails').datepicker({
                dateFormat: 'yy-mm-dd',
                //minDate: '+5d',
                changeMonth: true,
                changeYear: true,
                altField: "#idTourDateDetailsHidden",
                altFormat: "yy-mm-dd"
            });

        }

    });
}

function showModal(OSX){
    $("#osx-modal-content").modal({
        overlayId: 'osx-overlay',
        containerId: 'osx-container',
        closeHTML: null,
        minHeight: 80,
        opacity: 65,
        position: ['0',],
        overlayClose: true,
        onOpen: OSX.open,
        onClose: OSX.close
    });
}