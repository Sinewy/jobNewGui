<?php require_once("includes/session.php"); ?>
<?php require_once("includes/dbc.php"); ?>
<?php require_once("includes/languages/en-US.php"); ?>
<?php //require_once("includes/setLanguage.php"); ?>
<?php require_once("includes/globalFunctions.php"); ?>

<?php
confirmActivatedOnJumix();

//
//$langChanage = false;
//$selectedProd = -1;
//$selectedColl = -1;
//$selectedColor = -1;
//if(isset($_GET["langChanage"])) {
//    $langChanage = true;
//    $selectedProd = $_GET["selectedProd"];
//    $selectedColl = $_GET["selectedColl"];
//    $selectedColor = $_GET["selectedColor"];
//}
//?>


<?php
$productsList = showProductOptions("all");
$collectionsList = showCollectionOptions("all");

?>

<?php include("includes/header.php"); ?>

<nav class="topNavigation left">
    <div class="menuItems left">
        <div class="menuItem">
            <p><?php echo $lang["PRODUCTS"]; ?></p>
            <select id="selectProduct">
                <?php echo $productsList; ?>
            </select>
        </div>
        <div class="menuItem">
            <p><?php echo $lang["COLLECTIONS"]; ?></p>
            <select id="selectCollection">
                <?php echo $collectionsList; ?>
            </select>
        </div>
        <div class="menuItem">
            <p><?php echo $lang["COLORS"]; ?></p>
            <input type="text" id="selectColor" name="selectColor" size="25" value="" placeholder="<?php echo $lang["color"]; ?>" />
            <div class="clearSearchField" id="clearColorsSearch"><img src="images/clearField.svg"></div>
        </div>
        <div class="reset">
            <div class="resetAllBtn" id="resetAllSearchFields"><img src="images/clearIcon.svg"></div>
        </div>
    </div>
    <div class="topLogo right">
        <img class="right" src="images/jubLogoWhiteDrop.svg" alt="Jub Logo"/>
    </div>
</nav>

<section class="toolsBar right">
    <div class="toolBtn" id="printLabel">
        <img src="images/print.svg">
    </div>
    <div class="toolBtn" id="runTintingMachine">
        <img src="images/mixer.svg">
    </div>
    <div class="toolBtn">
        <img src="images/calcIconV2.svg">
    </div>
    <div class="toolBtn" id="showSettingsWindow">
        <img src="images/settingsIconV2.svg">
    </div>
</section>

<section class="colorDetailMain left">
    <div class="colorDetail left">
        <div class="colorInfo">
            <p class="productName">Product: JubosilColor Silicate (Jubosil FX)</p>
            <p class="elementName">Collection: TNS - Weber Terranova Farben Spectrum</p>
            <p class="elementName">Color name: 6OGM35MGO230FERT</p>
            <div class="approximateColor clearFix">
                <div class="selectedColor">&nbsp;</div>
            </div>
            <p class="elementName">Substrat: Unigrund, Acrylcolor</p>
            <div class="warningInfo">
                <p>Comment:</p>
                <p>Y = 81 ; ¤ = 7</p>
            </div>
            <div class="warningInfo">
                <p>Warning:</p>
                <p>Izdelek ni/pogojno primeren za zunanjo uporabo v TIS. Izdelek ni/pogojno primeren za zunanjo uporabo v TIS.</p>
            </div>
        </div>
    </div>
    <div class="componentsList right">
        <div class="row priceAndInfo">
            <div class="infoBtn left" id="showPriceInfoPopup" ><img src="images/moreInfoIconV3.svg"></div>
            <div class="bigPrice left">€1.345,03</div>
        </div>
        <div class="components">
            <div class="row tableHeader">
                <div class="left compNameHeader"><p><?php echo $lang["Component Name"]; ?></p></div>
                <div class="left compAmount"><p><?php echo $lang["Amount"]; ?></p></div>
                <div class="left compPrice"><p><?php echo $lang["Price/Unit"]; ?></p></div>
            </div>
            <div class="colorantList">
                <div class='row base'>
                    <div class='left compColor'>&nbsp;</div>
                    <div class='left compName'><p>Base NAME</p></div>
                    <div class='left compAmount'><p>25.00 KG</p></div>
                    <div class='left compPrice'><p>€1945.23</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
                <div class='row'>
                    <div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>
                    <div class='left compName'><p>Colorant Name 234SDF</p></div>
                    <div class='left compAmount'><p>0.34 ml</p></div>
                    <div class='left compPrice'><p>€12.45</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="cansizeSelector right">
        <img src="images/paintBucketV2.svg">
        <p class="left">PLEASE SELECT CAN SIZE</p>
        <div class="selectionField left">
            <input type="text" id="customCanSize" name="customCanSize" size="25" value="" placeholder="can size" />
            <div class="clearCansizeField" id="clearCansize">
                <img src="images/clearField.svg">
            </div>
            OR
            <select id="selectCanSize">
                <option value="-1">&nbsp;</option>
            </select>
        </div>
    </div>
