<?php

require_once($baseController->website_path . "/template/_header.php");
?>

<section class="flex-container-center fit-height-section home-section"
         style="background: url('<?php echo $baseController->website_url ?>/assets/img/all-chocolate.jpg');">
    <div class="flex-item-center">
        <div class="logo-container">
            <img src="<?php echo $baseController->website_url ?>/assets/img/logo-brown.png" alt="Logo">
        </div>
        <div>
            <h1 class="home-title ">Experience <br> the taste of real chocolate</h1>
        </div>
    </div>
</section>

<section class="hs-second">
    <div class="container">
        <h1 class="title">Our qualities</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 flex-container-center">
                <div class="flex-item-center">
                    <p>
                        At inceptos proin cursus integer mattis morbi urna hendrerit, eu suspendisse curae placerat consequat placerat neque, venenatis amet et erat aliquam sed praesent.
                    </p>
                </div>
            </div>
            <div class="col-5 col-md-4 flex-container-center hs-second-img">
                <div class="flex-item-center">
                    <img width="100%" src="<?php echo $baseController->website_url ?>/assets/img/icon/chocolate.png"
                         alt="Chocolate heart">
                </div>
            </div>
            <div class="col-12 col-md-4 flex-container-center">
                <div class="flex-item-center">
                    <p>
                        Commodo fames sociosqu habitasse eros aliquam hac tellus consequat augue, aenean blandit curabitur tempus fames nisi aptent cras rhoncus tempus.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="flex-container-center fit-height-section hs-third home-section"
         style="background: url('<?php echo $baseController->website_url ?>/assets/img/ice-cream.jpg');">
    <div class="flex-item-center">
        <p class="lead-home">The best shop that connect the chocolate with a simple Vespa.
        </p>
        <span class="cit-right">Rolling Stone</span>
    </div>
</section>

<?php

require_once($baseController->website_path . "/template/_footer.php");
