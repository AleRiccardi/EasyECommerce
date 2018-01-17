$(function () {
    $('.grid').masonry({
        itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
        columnWidth: '.grid-sizer',
        percentPosition: true
    });

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.row-offcanvas').toggleClass('active')
    })

    $('#uploadIcon').change(function (e) {
        var preview = document.getElementById('preview-icon');
        var file = e.target.files[0]; //sames as here
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL
        } else {
            preview.src = "";
        }
    });


    window.inputNumber = function (el) {

        var min = el.attr('min') || false;
        var max = el.attr('max') || false;

        var els = {};

        els.dec = el.prev();
        els.inc = el.next();

        el.each(function () {
            init($(this));
        });

        function init(el) {

            els.dec.on('click', decrement);
            els.inc.on('click', increment);

            function decrement() {
                var value = el[0].value;
                value--;
                if (!min || value >= min) {
                    el[0].value = value;
                }
            }

            function increment() {
                var value = el[0].value;
                value++;
                if (!max || value <= max) {
                    el[0].value = value++;
                }
            }
        }
    }

    inputNumber($('.input-number'));
});


