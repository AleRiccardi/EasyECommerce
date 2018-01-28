<?php

$currentPage = null;

$categories = \Inc\Database\DbCategory::getAll('object');

require_once($baseController->website_path . "/template/_header.php");

?>

    <main role="main" class="page container">

        <div class="row row-offcanvas row-offcanvas-right">

            <div class="col-12 col-md-9">
                <p class="float-right d-md-none">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">All category</button>
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

                <?php
                $i = 0;
                foreach ($categories as $category) {
                    $image = \Inc\Database\DbImage::getSingle(["id" => $category->idImage], 'object');
                    $imagePath = $image ? $image->path : "/assets/img/no-image.jpg";
                    ?>
                    <!-- Category -->
                    <div class="row featurette middle-h-cont">
                        <div class="col-md-7 <?php echo $i % 2 ? "order-md-2" : ""; ?> middle-h-item">
                            <h2 class="featurette-heading"><?php echo $category->title; ?>
                                <!--<span class="text-muted">Category</span>--></h2>
                            <p class="lead"><?php echo $category->description; ?></p>
                            <a class="btn btn-primary btn-sm"
                               href="page.php?name=category&category=<?php echo $category->slug; ?>" role="button">See the
                                chocolate</a>
                        </div>
                        <div class="col-md-5 <?php echo $i % 2 ? "order-md-1 " : ""; ?> middle-h-item cont-featurette-image">
                            <img class="featurette-image img-fluid mx-auto" alt="<?php echo $category->title; ?>"
                                 src="<?php echo $baseController->website_url . $imagePath; ?>">
                        </div>
                    </div>

                    <?php

                    if (($i + 1 < count($categories))) {
                        echo "<hr class='featurette-divider'>";
                    }
                    $i++;
                }
                ?>

            </div><!--/span-->

            <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop"
                       class="list-group-item active">Shop</a>
                    <?php
                    $i = 0;
                    foreach ($categories as $category) { ?>
                        <a href="<?php echo $baseController->website_url . "/page.php?name=category&category=" . $category->slug; ?>"
                           class=" list-group-item"><?php echo $category->title; ?></a>
                    <?php } ?>
                </div>
            </div><!--/span-->
        </div><!--/row-->

    </main>

<?php

require_once($baseController->website_path . "/template/_footer.php");

