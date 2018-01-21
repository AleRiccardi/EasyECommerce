$(function () {

    /**+**+**+**+**+**+**+**+**+**+**+**+**+**+
     * GENERAL
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/

    // #
    // # Event
    // #

    /**
     *
     */
    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.row-offcanvas').toggleClass('active')
    })

    /**
     *
     */
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


    /**+**+**+**+**+**+**+**+**+**+**+**+**+**+
     * section CART HEADER
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/

    // #
    // # VARIABLE
    // #
    /**
     *
     * @type {jQuery}
     */
    var idUser = $('#id-user-page-cat').data("user-id");

    // #
    // # FUNCTION
    // #

    /**
     *
     * @param idUser
     */
    function printNumItemCart(idUser) {
        /**
         * update the number of the item in the cart icon
         */
        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "getNumItemCart",
                idUser: idUser,
            }
        })
            .done(function (msg) {
                if (msg != 0) {
                    msg = "<span class='badge badge-primary' >" + msg + "</span>";
                    $('.mc-number-item').html(msg);
                }
            });


    }

    function refreshCart(idUser){
        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "refreshCart",
                idUser: idUser
            }
        }).done(function (msg) {
            if(msg) {
                $("#cart").html(refreshCart);
            }
        });

    }



    // #
    // # EVENT
    // #

    $('#btn-dropdown-cart').on("click", function (e) {
        /**
         * update the number of the item in the cart icon
         */
        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "getCustomItemCart",
                idUser: idUser,
            }
        })
            .done(function (msg) {
                if (msg != 0) {
                    var cartItems = $.parseJSON(msg);
                    $("#append-items-cart").html("");
                    console.log(cartItems);
                    for (var i = 0; i < cartItems.length; i++) {
                        itemHtml = "<div class='dropdown-item card-item-cont'>" +
                            "           <div class='middle-h-cont mhc-height-max'>" +
                            "               <div class='card-item-img-cont middle-h-item'>" +
                            "                   <div class='middle-h-cont'>" +
                            "                       <img id='card-item-img' class='card-item-img middle-h-item'" +
                            "                           src='"+ cartItems[i].imgUrl +"'" +
                            "                           alt='Card image cap'>" +
                            "                   </div>" +
                            "               </div>" +
                            "               <span class='middle-h-item card-item-title' id='card-item-title'>"+ cartItems[i].title +"</span>" +
                            "               &nbsp;" +
                            "               <span class='badge badge-secondary ml-auto middle-h-item' id='card-item-quantity'>"+ cartItems[i].quantity +" item</span>" +
                            "          </div>" +
                            "      </div>";
                        $("#append-items-cart").append(itemHtml);
                    }
                    console.log();
                }
            });
    });

    $('.btn-trash').on("click", function (e) {
        var idItem = $(this).data("item");
        var idUser = $(this).data("user");

        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "trashCartItem",
                idUser: idUser,
                idItem: idItem
            }
        }).done(function (msg) {
            if(msg) {
                refreshCart(idUser);
            }
        });

    });


    // #
    // # SEQUENTIAL CODE
    // #

    // Update the number of item inside the cart
    printNumItemCart(idUser);

    /**+**+**+**+**+**+**+**+**+**+**+**+**+**+
     * Page CATEGORY
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/

    /**
     *
     */
    $('.grid').masonry({
        itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
        columnWidth: '.grid-sizer',
        percentPosition: true
    });

    // #
    // # EVENT
    // #

    /**
     * Increment or decrement the number of item to buy.
     * --> Category page
     *
     * @param el the input elem
     */
    window.inputNumber = function (el) {

        el.each(function () {
            init($(this));
        });

        function init(el) {

            var min = el.attr('min') || false;
            var max = el.attr('max') || false;

            var els = {};

            els.dec = el.prev();
            els.inc = el.next();

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


    /**
     * Category page, add product to cart.
     */
    $(".btn-add").on("click", function () {

        var idProdButton = $(this).data("prod-id");
        var el = $('.input-number');

        /**
         * loop for every input quantity
         */
        el.each(function (e) {
            var idProdInput = $(this).data("prod-id");
            // stop when the right input match with the button pressed
            if (idProdInput == idProdButton) {
                var quantity = $(this).val();
                // ajax call
                $.ajax({
                    method: "POST",
                    url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
                    data: {
                        action: "printValue",
                        idUser: idUser,
                        idProduct: idProdInput,
                        quantity: quantity
                    }
                })
                    .done(function (msg) {
                        console.log(msg);
                        $('.title-prod').each(function (e) {
                            var idProdTitle = $(this).data("prod-id");
                            if (idProdTitle == idProdButton) {
                                $('.modalTitleItem').text($(this).html());
                                $('.modal-quantity-item').text(quantity);
                                $('#modalItemAdded').modal('toggle');
                                printNumItemCart(idUser);
                            }
                        });

                    });

            }
        });


    });

    // #
    // # SEQUENTIAL CODE
    // #

    // Initialize the input number for the quantity
    // of the product
    inputNumber($('.input-number'));


    /**+**+**+**+**+**+**+**+**+**+**+**+**+**+
     * Page
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/

});


