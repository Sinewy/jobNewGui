<?php
/**
 * Created by IntelliJ IDEA.
 * User: jurez
 * Date: 11/20/14
 * Time: 11:21
 */
?>

<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbc.php"); ?>
<?php require_once("includes/languages/en-US.php"); ?>
<?php require_once("includes/globalFunctions.php"); ?>
<?php require_once("includes/formValidationFunctions.php"); ?>

<?php

$showLanguages = "";

if(isset($_POST["chooseLanguage"])) {
    if(isset($_POST["lang"])) {
        $choosenLang = $_POST["lang"];
        $_SESSION["language"] = $choosenLang;
        setChoosenLanguage($choosenLang);
        redirectTo("activateDevice.php");
    } else {
        $showLanguages = redrawLangugesView();
        $errors["chooseLang"] = $lang["Please select your language."];
    }
} else {
    $showLanguages = redrawLangugesView();
}



function redrawLangugesView() {
    global $connection;
    $query  = "SELECT * FROM languages ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $myLanguages = [];
    foreach($result as $value) {
        $myLanguages[] = $value;
    }
    return prepareLanguagesView($myLanguages);
}

function prepareLanguagesView($languages) {
    $output = "";
    if(count($languages) > 7) {
        $output .= "<ul class='left'>";
        for($i = 0; $i < 7; $i++) {
            $output .= "<li>";
            $output .= "<input id='" . $languages[$i]["code"] . "' type='radio' name='lang' value='" . $languages[$i]["code"] . "' >";
            $output .= "<label for='" . $languages[$i]["code"] . "'>";
            $output .= "<img src='images/flags/" . $languages[$i]["code"] . ".svg'>";
            $output .= $languages[$i]["name"] . "</label>";
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "<ul class='left'>";
        for($i = 7; $i < count($languages); $i++) {
            $output .= "<li>";
            $output .= "<input id='" . $languages[$i]["code"] . "' type='radio' name='lang' value='" . $languages[$i]["code"] . "' >";
            $output .= "<label for='" . $languages[$i]["code"] . "'>";
            $output .= "<img src='images/flags/" . $languages[$i]["code"] . ".svg'>";
            $output .= $languages[$i]["name"] . "</label>";
            $output .= "</li>";
        }
        $output .= "</ul>";
    } else {
        $output .= "<ul class='left'>";
        for($i = 0; $i < count($languages); $i++) {
            $output .= "<li>";
            $output .= "<input id='" . $languages[$i]["code"] . "' type='radio' name='lang' value='" . $languages[$i]["code"] . "' >";
            $output .= "<label for='" . $languages[$i]["code"] . "'>";
            $output .= "<img src='images/flags/" . $languages[$i]["code"] . ".svg'>";
            $output .= $languages[$i]["name"] . "</label>";
            $output .= "</li>";
        }
        $output .= "</ul>";
    }
    return $output;
}

function setChoosenLanguage($language) {
    global $connection;
    $query  = "TRUNCATE TABLE settings ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $defLang = DEFAULT_LANGUAGE;
    $query  = "INSERT INTO settings ";
    $query  .= "(language, defaultLanguage) ";
    $query  .= "VALUES ";
    $query  .= "('{$language}', '{$defLang}') ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
}

?>

<?php include("includes/headerActivation.php"); ?>

    <section class="chooseYourLanguage">
        <p><?php echo $lang["Please Choose Your Language:"]; ?></p>
        <form action="chooseLanguage.php" method="POST" class="chooseLanguageForm">
            <fieldset>
                <?php echo $showLanguages; ?>
                <div class="confirmationLine left">
                    <input type="hidden" name="chooseLanguage" value="TRUE" />
                    <input type="submit" value="<?php echo $lang["Next"]; ?>" class="button right" />
                </div>
            </fieldset>
        </form>
        <?php echo formErrors($errors); ?>
    </section>

<?php include("includes/footerActivation.php"); ?>