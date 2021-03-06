<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/17/14
 * Time: 11:57
 */

// ********************** Global variables **********************\\
$dispenserGroupId = 1;
$dispenserSystemId = 9;

//$dispenserGroupId = findDispenseGroupSystemCountry()["dispenserGroupId"];
//$dispenserSystemId = findDispenseGroupSystemCountry()["dispenserSystemId"];
//$countryId = findDispenseGroupSystemCountry()["countryId"];

function findDispenseGroupSystemCountry() {
    global $connection;
    $query = "SELECT  * ";
    $query .= "FROM settings ";
    $query .= "WHERE id = 1 ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if($data = mysqli_fetch_assoc($result)) {
        return $data;
    } else {
        return null;
    }
}




// ********************** Utility functions **********************\\

function redirectTo($newLocation) {
    header("Location: " . $newLocation);
    exit;
}

function confirmQuery($resultSet) {
    global $connection;
    if (!$resultSet) {
        echo mysqli_error($connection);
        die("Database query failed.");
    }
}

//******************* Activation Functions END *********************\\

function isActivated() {
    if(findDeviceInfo()["status"] == 1) {
        return true;
    } else {
        return false;
    }
}

function confirmActivated() {
    if (isActivated()) {
        redirectTo("jumix.php");
    } else {
        redirectTo("chooseLanguage.php");
    }
}

function confirmActivatedOnJumix() {
    if (!isActivated()) {
        redirectTo("index.php");
    }
}

//******************* Activation Functions END *********************\\

// ********************** Database queries **********************\\

function findDeviceInfo() {
    global $connection;
    $query  = "SELECT * ";
    $query .= "FROM device_info ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if($device = mysqli_fetch_assoc($result)) {
        return $device;
    } else {
        return null;
    }
}

function findAllProducts() {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT p.name, p.id ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "ORDER BY p.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllProductsForCollection($collectionId) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT p.name, p.id ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections c ON (c.id = f.collections_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "AND c.id = {$collectionId} ";
    $query .= "ORDER BY p.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllCollections() {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT c.name, c.id ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN collections c ON (c.id = f.collections_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "ORDER BY c.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllCollectionsForProduct($productId) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT c.name, c.id ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN collections c ON (c.id = f.collections_id) ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "AND p.id = {$productId} ";
    $query .= "ORDER BY c.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllCanSizesForProduct($productId) {
    global $connection;
    $query  = "SELECT c.name, c.id ";
    $query .= "FROM products_has_cansizes pc ";
    $query .= "INNER JOIN products p ON (p.id = pc.products_id) ";
    $query .= "INNER JOIN cansizes c ON (c.id = pc.cansizes_id) ";
    $query .= "WHERE p.id = {$productId} ";
    $query .= "ORDER BY c.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAppropriateColors($searchString, $productId, $collectionId) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT c.name_short ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    if($productId != -1) {
        $query .= "AND p.id = {$productId} ";
    }
    if($collectionId != -1) {
        $query .= "AND coll.id = {$collectionId} ";
    }
    $query .= "AND c.name_short LIKE '{$searchString}%' ";
    $query .= "ORDER BY c.name_short ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findFormulaIdForColorProductCollection($colorName, $productId, $collectionId) {
    global $connection;
    $query  = "SELECT f.formulas_id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "WHERE p.id = {$productId} ";
    $query .= "AND coll.id = {$collectionId} ";
    $query .= "AND c.name_short = '{$colorName}' ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if($id = mysqli_fetch_assoc($result)) {
        return $id;
    } else {
        return null;
    }
}

