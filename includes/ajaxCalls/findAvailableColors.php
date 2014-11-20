<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/20/14
 * Time: 8:01
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["productId"]) && isset($_POST["collectionId"])) {
    $productId = $_POST["productId"];
    $collectionId = $_POST["collectionId"];
    echo showAvailableColors($productId, $collectionId);
}