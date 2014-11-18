<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/18/14
 * Time: 15:27
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["colorName"]) && isset($_POST["productId"])) {
    $colorName = $_POST["colorName"];
    $productId = $_POST["productId"];
    $out = [];
    $result = findCollectionsForColorAndProduct($colorName, $productId);
    foreach($result as $key => $value) {
        $out[$key] = $value;
    }
    echo json_encode($out);
}