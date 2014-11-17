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

}


if(isset($_GET["term"])) {
//    syslog(LOG_WARNING, "We are inside IF");
    $searchString = $_GET["term"];
    $result = findAllProductsWithFilter($searchString);
    $data = array();
    if(mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
//            syslog(LOG_WARNING, $product);
//            $data[$product["id"]] = $product["name"];
//            array_push($data, $product);
            array_push($data, $product["name"]);
        }
    }
//    syslog(LOG_WARNING, listArray($data, " - data"));
    echo json_encode($data);
//    echo json_encode($result);
//    echo $result;
}



//var_dump($_GET["term"]);

//echo $_GET["term"];
echo json_encode($_GET["collectionId"]);

//if(isset($_POST["collectionId"])) {
//    $collectionId = $_POST["collectionId"];
//    if($collectionId == -1) {
//        echo showProductOptions("all");
//    } else {
//        echo showProductOptions($collectionId);
//    }
//}
