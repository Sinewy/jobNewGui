$(document).ready(function() {

    var selectedProductId = -1;
    var selectedCollectionId = -1;
    var selectedFormulaId = -1;
    var selectedCansizeId = -1;
    var selectedColorName = "";
    var startFrom = "";

    function hasCanSize() {
        if($.trim($("#customCanSize").val()) == "" && $("#selectCanSize").prop("selectedIndex") == 0) {
            return false;
        } else {
            return true;
        }
    }

    function resetAllFields() {
        console.log("clear all fields");
        console.log("selectedProductId: " + selectedProductId);
        console.log("selectedCollectionId: " + selectedCollectionId);
        console.log("selectedFormulaId: " + selectedFormulaId);
        console.log("selectedCansizeId: " + selectedCansizeId);
        console.log("selectedColorName: " + selectedColorName);
        console.log("startFrom: " + startFrom);

        selectedProductId = -1;
        selectedCollectionId = -1;
        selectedFormulaId = -1;
        selectedCansizeId = -1;
        selectedColorName = "";
        startFrom = "";

        updateProductList();
        updateCollectionList();
        updateCanSizeList();
        $("#selectColor").val("");
        $("#customCanSize").val("");

        resetDisplay();
    }

    function resetDisplay() {
        var colorDetail = "";
        colorDetail += "<div class='colorInfo'>";
        colorDetail += "<p class='productName'>Product: -</p>";
        colorDetail += "<p class='elementName'>Collection: -</p>";
        colorDetail += "<p class='elementName'>Color name: -</p>";
        colorDetail += "<div class='approximateColor clearFix'>";
        colorDetail += "<div class='selectedColor' style='background-color: #000000'>&nbsp;</div>";
        colorDetail += "</div>";
        colorDetail += "<p class='elementName'>Substrat: -</p>";
        colorDetail += "<div class='warningInfo'>";
        colorDetail += "<p>Comment:</p>";
        colorDetail += "<p>-</p>";
        colorDetail += "</div>";
        colorDetail += "<div class='warningInfo'>";
        colorDetail += "<p>Warning:</p>";
        colorDetail += "<p>-</p>";
        colorDetail += "</div>";
        colorDetail += "</div>";

        var componentsList = "";
        componentsList += "<div class='row priceAndInfo'>";
        componentsList += "<div class='infoBtn left' id='showPriceInfoPopup' ><img src='images/moreInfoIconV3.svg'></div>";
        componentsList += "<div class='bigPrice left'>-</div>";
        componentsList += "</div>";
        componentsList += "<div class='components'>";
        componentsList += "<div class='row tableHeader'>";
        componentsList += "<div class='left compNameHeader'><p>Component Name</p></div>";
        componentsList += "<div class='left compAmount'><p>Amount</p></div>";
        componentsList += "<div class='left compPrice'><p>Price</p></div>";
        componentsList += "</div>";
        componentsList += "<div class='colorantList'>";
        componentsList += "<div class='row base'>";
        componentsList += "<div class='left compColor'>&nbsp;</div>";
        componentsList += "<div class='left compName'><p>Base NAME</p></div>";
        componentsList += "<div class='left compAmount'><p>-</p></div>";
        componentsList += "<div class='left compPrice'><p>-</p></div>";
        componentsList += "</div>";
        for(var i = 0; i < 6; i++) {
            componentsList += "<div class='row'>";
            componentsList += "<div class='left compColor'><div class='colorantColor'>&nbsp;</div></div>";
            componentsList += "<div class='left compName'><p>Colorant Name</p></div>";
            componentsList += "<div class='left compAmount'><p>-</p></div>";
            componentsList += "<div class='left compPrice'><p>-</p></div>";
            componentsList += "</div>";
        }
        componentsList += "</div>";
        componentsList += "</div>";

        var colorsList = "";
        for(var i = 0; i < 6; i++) {
            colorsList += "<div class='colorSwatch left'>";
            colorsList += "<div class='colorSwatchName'>COLORNAME" + i + "</div>";
            colorsList += "</div>";
        }
        $(".colorDetail").html(colorDetail);
        $(".componentsList").html(componentsList);
        $(".availableColorsHideScroller").html(colorsList);
        $(".colorDetailMain").css("border-color", "#000000");

        $("#showPriceInfoPopup").click(function() {
            if(hasCanSize()) {
                $("#priceInfoPopup").fadeIn();
            } else {
                $("#selectCanSizeError").fadeIn();
            }
        });
    }
//
//    Navigation bar - clearing all fields
    $("#resetAllSearchFields").click(function() {
        resetAllFields();
    });

    $("#clearColorsSearch").click(function() {
        $("#selectColor").val("");
        selectedColorName = "";
        if(startFrom == "color") {
            console.log("deleteing start from");
            resetAllFields();
        }
    });

    $("#selectProduct").change(function() {
        if(selectedProductId == -1 && selectedFormulaId == -1 && selectedCollectionId == -1) {
            startFrom = "product";
        }
        selectedProductId = this.value;
        console.log(this.value);
        if(startFrom == "product") {
            updateProductList();
        }
        updateCanSizeList();
        if(selectedProductId == -1 && startFrom == "product") {
            startFrom = "";
        }
        $("#selectColor").val("");
    });

    $("#selectCollection").change(function() {
        if(selectedProductId == -1 && selectedFormulaId == -1 && selectedCollectionId == -1) {
            startFrom = "collection";
        }
        selectedCollectionId = this.value;
        console.log(this.value);
        if(startFrom == "collection") {
            updateCollectionList();
        }
        if(selectedCollectionId == -1 && startFrom == "collection") {
            startFrom = "";
        }
        $("#selectColor").val("");
    });

    function updateProductList() {
        var updateCollectionOptions = $.post("includes/ajaxCalls/updateCollectionOptions.php", {productId: selectedProductId});
        updateCollectionOptions.success(function(data) {
            $("#selectCollection").html(data);
        });
    }

    function updateCollectionList() {
        var updateProductOptions = $.post("includes/ajaxCalls/updateProductOptions.php", {collectionId: selectedCollectionId});
        updateProductOptions.success(function(data) {
            $("#selectProduct").html(data);
        });
    }

    function updateCanSizeList() {
        var updateCanSizeOptions = $.post("includes/ajaxCalls/updateCanSizeOptions.php", {productId: selectedProductId});
        updateCanSizeOptions.success(function(data) {
            $("#selectCanSize").html(data);
        });
    }

    $("#selectColor").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "includes/ajaxCalls/findAppropriateColors.php",
                dataType: "json",
                data: {
                    term: request.term,
                    productId: selectedProductId,
                    collectionId: selectedCollectionId
                },
                success: function(data) {
                    console.log("data je");
                    console.log(data);
                    response(data);
                }
            });
        },
        minLength: 0,
        select: function(event, ui) {
            if(selectedProductId == -1 && selectedFormulaId == -1 && selectedCollectionId == -1) {
                startFrom = "color";
            }
            selectedColorName = ui.item.label;
            if(selectedProductId == -1 && selectedCollectionId == -1) {
                showColorSearchResultWithProductsAndCollections(selectedColorName);
            } else if(selectedProductId != -1 && selectedCollectionId == -1) {
                showColorSearchResultWithCollections(selectedColorName);
            } else if(selectedProductId == -1 && selectedCollectionId != -1) {
                showColorSearchResultWithProducts(selectedColorName);
            } else {
                findFormulaIdForColorProductCollection(selectedColorName);
            }
            console.log(ui.item.label);
        }
    });

    function showColorSearchResultWithProductsAndCollections(colorName) {
        var findCollectionsForColorAndProduct = $.post("includes/ajaxCalls/findProductsAndCollectionsForColor.php", {colorName: colorName});
        findCollectionsForColorAndProduct.success(function(data) {
            var parsedData = $.parseJSON(data);
            if(parsedData[0].length == 1 && parsedData[1].length == 1) {
                selectedProductId = parsedData[0][0].id;
                selectedCollectionId = parsedData[1][0].id;
                $("#selectProduct").html("<option value='" + selectedProductId + "'>" + parsedData[0][0].name + "</option>");
                $("#selectCollection").html("<option value='" + selectedCollectionId + "'>" + parsedData[1][0].name + "</option>");
                findFormulaIdForColorProductCollection(colorName);
            //} else if(parsedData[0].length != 1 && parsedData[1].length == 1) {
            } else {
                $("#pRadioBtns").html(makeRadioBtnSelect(parsedData[0], "product"));
                $("#cRadioBtns").html(makeRadioBtnSelect(parsedData[1], "collection"));
                $("#colorSearchResults").toggle( "slide", {direction: "left"});
            }

            console.log(parsedData[0]);
            console.log(parsedData[1]);
            console.log(parsedData.length);
        });
    }

    function showColorSearchResultWithCollections(colorName) {
        var findCollectionsForColorAndProduct = $.post("includes/ajaxCalls/findCollectionsForColorAndProduct.php", {colorName: colorName, productId: selectedProductId});
        findCollectionsForColorAndProduct.success(function(data) {
            var parsedData = $.parseJSON(data);
            if(parsedData.length == 1) {
                console.log("should work");
                $("#selectCollection").val(parsedData[0].id);
                selectedCollectionId = parsedData[0].id;
                findFormulaIdForColorProductCollection(selectedColorName);
            } else {
                $("#productRadioBtns").html(makeRadioBtnSelect(parsedData, "collection"));
                $("#colorSearchResultsForProduct").toggle( "slide", {direction: "left"});
            }
        });
    }

    function showColorSearchResultWithProducts(colorName) {
        var findProductsForCorlorAndCollection = $.post("includes/ajaxCalls/findProductsForColorAndCollection.php", {colorName: colorName, collectionId: selectedCollectionId});
        findProductsForCorlorAndCollection.success(function(data) {
            var parsedData = $.parseJSON(data);
            if(parsedData.length == 1) {
                $("#selectProduct").val(parsedData[0].id);
                selectedProductId = parsedData[0].id;
                findFormulaIdForColorProductCollection(selectedColorName);
            } else {
                $("#collectionRadioBtns").html(makeRadioBtnSelect(parsedData, "product"));
                $("#colorSearchResultsForCollection").toggle( "slide", {direction: "left"});
            }
        });

    }

    function makeRadioBtnSelect(data, rbGroup) {
        var output = "";
        if(data.length == 1) {
            output += "<div class='rbLine'>"
            output += "<input type='radio' name='" + rbGroup + "' id='" + data[0].id + "' value='" + data[0].id + "' checked>";
            output += "<label for='" + data[0].id + "'>" + data[0].name + "</label>";
            output += "</div>";
            return output;
        } else {
            for(var i = 0; i < data.length; i++) {
                output += "<div class='rbLine'>"
                output += "<input type='radio' name='" + rbGroup + "' id='" + data[i].id + "' value='" + data[i].id + "'>";
                output += "<label for='" + data[i].id + "'>" + data[i].name + "</label>";
                output += "</div>";
            }
            return output;
        }
    }

    $("#cancelSearchResultsC, #closeSearchResultsWithArrowC").click(function() {
        $("#colorSearchResultsForCollection").toggle( "slide", {direction: "left"});
        $("#selectColor").val("");
        selectedColorName = "";
    });
    $("#cancelSearchResultsP, #closeSearchResultsWithArrowP").click(function() {
        $("#colorSearchResultsForProduct").toggle( "slide", {direction: "left"});
        $("#selectColor").val("");
        selectedColorName = "";
    });
    $("#cancelSearchResults, #closeSearchResultsWithArrow").click(function() {
        $("#colorSearchResults").toggle( "slide", {direction: "left"});
        $("#selectColor").val("");
        selectedColorName = "";
    });

    $("#okSearchResultsForCollection").click(function() {
        if($("input:radio[name='product']").is(":checked")) {
            selectedProductId = $("input[name='product']:checked").val();
            $("#selectProduct").val(selectedProductId);
            findFormulaIdForColorProductCollection(selectedColorName);
        } else {
            $("#selectColor").val("");
            selectedColorName = "";
        }
        $("#colorSearchResultsForCollection").toggle( "slide", {direction: "left"});
    });

    $("#okSearchResultsForProduct").click(function() {
        if($("input:radio[name='collection']").is(":checked")) {
            selectedCollectionId = $("input[name='collection']:checked").val();
            $("#selectCollection").val(selectedCollectionId);
            findFormulaIdForColorProductCollection(selectedColorName);
        } else {
            $("#selectColor").val("");
            selectedColorName = "";
        }
        $("#colorSearchResultsForProduct").toggle( "slide", {direction: "left"});
    });

    $("#okSearchResults").click(function() {
        if($("input:radio[name='product']").is(":checked") && $("input:radio[name='collection']").is(":checked")) {
            selectedProductId = $("input[name='product']:checked").val();
            selectedCollectionId = $("input[name='collection']:checked").val();
            $("#selectProduct").html("<option value='" + selectedProductId + "'>" + $("input[name='product']:checked").next().text() + "</option>");
            $("#selectCollection").html("<option value='" + selectedCollectionId + "'>" + $("input[name='collection']:checked").next().text() + "</option>");
            findFormulaIdForColorProductCollection(selectedColorName);
        } else {
            $("#selectColor").val("");
            selectedColorName = "";
            startFrom = "";
        }
        $("#colorSearchResults").toggle( "slide", {direction: "left"});
    });

    function findFormulaIdForColorProductCollection(colorName) {
        var findFormulaId = $.post("includes/ajaxCalls/findFormulaIdForColorProductCollection.php", {colorName: colorName, productId: selectedProductId, collectionId: selectedCollectionId});
        findFormulaId.success(function(data) {
            var parsedData = $.parseJSON(data);
            selectedFormulaId = parsedData["formulas_id"];

//            console.log(parsedData["formulas_id"]);
            updateColorDetailView();
        });
    }

    function updateColorDetailView() {
        console.log("... updating color details..");
        console.log("selectedProductId: " + selectedProductId);
        console.log("selectedCollectionId: " + selectedCollectionId);
        console.log("selectedFormulaId: " + selectedFormulaId);
        console.log("selectedCansizeId: " + selectedCansizeId);
        console.log("selectedColorName: " + selectedColorName);
        console.log("startFrom: " + startFrom);
        console.log("... updating color details..");

        var findDataForSelectedColor = $.post("includes/ajaxCalls/findDataForSelectedColor.php", {productId: selectedProductId, collectionId: selectedCollectionId, formulaId: selectedFormulaId});
        findDataForSelectedColor.success(function(data) {
            var parsedData = $.parseJSON(data);
            //console.log(parsedData);
            displayColorDetails(parsedData);
        });
    }

    function displayColorDetails(data) {
        var colorData = data["colorData"];
        var colorantData = data["colorantData"];

        var color = makeHexColorFromRgb(colorData["colorR"], colorData["colorG"], colorData["colorB"]);

        var colorDetail = "";
        colorDetail += "<div class='colorInfo'>";
        colorDetail += "<p class='productName'>Product: " + colorData["productName"] + "</p>";
        colorDetail += "<p class='elementName'>Collection: " + colorData["collectionName"] + "</p>";
        colorDetail += "<p class='elementName'>Color name: " + colorData["colorName"] + "</p>";
        colorDetail += "<div class='approximateColor clearFix'>";
        colorDetail += "<div class='selectedColor' style='background-color: #" + color + "'>&nbsp;</div>";
        colorDetail += "</div>";
        colorDetail += "<p class='elementName'>Substrat: " + colorData["sustrate"] + "</p>";
        colorDetail += "<div class='warningInfo'>";
        colorDetail += "<p>Comment:</p>";
        colorDetail += "<p>" + colorData["COMMENTS"] + "</p>";
        colorDetail += "</div>";
        colorDetail += "<div class='warningInfo'>";
        colorDetail += "<p>Warning:</p>";
        colorDetail += "<p>" + colorData["WARNING_MESSAGE"] + "</p>";
        colorDetail += "</div>";
        colorDetail += "</div>";

        var componentsList = "";
        componentsList += "<div class='row priceAndInfo'>";
        componentsList += "<div class='infoBtn left' id='showPriceInfoPopup' ><img src='images/moreInfoIconV3.svg'></div>";
        componentsList += "<div class='bigPrice left'>-</div>";
        componentsList += "</div>";
        componentsList += "<div class='components'>";
        componentsList += "<div class='row tableHeader'>";
        componentsList += "<div class='left compNameHeader'><p>Component Name</p></div>";
        componentsList += "<div class='left compAmount'><p>Amount</p></div>";
        componentsList += "<div class='left compPrice'><p>Price</p></div>";
        componentsList += "</div>";
        componentsList += "<div class='colorantList'>";
        componentsList += "<div class='row base'>";
        componentsList += "<div class='left compColor'>&nbsp;</div>";
        componentsList += "<div class='left compName'><p>" + colorData["baseName"]  + "</p></div>";
        componentsList += "<div class='left compAmount'><p>-</p></div>";
        componentsList += "<div class='left compPrice'><p>-</p></div>";
        componentsList += "</div>";
        for(var i = 0; i < colorantData.length; i++) {
            var cColor = makeHexColorFromRgb(colorantData[i]["colorantR"], colorantData[i]["colorantG"], colorantData[i]["colorantB"]);
            componentsList += "<div class='row'>";
            componentsList += "<div class='left compColor'><div class='colorantColor' style='background-color: #" + cColor + "'>&nbsp;</div></div>";
            componentsList += "<div class='left compName'><p>" + colorantData[i]["name"] + "</p></div>";
            componentsList += "<div class='left compAmount'><p>-</p></div>";
            componentsList += "<div class='left compPrice'><p>-</p></div>";
            componentsList += "</div>";
        }
        componentsList += "</div>";
        componentsList += "</div>";

        $(".colorDetail").html(colorDetail);
        $(".componentsList").html(componentsList);
        $(".colorDetailMain").css("border-color", "#" + color);

        $("#showPriceInfoPopup").click(function() {
            if(hasCanSize()) {
                $("#priceInfoPopup").fadeIn();
            } else {
                $("#selectCanSizeError").fadeIn();
            }
        });
    }

    function updatePricesAndQuantities() {
        var findPricesAndQuantities = $.post("includes/ajaxCalls/findPricesAndQuantities.php", {productId: selectedProductId, collectionId: selectedCollectionId, formulaId: selectedFormulaId});
        findPricesAndQuantities.success(function(data) {
            var parsedData = $.parseJSON(data);

//            var componentsList = "";
//            componentsList += "<div class='row priceAndInfo'>";
//            componentsList += "<div class='infoBtn left' id='showPriceInfoPopup' ><img src='images/moreInfoIconV3.svg'></div>";
//            componentsList += "<div class='bigPrice left'>-</div>";
//            componentsList += "</div>";
//            componentsList += "<div class='components'>";
//            componentsList += "<div class='row tableHeader'>";
//            componentsList += "<div class='left compNameHeader'><p>Component Name</p></div>";
//            componentsList += "<div class='left compAmount'><p>Amount</p></div>";
//            componentsList += "<div class='left compPrice'><p>Price</p></div>";
//            componentsList += "</div>";
//            componentsList += "<div class='colorantList'>";
//            componentsList += "<div class='row base'>";
//            componentsList += "<div class='left compColor'>&nbsp;</div>";
//            componentsList += "<div class='left compName'><p>" + colorData["baseName"] + "</p></div>";
//            componentsList += "<div class='left compAmount'><p>-</p></div>";
//            componentsList += "<div class='left compPrice'><p>-</p></div>";
//            componentsList += "</div>";
//            for (var i = 0; i < colorantData.length; i++) {
//                var cColor = makeHexColorFromRgb(colorantData[i]["colorantR"], colorantData[i]["colorantG"], colorantData[i]["colorantB"]);
//                componentsList += "<div class='row'>";
//                componentsList += "<div class='left compColor'><div class='colorantColor' style='background-color: #" + cColor + "'>&nbsp;</div></div>";
//                componentsList += "<div class='left compName'><p>" + colorantData[i]["name"] + "</p></div>";
//                componentsList += "<div class='left compAmount'><p>-</p></div>";
//                componentsList += "<div class='left compPrice'><p>-</p></div>";
//                componentsList += "</div>";
//            }
//            componentsList += "</div>";
//            componentsList += "</div>";
//
//            $(".colorDetail").html(colorDetail);
//            $(".componentsList").html(componentsList);
//            $(".colorDetailMain").css("border-color", "#" + color);
//
//            $("#showPriceInfoPopup").click(function () {
//                if (hasCanSize()) {
//                    $("#priceInfoPopup").fadeIn();
//                } else {
//                    $("#selectCanSizeError").fadeIn();
//                }
//            });
        });
    }

    function updatePricesAndQuantitiesToUnknown() {

    }

