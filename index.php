<?php
/**
 * Single page.
 */

require_once(dirname(__FILE__) . "/template/header.php");
?>

    <section class="flex-container-center hs-first">
        <div class="flex-item-center">
            <div class="logo-container">
                <img src="<?php echo $baseController->website_url ?>/assets/img/Logo.png" alt="logo">
            </div>
            <div>
                <h1>Experience <br> the taste of Japan</h1>
            </div>
        </div>
    </section>

    <section class="flex-container-center">
        <div class="container flex-item-center">
            <div class="row">
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <p id="p1">
                            Sushi Lounge è il Concept Store dove
                            la tradizione della cucina asiatica
                            si unisce all'eccelenza mediterranea.
                        </p>
                        <p>SCOPRI DI PIÙ ></p>
                    </div>
                </div>
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <img width="100%" src="<?php echo $baseController->website_url ?>/assets/img/sushi/1.png"
                             alt="rotoli-di-sushi-con-illustrazione-del-gamberetto-su-fondo-bianco">
                    </div>
                </div>
                <div class="col-4 flex-container-center">
                    <div class="flex-item-center">
                        <p id="p2">Sushi&amp;Go è la linea di ricette
                            pensate per il Take Away.</p>
                        <p>SCOPRI DI PIÙ ></p>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?php require_once(dirname(__FILE__) . "/template/footer.php");
