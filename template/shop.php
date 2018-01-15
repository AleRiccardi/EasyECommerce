<?php

$currentPage = null;

if (isset($_GET['category'])) {
    $currentPage = $_GET['category'];

    require_once($baseController->website_path . "/template/shop/category.php");

} else {
    require_once($baseController->website_path . "/template/_header.php");

    ?>

    <main role="main" class="page container">

        <div class="row row-offcanvas row-offcanvas-right">

            <div class="col-12 col-md-9">
                <p class="float-right d-md-none">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <div class="jumbotron j-shop"
                     style="background-image:
                             linear-gradient(to bottom, rgba(0,0,0,.20), rgba(0,0,0,.30)),
                             linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.05) 25%,
                             rgba(0,0,0,0.5) 75%, rgba(0,0,0,0.8) 100%),
                             url('<?php echo $baseController->website_url ?>/assets/img/blur-food.jpg');">
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
                <div class="row featurette middle-h-cont">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Cake <span class="text-muted">Category</span></h2>
                        <p class="lead">For over 2000 years, rice has been the most important food in Japanese cuisine.
                            Despite changes in eating patterns over the last few decades and slowly decreasing rice
                            consumption in recent years, rice remains one of the most important ingredients in Japan
                            today.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the chocolate</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/cat-cake.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Seafood -->
                <div class="row featurette middle-h-cont">
                    <div class="col-md-7 order-md-2 middle-h-item">
                        <h2 class="featurette-heading">Cookies <span class="text-muted">Category</span></h2>
                        <p class="lead">Hundreds of different fish, shellfish and other seafood from the oceans, seas,
                            lakes and rivers are used in the Japanese cuisine. They are prepared and eaten in many
                            different ways, such as raw, dried, boiled, grilled, deep fried or steamed.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the chocolate</a>

                    </div>
                    <div class="col-md-5 order-md-1 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/chocolate-chip.jpg">
                    </div>
                </div>

                <hr class="featurette-divider">

                <!-- Rice -->
                <div class="row featurette middle-h-cont">
                    <div class="col-md-7 middle-h-item">
                        <h2 class="featurette-heading">Sweets <span class="text-muted">Category</span></h2>
                        <p class="lead">For over 2000 years, rice has been the most important food in Japanese cuisine.
                            Despite changes in eating patterns over the last few decades and slowly decreasing rice
                            consumption in recent years, rice remains one of the most important ingredients in Japan
                            today.</p>
                        <a class="btn btn-primary btn-sm" href="#" role="button">See the chocolate</a>

                    </div>
                    <div class="col-md-5 middle-h-item cont-featurette-image">
                        <img class="featurette-image img-fluid mx-auto" alt="500x500"
                             src="<?php echo $baseController->website_url ?>/assets/img/pastry.jpg">
                    </div>
                </div>
            </div><!--/span-->

            <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop"
                       class="list-group-item active">Shop</a>
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop&category=rice" class="list-group-item">Cake</a>
                    <a href="#" class="list-group-item">Cookies</a>
                    <a href="#" class="list-group-item">Sweets</a>
                </div>
            </div><!--/span-->
        </div><!--/row-->

    </main>

    <?php

    require_once($baseController->website_path . "/template/_footer.php");

}