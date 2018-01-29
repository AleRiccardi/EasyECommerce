$(function () {
    'use strict'

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.row-offcanvas').toggleClass('active')
    })

    $('#uploadImgCat').change(function(e) {
        var preview = document.getElementById('previewCat');
        var btnRemove = document.getElementById('removeImgCat');
        var file = e.target.files[0]; //sames as here
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src =  reader.result;
        }, false);


        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL

            preview.classList.remove('admin-hide');
            btnRemove.classList.remove('admin-hide');
        } else {
            //preview.src = "";
        }
    });

    $('#removeImgCat').on('click', function () {
        var preview = document.getElementById('previewCat');
        var btnRemove = document.getElementById('removeImgCat');
        var fileSelector = $("#uploadImgCat");
        var hiddenImageExist = document.getElementById("image-exist");

        fileSelector.val("");
        preview.classList.add("admin-hide");
        btnRemove.classList.add('admin-hide');
        hiddenImageExist.remove();

    });
});