</section>

<section class="availableColors left">
    <div class="availableColorsHideScroller">
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["COLORNAME"]; ?></div>
        </div>
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["ergvfd"]; ?></div>
        </div>
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["COLORNAME"]; ?></div>
        </div>
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["COLORNAME"]; ?></div>
        </div>
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["COLORNAME"]; ?></div>
        </div>
        <div class="colorSwatch left">
            <div class="colorSwatchName"><?php echo $lang["COLORNAME"]; ?></div>
        </div>
    </div>
</section>

<!--Exras - Popups, sideSlides and more-->

<div class="infoPopup" id="priceInfoPopup">
    <div class="row clearFix">
        <div class="propertyName left">Price Excluding VAT</div>
        <div class="propertyValue left">€1.034,23</div>
    </div>
    <div class="row clearFix">
        <div class="propertyName left">VAT</div>
        <div class="propertyValue left">€235,80</div>
    </div>
    <div class="row clearFix">
        <div class="propertyName left">VAT Rate</div>
        <div class="propertyValue left">20%</div>
    </div>
    <div class="row clearFix">
        <div class="propertyName left">Price Group</div>
        <div class="propertyValue left">I - IV</div>
    </div>
    <div class="row clearFix">
        <div class="propertyName left">Pricelist</div>
        <div class="propertyValue left">Testni cenik 1Testni ceni  ceni  ceni  ceni</div>
    </div>
    <div class="closeBtn button" id="closePriceInfoPopup">Close</div>
</div>

<div class="infoPopup" id="selectCanSizeError">
    <div class="row clearFix">
        <div class="propertyName left">Error...</div>
        <div class="propertyValue left">&nbsp;</div>
    </div>
    <div class="row clearFix">
        <div class="freeText left">Please eneter custom can size or select can size from the provided list.</div>
    </div>
    <div class="closeBtn button" id="closeSelectCanSizeError">Close</div>
</div>

<div class="infoPopup" id="printInfoPopup">
    <div class="row clearFix">
        <div class="propertyName left">SELECT NUMBER OF CANS</div>
    </div>
    <div class="row clearFix">
        <div class="freeText left">
            <select id="selectNumberOfCans">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
            </select>
        </div>
    </div>
    <div class="closeBtn button left" id="closePrintInfoPopup">Cancel</div>
    <div class="button left" id="printLabelToPrinter">Print</div>
</div>

<div class="infoPopup" id="printInfoPrintingToPrinter">
    <div class="row clearFix">
        <div class="freeText left">Printing label to printer...</div>
    </div>
    <div class="row clearFix">
        <div class="freeText left">This may take a few moments.. approximately 10 sec/label.</div>
    </div>
    <div class="closeBtn button" id="closePrintInfoPrintingToPrinter">OK</div>
</div>

