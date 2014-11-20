<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/19/14
 * Time: 10:52
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["productId"]) && isset($_POST["collectionId"]) && isset($_POST["formulaId"])) {
    $productId = $_POST["productId"];
    $collectionId = $_POST["collectionId"];
    $formulaId = $_POST["formulaId"];
    $out = [];
    $result = findDataForSelectedColor($formulaId);
    $out["colorData"] = $result;
    $colorants = [];
    $result = findColorantsForSelectedColor($formulaId);
    foreach($result as $key => $value) {
        $colorants[$key] = $value;
    }
    $out["colorantData"] = $colorants;
    echo json_encode($out);
}