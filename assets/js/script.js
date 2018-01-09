$(function () {
    'use strict'

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.row-offcanvas').toggleClass('active')
    })

    $('#uploadIcon').change(function(e) {
        var preview = document.getElementById('preview-icon');
        var file = e.target.files[0]; //sames as here
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src =  reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL
        } else {
            preview.src = "";
        }
    });
});