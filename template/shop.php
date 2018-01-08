<?php

$currentPage = null;

if (isset($_GET['category'])) {
    $currentPage = $_GET['category'];

    require_once($baseController->website_path . "/template/shop/category.php");

} else {
    require_once($baseController->website_path . "/template/_header.php");

    ?>

    <main role="main" class="page-shop container">

        <div class="row row-offcanvas row-offcanvas-right">

            <div class="col-12 col-md-9">
                <p class="float-right d-md-none">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <div class="jumbotron"
                     style="background-image:
                             linear-gradient(to bottom, rgba(0,0,0,.20), rgba(0,0,0,.30)),
                             linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.05) 25%, rgba(0,0,0,0.5) 75%, rgba(0,0,0,0.8) 100%),
                             url('<?php echo $baseController->website_url ?>/assets/img/eating-sushi.jpg');">
                    <h1>Shop</h1>
                    <p>
                        The Japanese cuisine offers a great variety of dishes and regional specialties.
                        Some of the most popular Japanese dishes are listed below. They are categorized below into rice
                        dishes,
                        seafood dishes, noodle dishes, nabe dishes, meat dishes, soybean dishes, yoshoku dishes and
                        other dishes.
                        Please note that some dishes may fit into multiple categories, but are listed only once.
                    </p>
                </div>

                <!-- Rice -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Rice <span class="text-muted">Dishes</span></h2>
                        <p class="lead">For over 2000 years, rice has been the most important food in Japanese cuisine.
                            Despite changes in eating patterns over the last few decades and slowly decreasing rice
                            consumption in recent years, rice remains one of the most important ingredients in Japan
                            today.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Seafood -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 order-md-2 middle-h-item">
                        <h2 class="featurette-heading">Seafood <span class="text-muted">Dishes</span></h2>
                        <p class="lead">Hundreds of different fish, shellfish and other seafood from the oceans, seas,
                            lakes and rivers are used in the Japanese cuisine. They are prepared and eaten in many
                            different ways, such as raw, dried, boiled, grilled, deep fried or steamed.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 order-md-1 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-seafood.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Noodle -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Noodle <span class="text-muted">Dishes</span></h2>
                        <p class="lead">There are various traditional Japanese noodle dishes as well as some dishes
                            which were introduced to Japan and subsequently Japanized. Noodle dishes are very popular in
                            Japan, and are served both hot and cold depending on the season. Noodle restaurants and food
                            stands are ubiquitous, and it is common to find noodle stands along train platforms.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Nabe -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 order-md-2 middle-h-item">
                        <h2 class="featurette-heading">Nabe <span class="text-muted">Dishes</span></h2>
                        <p class="lead">Nabe, or hot pot dishes, are prepared in a hot pot, usually at the table.
                            Typical ingredients are vegetables such as negi (Japanese leek) and hakusai (Chinese
                            cabbage), various mushrooms, seafood and/or meat. There are many regional and personal
                            varieties, and they are especially popular in the cold winter months.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 order-md-1 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Meat -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Meat <span class="text-muted">Dishes</span></h2>
                        <p class="lead">Meat has been eaten in Japan in larger amounts only since the second half of the
                            19th century. Nowadays there are a variety of popular Japanese meat dishes.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Soybean -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 order-md-2 middle-h-item">
                        <h2 class="featurette-heading">Soybean <span class="text-muted">Dishes</span></h2>
                        <p class="lead">Tofu, natto, miso and many other important ingredients of Japanese cooking are
                            made of soybeans. The following are some of the most popular soybean based dishes:</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 order-md-1 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Yoshoku -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Yoshoku <span class="text-muted">Dishes</span></h2>
                        <p class="lead">A large number of Western dishes have been introduced to Japan over the
                            centuries. Many of them have become completely Japanized, and are referred to as Yoshoku
                            dishes. Some of the most popular ones are:</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Other -->
                <div class="row featurette middle-h-container">
                    <div class="col-md-7 order-md-2 middle-h-item">
                        <h2 class="featurette-heading">Other <span class="text-muted">Dishes</span></h2>
                        <p class="lead">Other dishes that could be dessert, sweets and not categorized plates.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the dishes</a>

                    </div>
                    <div class="col-md-5 order-md-1 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg">
                    </div>
                </div>
            </div><!--/span-->

            <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop"
                       class="list-group-item active">Shop</a>
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop&category=rice" class="list-group-item">Rice</a>
                    <a href="#" class="list-group-item">Seafood</a>
                    <a href="#" class="list-group-item">Noodle</a>
                    <a href="#" class="list-group-item">Nabe</a>
                    <a href="#" class="list-group-item">Meat</a>
                    <a href="#" class="list-group-item">Soybean</a>
                    <a href="#" class="list-group-item">Yoshoku</a>
                    <a href="#" class="list-group-item">Other</a>
                </div>
            </div><!--/span-->
        </div><!--/row-->

        <hr>

    </main>

    <?php

    require_once($baseController->website_path . "/template/_footer.php");

}