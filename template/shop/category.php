<?php

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
                         url('<?php echo $baseController->website_url ?>/assets/img/cat-sushi.jpg');">
                    <h1>Rice</h1>
                    <p>For over 2000 years, rice has been the most important food in Japanese cuisine.
                        Despite changes in eating patterns over the last few decades and slowly decreasing rice
                        consumption in recent years, rice remains one of the most important ingredients in Japan
                        today.
                    </p>
                </div>
                <div class="card-columns">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $baseController->website_url ?>/assets/upload/image/ricebowl.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title that wraps to a new line</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $baseController->website_url ?>/assets/upload/image/sushi.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img" src="<?php echo $baseController->website_url ?>/assets/upload/image/fried-ric.jpg" alt="Card image">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $baseController->website_url ?>/assets/upload/image/sushi.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img" src="<?php echo $baseController->website_url ?>/assets/upload/image/fried-ric.jpg" alt="Card image">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $baseController->website_url ?>/assets/upload/image/sushi.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img" src="<?php echo $baseController->website_url ?>/assets/upload/image/fried-ric.jpg" alt="Card image">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional
                                content.</p>
                            <p class="card-text">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div><!--/span-->

            <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop"
                       class="list-group-item">Shop</a>
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=shop&category=rice" class="list-group-item active">Rice</a>
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