function findProductsForColorAndCollection($colorName, $collectionId) {
    global $connection;
    $query  = "SELECT p.name, p.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "WHERE coll.id = {$collectionId} ";
    $query .= "AND c.name_short = '{$colorName}' ";
    $query .= "ORDER BY p.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findCollectionsForColorAndProduct($colorName, $productId) {
    global $connection;
    $query  = "SELECT coll.name, coll.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "WHERE p.id = {$productId} ";
    $query .= "AND c.name_short = '{$colorName}' ";
    $query .= "ORDER BY coll.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findProductsForColor($colorName) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT p.name, p.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "INNER JOIN formulas_has_dispenser_groups fg ON (fg.formulas_id = f.formulas_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "AND c.name_short = '{$colorName}' ";
    $query .= "ORDER BY p.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findCollectionsForColor($colorName) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT DISTINCT coll.name, coll.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "INNER JOIN formulas_has_dispenser_groups fg ON (fg.formulas_id = f.formulas_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    $query .= "AND c.name_short = '{$colorName}' ";
    $query .= "ORDER BY coll.name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findDataForSelectedColor($formulaId) {
    global $connection;
    $query  = "SELECT p.name as productName, b.name as baseName, b.ID as baseId, coll.name as collectionName, ";
    $query  .= "c.name_short as colorName, c.R as colorR, c.G as colorG, c.B as colorB, f.sustrate, f.WARNING_MESSAGE, f.COMMENTS ";
    $query  .= "FROM formulas f ";
    $query  .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query  .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query  .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query  .= "INNER JOIN bases b ON (b.ID = f.bases_id) ";
    $query  .= "WHERE f.formulas_id = {$formulaId} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if($data = mysqli_fetch_assoc($result)) {
        return $data;
    } else {
        return null;
    }
}

function findColorantsForSelectedColor($formulaId) {
    global $connection;
    $query = "SELECT c.name as name, c.R as colorantR, c.G as colorantG, c.B as colorantB ";
    $query .= "FROM formulas_has_colorants f ";
    $query .= "INNER JOIN colorants c ON (c.id = f.colorants_id) ";
    $query .= "WHERE f.formulas_id = {$formulaId} ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAvailableColors($productId, $collectionId) {
    global $connection;
    global $dispenserGroupId;
    global $dispenserSystemId;
    $query  = "SELECT f.formulas_id as formulaId, c.name_short as colorName, c.R as colorR, c.G as colorG, c.B as colorB ";
    $query .= "FROM formulas_has_dispenser_groups fg ";
    $query .= "INNER JOIN formulas f ON (f.formulas_id = fg.formulas_id) ";
    $query .= "INNER JOIN products p ON (p.id = f.products_id) ";
    $query .= "INNER JOIN collections coll ON (coll.id = f.collections_id) ";
    $query .= "INNER JOIN colors c ON (c.id = f.colors_id) ";
    $query .= "WHERE fg.dispenser_groups_id = {$dispenserGroupId} ";
    $query .= "AND fg.dispenser_systems_id = {$dispenserSystemId} ";
    if($productId != -1) {
        $query .= "AND p.id = {$productId} ";
    }
    if($collectionId != -1) {
        $query .= "AND coll.id = {$collectionId} ";
    }
    $query .= "ORDER BY c.name_short ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findDispenserSystems() {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM dispensers_systems ";
    $query .= "ORDER BY name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function rememberActivationCode($activationCode) {
    global $connection;
    $query  = "UPDATE settings ";
    $query  .= "SET apikey = '{$activationCode}' ";
    $query  .= "WHERE id = 1 ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
}

function findApiKey() {
    global $connection;
    $query = "SELECT  apikey ";
    $query .= "FROM settings ";
    $query .= "WHERE id = 1 ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if($data = mysqli_fetch_assoc($result)) {
        return $data["apikey"];
    } else {
        return null;
    }
}

function activateLocally($remoteId) {
    global $connection;
    $query = "UPDATE device_info SET ";
    $query .= "status = '1' ";
    $query .= "WHERE remoteId = '{$remoteId}' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return true;
}

// ********************** View functions **********************\\

function showProductOptions($key) {
    if($key == "all") {
        $dataSet = findAllProducts();
    } else {
        $dataSet = findAllProductsForCollection($key);
    }
    $output = "";
    $output .= "<option value='-1'>&nbsp;</option>>";
    if (mysqli_num_rows($dataSet) > 0) {
        while ($data = mysqli_fetch_assoc($dataSet)) {
            $output .= "<option value='" . $data["id"] . "'>";
            $output .= $data["name"];
            $output .= "</option>";
        }
    }
    return $output;
}

function showCollectionOptions($key) {
    if($key == "all") {
        $dataSet = findAllCollections();
    } else {
        $dataSet = findAllCollectionsForProduct($key);
    }
    $output = "";
    $output .= "<option value='-1'>&nbsp;</option>>";
    if (mysqli_num_rows($dataSet) > 0) {
        while ($data = mysqli_fetch_assoc($dataSet)) {
            $output .= "<option value='" . $data["id"] . "'>";
            $output .= $data["name"];
            $output .= "</option>";
        }
    }
    return $output;
}

function showCanSizeOptions($productId) {
    $dataSet = findAllCanSizesForProduct($productId);
    $output = "";
    $output .= "<option value='-1'>&nbsp;</option>";
    if (mysqli_num_rows($dataSet) > 0) {
        while ($data = mysqli_fetch_assoc($dataSet)) {
            $output .= "<option value='" . $data["id"] . "'>";
            $output .= $data["name"];
            $output .= "</option>";
        }
    }
    return $output;
}

function showAvailableColors($productId, $collectionId) {
    $dataSet = findAvailableColors($productId, $collectionId);
    $output = "";
    if (mysqli_num_rows($dataSet) > 0) {
        while ($data = mysqli_fetch_assoc($dataSet)) {

            $hexcolor = makeHexColorFromRgb($data["colorR"], $data["colorG"], $data["colorB"]);

            $output .= "<div class='colorSwatch left' style='background-color: #" . $hexcolor. "' id='" . $data["formulaId"] . "'>";
            $output .= "<div class='colorSwatchName'>" . $data["colorName"] . "</div>";
            $output .= "</div>";
        }
    }
    return $output;
}

function showDispenserSystemOptions() {
    $dataSet = findDispenserSystems();
    $output = "";
    $output .= "<option value='-1'>&nbsp;</option>";
    if (mysqli_num_rows($dataSet) > 0) {
        while ($data = mysqli_fetch_assoc($dataSet)) {
            $output .= "<option value='" . $data["id"] . "'>";
            $output .= $data["name"];
            $output .= "</option>";
        }
    }
    return $output;
}

function makeHexColorFromRgb($r, $g, $b) {

    $rHex = dechex($r);
    $gHex = dechex($g);
    $bHex = dechex($b);

    $rHex = strlen($rHex) < 2 ? "0" . $rHex : $rHex;
    $gHex = strlen($gHex) < 2 ? "0" . $gHex : $gHex;
    $bHex = strlen($bHex) < 2 ? "0" . $bHex : $bHex;

    return $rHex . $gHex . $bHex;
}