//    Show and set key settings
    $("#showSettingsWindow").click(function() {
        $(".setSettings").toggle( "slide", {direction: "left"} );
    });

    $("#cancelSettings, #closeSettingsWithArrow").click(function() {
        $(".setSettings").toggle( "slide", {direction: "left"} );
    });

    $("#saveSettings").click(function() {
        $(".setSettings").toggle( "slide", {direction: "left"} );
    });

//    Show extra price information
    $("#showPriceInfoPopup").click(function() {
        if(hasCanSize()) {
            $("#priceInfoPopup").fadeIn();
        } else {
            $("#selectCanSizeError").fadeIn();
        }
    });

    $("#closePriceInfoPopup").click(function() {
        $("#priceInfoPopup").fadeOut();
    });

//    Run mixer/tinting machine
    $("#runTintingMachine").click(function() {
        if(hasCanSize()) {
            $("#runTintingMachinePopup").fadeIn();
        }else {
            $("#selectCanSizeError").fadeIn();
        }
    });

    $("#closeRunTintingMachinePopup").click(function() {
        $("#runTintingMachinePopup").fadeOut();
    });

//    Printing popups and functions
    $("#printLabel").click(function() {
        console.log($("#selectCanSize").prop("selectedIndex"));
        if(hasCanSize()) {
            $("#printInfoPopup").fadeIn();
            console.log("show choose number of cans");
        } else {
            $("#selectCanSizeError").fadeIn();
            console.log("error - choose can size");
        }
    });

    $("#closeSelectCanSizeError").click(function() {
        $("#selectCanSizeError").fadeOut();
    });

    $("#closePrintInfoPopup").click(function() {
        $("#printInfoPopup").fadeOut();
    });

    $("#printLabelToPrinter").click(function() {
        $("#printInfoPopup").fadeOut();
        $("#printInfoPrintingToPrinter").fadeIn();
    });

    $("#closePrintInfoPrintingToPrinter").click(function() {
        $("#printInfoPrintingToPrinter").fadeOut();
    });

//    Selecting appropriate can size
    $("#customCanSize").change(function() {
        if($.trim($("#customCanSize").val()) != "") {
            $("#selectCanSize").prop("selectedIndex", 0);
            selectedCansizeId = -1;
        } else {
            $("#customCanSize").val("");
        }
    });

    $("#selectCanSize").change(function() {
        selectedCansizeId = $("#selectCanSize").val();
        if($("#selectCanSize").prop("selectedIndex") != 0) {
            $("#customCanSize").val("");
            console.log(selectedCansizeId);
            //updatePricesAndQuantities();
        } else {
            //updatePricesAndQuantitiesToUnknown();
        }
    });

    $("#clearCansize").click(function() {
        $("#customCanSize").val("");
    });

    function makeHexColorFromRgb(r, g, b) {

        var rHex = parseInt(r).toString(16);
        var gHex = parseInt(g).toString(16);
        var bHex = parseInt(b).toString(16);

        rHex = rHex.length < 2 ? "0" + rHex : rHex;
        gHex = gHex.length < 2 ? "0" + gHex : gHex;
        bHex = bHex.length < 2 ? "0" + bHex : bHex;

        return rHex + gHex + bHex;
    }

});