<div class="infoPopup" id="runTintingMachinePopup">
    <div class="row clearFix">
        <div class="freeText left">Mixing colors...</div>
    </div>
    <div class="row clearFix">
        <div class="freeText left">This may take a few moments.. approximately 10 seconds.</div>
    </div>
    <div class="closeBtn button" id="closeRunTintingMachinePopup">OK</div>
</div>

<div class="setSettings">
    <p><?php echo $lang["SETTINGS"]; ?><img id="closeSettingsWithArrow" src="images/arrow-left.png"></p>
    <div class="language left">
        <p id="settingsSubTtitle"><?php echo $lang["Select GUI language:"]; ?></p>
        <?php //echo languageListView(); ?>
    </div>
    <div class="deactivateDevice">
        <div id="deactivateDevice" class="button left"><?php echo $lang["DEACTIVATE THIS DEVICE"]; ?></div>
    </div>
    <div class="confirmationLine left">
        <div id="cancelSettings" class="button left"><?php echo $lang["Cancel"]; ?></div>
        <div id="saveSettings" class="button left"><?php echo $lang["Save"]; ?></div>
    </div>
</div>

<div class="colorSearchResults" id="colorSearchResultsForCollection">
    <p><?php echo $lang["SEARCH RESULTS:"]; ?><img id="closeSearchResultsWithArrowC" src="images/arrow-left.png"></p>
    <div class="searchResults">
        <p id="subTitleC"><?php echo $lang["PRODUCTS"]; ?></p>
        <div class="radioBtns" id="collectionRadioBtns">
        </div>
    </div>
    <div class="confirmationLine left">
        <div id="cancelSearchResultsC" class="button left"><?php echo $lang["Cancel"]; ?></div>
        <div id="okSearchResultsForCollection" class="button left">OK</div>
    </div>
</div>

<div class="colorSearchResults" id="colorSearchResultsForProduct">
    <p><?php echo $lang["SEARCH RESULTS:"]; ?><img id="closeSearchResultsWithArrowP" src="images/arrow-left.png"></p>
    <div class="searchResults">
        <p id="subTitleP"><?php echo $lang["COLLECTIONS"]; ?></p>
        <div class="radioBtns" id="productRadioBtns">
        </div>
    </div>
    <div class="confirmationLine left">
        <div id="cancelSearchResultsP" class="button left"><?php echo $lang["Cancel"]; ?></div>
        <div id="okSearchResultsForProduct" class="button left">OK</div>
    </div>
</div>

<div class="colorSearchResults" id="colorSearchResults">
    <p><?php echo $lang["SEARCH RESULTS:"]; ?><img id="closeSearchResultsWithArrow" src="images/arrow-left.png"></p>
    <div class="searchResultsP left">
        <p id="subTitleP"><?php echo $lang["PRODUCTS"]; ?></p>
        <div class="radioBtns" id="pRadioBtns">
        </div>
    </div>
    <div class="searchResultsC left">
        <p id="subTitleP"><?php echo $lang["COLLECTIONS"]; ?></p>
        <div class="radioBtns" id="cRadioBtns">
        </div>
    </div>
    <div class="confirmationLine left">
        <div id="cancelSearchResults" class="button left"><?php echo $lang["Cancel"]; ?></div>
        <div id="okSearchResults" class="button left">OK</div>
    </div>
</div>


<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/jquery-ui.js"></script>
<!--<script>-->
<!--    var lang = --><?php //echo json_encode($lang); ?><!--;-->
<!--    var langChanage = --><?php //echo json_encode($langChanage); ?><!--;-->
<!--    var pselectedProd = --><?php //echo $selectedProd; ?><!--;-->
<!--    var pselectedColl = --><?php //echo $selectedColl; ?><!--;-->
<!--    var pselectedColor = --><?php //echo $selectedColor; ?><!--;-->
<!--</script>-->
<!--<script src="js/main.js"></script>-->
<script src="js/main.unmin.js"></script>

<?php include("includes/footer.php"); ?>

