<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/17/14
 * Time: 12:28
 */

require_once("../dbc.php");
require_once("../globalFunctions.php");

if(isset($_POST["productId"])) {
    $productId = $_POST["productId"];
    if($productId == -1) {
        echo "<option value='-1'>&nbsp;</option>";
    } else {
        echo showCanSizeOptions($productId);
    }
}

