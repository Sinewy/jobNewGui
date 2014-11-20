<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/20/14
 * Time: 11:12
 */

require_once("includes/session.php");
require_once("includes/dbc.php");
require_once("includes/setLanguage.php");
require_once("includes/globalFunctions.php");

if(isset($_SESSION["language"])) {
    $_SESSION["language"] = null;
}

confirmActivated();

?>
