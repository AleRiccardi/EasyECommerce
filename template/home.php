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
                            We're working in the chocolate sector for more of 30 years and we know how to prepare the
                            best sweets, to bring to your department and to make you say "Ohhh, that's soo good".
                        </p>
                    </div>
                </div>
                <div class="col-5 col-md-4 flex-container-center hs-second-img">
                    <div class="flex-item-center pl-5 pr-5">
                        <img width="100%" src="<?php echo $baseController->website_url ?>/assets/img/icon/chocolate.png"
                             alt="Chocolate heart">
                    </div>
                </div>
                <div class="col-12 col-md-4 flex-container-center">
                    <div class="flex-item-center">
                        <p>
                            We prepare all our sweets the day before to permit to have always the best quality for you!
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
