<?php

require_once($baseController->website_path . "/template/_header.php");
?>

    <main role="main" class="page container fit-height-section">
        <div class="row justify-content-between">
            <div class="col-md-7">
                <h2 class="mb-3">Billing address</h2>
                <div id="cart" class="container">
                    <div class="selected-product row">
                        <div class="col-2 middle-h-cont item-thumbnail">
                            <a href="soft-kitty-singing-plush.html" class="next-previous-assigned">
                                <style>
                                    #bi4f5f529593dc4cce44ac4fe27559859d {
                                        background-image: url(data:image/jpeg;base64,);
                                        background-size: cover;
                                    }
                                </style>
                                <img id="bi4f5f529593dc4cce44ac4fe27559859d"
                                     src="//demostore.x-cart.com/var/images/product/80.80/ea67_soft_kitty_singing_plush.jpeg"
                                     alt="Soft Kitty Singing Plush [Sale] [Reviews]" width="80"
                                     height="63" data-max-width="80" data-max-height="80"
                                     data-is-default-image=""
                                     srcset="https://demostore.x-cart.com/var/images/product/160.160/ea67_soft_kitty_singing_plush.jpeg 2x">
                            </a>
                        </div>
                        <div class="col-4 middle-h-cont item-info">
                            <p class="item-title middle-h-item">
                                <a href="soft-kitty-singing-plush.html" class="next-previous-assigned">
                                    KitKat
                                </a>
                            </p>
                        </div>
                        <div class="col-4 middle-h-cont item-price ">
                            <div class="middle-h-item">
                                    <span class="surcharge">

                                    <span class="surcharge-cell"><span class="part-prefix">€</span><span
                                                class="part-integer">23</span><span
                                                class="part-decimalDelimiter">.</span><span
                                                class="part-decimal">19</span></span>
                                    </span>
                                <input>
                            </div>
                        </div>
                        <div class="col-1 middle-h-cont item-remove delete-from-list">

                            <form action="?" method="post" accept-charset="utf-8"
                                  onsubmit="javascript: return true;"
                                  class="middle-h-item">
                                <div class="form-params" style="display: none;">
                                    <input type="hidden" name="target" value="cart">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="cart_id" value="531">
                                    <input type="hidden" name="returnURL" value="/?target=cart">
                                </div>
                                <a onclick="return jQuery(this).closest('form').submit();"
                                   class="remove next-previous-assigned">remove</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="cart-buttons">
                    <form action="?" method="post" accept-charset="utf-8"
                          onsubmit="javascript: return true;" class="form5a61da549d9735.00068262"
                          id="form-1516362326508">
                        <div class="form-params" style="display: none;">
                            <input type="hidden" name="target" value="cart">
                            <input type="hidden" name="action" value="clear">
                            <input type="hidden" name="returnURL" value="/?target=cart">
                        </div>
                        <a href="?target=cart&amp;action=clear"
                           onclick="javascript: return confirm('Are you sure you want to clear your cart?') &amp;&amp; !jQuery(this).parents('form').eq(0).submit();"
                           class="clear-bag">Empty your cart</a>
                    </form>
                </div>
            </div>


            <div class="col-md-4 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your report</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Subtotal</h6>

                        </div>
                        <span class="text-muted">€200</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Shipping cost:</h6>
                            <ul class="shipping-info-cart">
                                <li>
                                    Department: Informatics
                                </li>
                                <li>
                                    Class: A1
                                </li>
                                <li>
                                    <small class="text-muted"><a href="#">Change destiation</a></small>
                                </li>
                            </ul>
                        </div>
                        <span class="text-muted">€5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <span>Total (EUR)</span>
                        <strong>€20</strong>
                    </li>
                    <a href="#" class="list-group-item go-to-checkout">
                        <span>Go to checkout</span>
                    </a>
                </ul>
            </div>
        </div>

    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
