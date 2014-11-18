<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/18/14
 * Time: 12:00
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["colorName"]) && isset($_POST["productId"]) && isset($_POST["collectionId"])) {
    $colorName = $_POST["colorName"];
    $productId = $_POST["productId"];
    $collectionId = $_POST["collectionId"];
    $result = findFormulaIdForColorProductCollection($colorName, $productId, $collectionId);
    echo json_encode($result);
}
