<?php
require_once($baseController->website_path . "/template/_header.php");
?>
<div class="page-404 fit-height-section">
    <section class="flex-container-center fit-height-section">
        <div class="flex-item-center">
            <div class="icon-container">
                <img src="<?php echo $baseController->website_url ?>/assets/img/icon/error-404.png" alt="Error 404">
            </div>
            <div>
                <h1>Sorry</h1>
                <h3>we couldn't find that page</h3>
            </div>
        </div>
    </section>
</div>
<?php
require_once($baseController->website_path . "/template/_footer.php");
