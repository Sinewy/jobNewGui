<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/18/14
 * Time: 16:23
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["colorName"])) {
    $colorName = $_POST["colorName"];
    $out = [];
    $pout = [];
    $result = findProductsForColor($colorName);
    foreach($result as $key => $value) {
        $pout[$key] = $value;
    }
    $cout = [];
    $result = findCollectionsForColor($colorName);
    foreach($result as $key => $value) {
        $cout[$key] = $value;
    }
    $out[0] = $pout;
    $out[1] = $cout;
    echo json_encode($out);
}
