<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/18/14
 * Time: 12:50
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["colorName"]) && isset($_POST["collectionId"])) {
    $colorName = $_POST["colorName"];
    $collectionId = $_POST["collectionId"];
    $out = [];
    $result = findProductsForColorAndCollection($colorName, $collectionId);
    foreach($result as $key => $value) {
        $out[$key] = $value;
    }
    echo json_encode($out);
}