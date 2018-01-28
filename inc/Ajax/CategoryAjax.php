<?php
/**
 * Ajax class that wrap all the function inherent to
 * the category page.
 * The class start with the creation of the instance
 * in the bottom of the file.
 */

namespace Inc\Ajax;

use Inc\Utils\Item;

include("AjaxEngine.php");

class CategoryAjax extends AjaxEngine {

    public function getFilteredItems() {
        $idCategory = $this->get("idCategory");
        $filterDate = $this->get('filterDate');
        $filterPrice = $this->get('filterPrice');
        $filterTitle = $this->get('filterTitle');
        echo Item::getHTMLFiltredItems($idCategory, $filterDate, $filterPrice, $filterTitle);
    }
}


$init = new CategoryAjax();