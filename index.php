<?php
/**
 * Single page.
 */

require_once(dirname(__FILE__) . "/template/header.php");
?>

    <section class="flex-container-center home-section"
             style="background: url('<?php echo $baseController->website_url ?>/assets/img/sushi-table.jpg');">
        <div class="flex-item-center">
            <div class="logo-container">
                <img src="<?php echo $baseController->website_url ?>/assets/img/logo.png" alt="logo">
            </div>
            <div>
                <h1>Experience <br> the taste of Japan</h1>
            </div>
        </div>
    </section>

    <section class="hs-second">
        <div class="container">
            <div class="row">
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <p>
                            Sushi Lounge è il Concept Store dove
                            la tradizione della cucina asiatica
                            si unisce all'eccelenza mediterranea.
                        </p>
                    </div>
                </div>
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <img width="100%" src="<?php echo $baseController->website_url ?>/assets/img/sushi/1.png"
                             alt="Funny sushi">
                    </div>
                </div>
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <p>
                            Sushi&amp;Go è la linea di ricette
                            pensate per il Take Away.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="flex-container-center home-section hs-third"
             style="background: url('<?php echo $baseController->website_url ?>/assets/img/japan-street.jpg');">
        <div class="flex-item-center">
            <p class="lead-home">The best restaurant that connect the Japan kitchen with a simple scooter.
            </p>
            <span class="cit-right">Rolling Stone</span>
        </div>
    </section>

<?php require_once(dirname(__FILE__) . "/template/footer.php");
