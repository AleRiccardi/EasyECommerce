$(function () {

    /**+**+**+**+**+**+**+**+**+**+**+**+**+**+
     * GENERAL
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/

    // #
    // # Event
    // #



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
         * update the number of the item in the cart icon of the menu
         */
        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "getNumItemsCart",
                idUser: idUser,
            }
        })
            .done(function (response) {
                if (response != 0) {
                    var header = "<span class='badge badge-primary' >" + response + "</span>";
                    $('.mc-number-item').html(header);
                    $('.cart-page-num-item').html(response);
                } else {
                    $('.mc-number-item').html("");
                    $('.cart-page-num-item').html("0");

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
            .done(function (response) {
                if (response != 0) {
                    var cartItems = $.parseJSON(response);
                    $("#append-items-cart").html("");
                    console.log(cartItems);
                    for (var i = 0; i < cartItems.length; i++) {
                        itemHtml = "<div class='dropdown-item card-item-cont'>" +
                        "           <div class='middle-h-cont mhc-height-max'>" +
                        "               <div class='card-item-img-cont middle-h-item'>" +
                        "                   <div class='middle-h-cont'>" +
                        "                       <img id='card-item-img' class='card-item-img middle-h-item'" +
                        "                           src='" + cartItems[i].imgUrl + "'" +
                        "                           alt='" + cartItems[i].title + "'>" +
                        "                   </div>" +
                        "               </div>" +
                        "               <span class='middle-h-item card-item-title' id='card-item-title'>" + cartItems[i].title + "</span>" +
                        "               &nbsp;" +
                        "               <span class='badge badge-secondary ml-auto middle-h-item' id='card-item-quantity'>" + cartItems[i].quantity + " item</span>" +
                            "          </div>" +
                            "      </div>";
                        $("#append-items-cart").append(itemHtml);
                    }
                    console.log();
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
                        action: "addItem",
                        idUser: idUser,
                        idProduct: idProdInput,
                        quantity: quantity
                    }
                })
                    .done(function (response) {
                        console.log(response);
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
     * Page CART
     +**+**+**+**+**+**+**+**+**+**+**+**+**+*/


    // #
    // # FUNCTION
    // #

    function updateQuantity(idUser, idItem, newQuantity) {
        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "changeQuantity",
                idUser: idUser,
                idItem: idItem,
                quantity: newQuantity
            }
        }).done(function (response) {
            console.log(response);
            if (response) {
                refreshCart(idUser);
                refreshReport(idUser);
                printNumItemCart(idUser);
            }
        });
    }

    function changeQuantityInputFocusOut() {
        $(".change-quantity").each(function (e) {
            var price = $(this).val();
            $(this).focusout(function () {
                var newPrice = $(this).val();
                if (price != newPrice) {
                    var idItem = $(this).data("item");
                    var idUser = $(this).data("user");
                    var quantity = $(this).val();
                    updateQuantity(idUser, idItem, quantity);
                } else {
                    $(".cont-btn-change-quantity").html("");
                }
            });
        });

    }

    function refreshCart(idUser) {
        $("#cart").fadeTo("fast", 0.33);

        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "refreshCart",
                idUser: idUser
            },

        }).done(function (response) {
            if (response) {
                $("#cart").html(response);
                $("#cart").fadeTo("slow", 1);
                changeQuantityInputFocusOut()
            }
        }).fail(function () {
            alert("error");
        });

    }

    function refreshReport(idUser) {
        $("#report").fadeTo("fast", 0.33);

        $.ajax({
            method: "POST",
            url: 'http://localhost:8888/willychock/inc/Ajax/CartAjax.php',
            data: {
                action: "refreshReport",
                idUser: idUser
            },

        }).done(function (response) {
            if (response) {
                $("#report").html(response);
                $("#report").fadeTo("slow", 1);
            }
        }).fail(function () {
            alert("error");
        });
    }

    function insertBtnUpdate(event) {
        var idItem = event.data("item");
        var idUser = event.data("user");
        var contBtn = event.parent().find(".cont-btn-change-quantity");
        if (contBtn.html() == "") {
            contBtn.parent().find(".cont-btn-change-quantity").html(
                "<button type='button' class='btn btn-warning btn-xsm btn-change-quantity' data-item='" + idItem + "' data-user='" + idUser + "'>update</button>");
        }
    }


    // #
    // # EVENT
    // #

    $(document).on("click", '.btn-trash', function (event) {
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
        }).done(function (response) {
            if (response) {
                refreshCart(idUser);
                refreshReport(idUser);
                printNumItemCart(idUser);
            }
        });

    });

    $(document).on("keyup", '.change-quantity', function (event) {
        insertBtnUpdate($(this));
        if (event.keyCode == 13) {
            var idItem = $(this).data("item");
            var idUser = $(this).data("user");
            var quantity = $(this).val();
            updateQuantity(idUser, idItem, quantity);
        }
    });

    $(document).on("click", '.btn-change-quantity', function (event) {

        var idItem = $(this).data("item");
        var idUser = $(this).data("user");

        $(".change-quantity").each(function (e) {
            if (idItem == $(this).data("item")) {
                var quantity = $(this).val();
                updateQuantity(idUser, idItem, quantity);
            }
        });


    });

    // #
    // # SEQUENTIAL CODE
    // #
    changeQuantityInputFocusOut();
});


