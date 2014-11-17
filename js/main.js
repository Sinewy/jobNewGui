$(document).ready(function() {

    var selectedProductId = -1;
    var selectedCollectionId = -1;
//    var selectedColorId = -1;
    var selectedFormulaId = -1;
    var startFrom = "";

    function hasCanSize() {
        if($.trim($("#customCanSize").val()) == "" && $("#selectCanSize").prop("selectedIndex") == 0) {
            return false;
        } else {
            return true;
        }
    }

//    Navigation bar - clearing all fields
    $("#resetAllSearchFields").click(function() {
        console.log("clear all fields");
        console.log("selectedProductId: " + selectedProductId);
        console.log("selectedCollectionId: " + selectedCollectionId);
        console.log("selectedFormulaId: " + selectedFormulaId);
        console.log("startFrom: " + startFrom);

        selectedProductId = -1;
        selectedCollectionId = -1;
        selectedFormulaId = -1;
        startFrom = "";

        updateProductList();
        updateCollectionList();
        updateCanSizeList();
        $("#color").val("");
    });

    $("#clearColorsSearch").click(function() {
        $("#color").val("");
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
            console.log(ui.item.label);
        }
    });


////            var postForColorId = $.post("includes/getSelectedColorId.php", {searchString: ui.item.label});
//            selectedProduct = -1;
//            selectedCollection = -1;
//            selectedColor = -1;
//
//            selectedColor = extractColorId(ui.item.label);
//
//            console.log(selectedColor);
//
//            var postForProductsAndCollections = $.post("includes/getProductsAndCollectionsForColor.php", {scid: selectedColor});
//            postForProductsAndCollections.success(function(data) {
//                var resultData = $.parseJSON(data);
//
//                console.log(resultData[0].length);
//                console.log(resultData[1].length);
//
//                if(resultData[0].length == 1 && resultData[1].length == 1) {
//                    console.log("ONE productds and ONE collections");
//                    $("#product").val(resultData[0][0].name);
//                    $("#collection").val(resultData[1][0].name);
//                    selectedProduct = resultData[0][0].id;
//                    selectedCollection = resultData[1][0].id;
//                    updateCanSizes(selectedProduct);
//                    updateColorsView(selectedProduct, selectedCollection, selectedColor);
//                } else if(resultData[0].length == 1 && resultData[1].length > 1) {
//                    console.log("ONE productds and more collections");
//                    selectedProduct = resultData[0][0].id;
//                    $("#colorPSearchResults").html("<p id='searchTitle'>" + lang["PRODUCTS:"] + "</p><ul class='left'><li>" + resultData[0][0].name + "</li></ul>");
//                    $("#colorCSearchResults").html(prepareSearchResults(resultData[1], "sColl"));
//                    $(".searchResultLink").click(function() {
//                        doOnColorResultLinkClick(this);
//                    });
//                    $(".searchResultsForColor").toggle( "slide", {direction: "left"} );
//                } else if(resultData[0].length > 1 && resultData[1].length == 1) {
//                    console.log("more productds and ONE collections");
//                    selectedCollection = resultData[1][0].id;
//                    $("#colorPSearchResults").html(prepareSearchResults(resultData[0], "sProd"));
//                    $("#colorCSearchResults").html("<p id='searchTitle'>" + lang["COLLECTIONS:"] + "</p><ul class='left'><li>" + resultData[1][0].name + "</li></ul>");
//                    $(".searchResultLink").click(function() {
//                        doOnColorResultLinkClick(this);
//                    });
//                    $(".searchResultsForColor").toggle( "slide", {direction: "left"} );
//                } else if(resultData[0].length == 0 && resultData[1].length == 0) {
//                    $(".searchResultsForColor").html("<p>" + lang["This color does not exist in any collection or product. Choose another color."] + "</p><div id='closeSearchResultsForColorBtn' class='button'>" + lang["OK - Close"]+ "</div>");
//                    $("#closeSearchResultsForColorBtn").click(function() {
//                        $(".searchResultsForColor").toggle( "slide", {direction: "left"} );
//                        $(".searchResultsForColor").html("<p>" + lang["SEARCH RESULTS:"] + "</p><p>" + lang["PRODUCTS:"] + "</p><ul id='colorPSearchResults'></ul><p>" + lang["COLLECTIONS:"] + "</p><ul id='colorCSearchResults'></ul>");
//                    });
//                    $(".searchResultsForColor").toggle( "slide", {direction: "left"} );
//                } else {
//                    console.log("more productds and more collections");
//                    $("#colorPSearchResults").html(prepareSearchResults(resultData[0], "sProd"));
//                    $("#colorCSearchResults").html(prepareSearchResults(resultData[1], "sColl"));
//                    $(".searchResultLink").click(function() {
//                        doOnColorResultLinkClick(this);
//                    });
//                    $(".searchResultsForColor").toggle( "slide", {direction: "left"} );
//                }
//                console.log(typeof resultData);
//                console.log(resultData);
//                console.log(resultData.length);
//            });
////            });
//        }
//    });

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
        $("#priceInfoPopup").fadeIn();
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
        } else {
            $("#customCanSize").val("");
        }
    });

    $("#selectCanSize").change(function() {
        if($("#selectCanSize").prop("selectedIndex") != 0) {
            $("#customCanSize").val("");
        }
    });

    $("#clearCansize").click(function() {
        $("#customCanSize").val("");
    });


});