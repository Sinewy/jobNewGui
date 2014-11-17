<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/17/14
 * Time: 11:57
 */
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

// ********************** Database queries **********************\\

function findAllProducts() {
    global $connection;
    $query  = "SELECT * ";
    $query .= "FROM v_products ";
    $query .= "ORDER BY name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllProductsForCollection($collectionId) {
    global $connection;
    $query  = "SELECT distinct p.name, p.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN v_collections c ON (c.id = f.collections_id) ";
    $query .= "INNER JOIN v_products p ON (p.id = f.products_id) ";
    $query .= "WHERE c.id = {$collectionId} ";
    $query .= "ORDER BY name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllCollections() {
    global $connection;
    $query  = "SELECT * ";
    $query .= "FROM v_collections ";
    $query .= "ORDER BY name ASC";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function findAllCollectionsForProduct($productId) {
    global $connection;
    $query  = "SELECT distinct c.name, c.id ";
    $query .= "FROM formulas f ";
    $query .= "INNER JOIN v_collections c ON (c.id = f.collections_id) ";
    $query .= "INNER JOIN v_products p ON (p.id = f.products_id) ";
    $query .= "WHERE p.id = {$productId} ";
    $query .= "ORDER BY name ASC";
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