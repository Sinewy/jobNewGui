<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/17/14
 * Time: 12:28
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["collectionId"])) {
    $collectionId = $_POST["collectionId"];
    if($collectionId == -1) {
        echo showProductOptions("all");
    } else {
        echo showProductOptions($collectionId);
    }
}

