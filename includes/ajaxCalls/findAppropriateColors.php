<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/17/14
 * Time: 14:41
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_GET["term"])) {
    $searchString = $_GET["term"];
    $productId = $_GET["productId"];
    $collectionId = $_GET["collectionId"];
    $result = findAppropriateColors($searchString, $productId, $collectionId);
    $data = array();
    if(mysqli_num_rows($result) > 0) {
        while($elemnt = mysqli_fetch_assoc($result)) {
            array_push($data, $elemnt["name_short"]);
        }
    }
    echo json_encode($data);
}