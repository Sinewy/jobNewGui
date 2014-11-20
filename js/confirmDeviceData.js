$(document).ready(function() {

    $("#confirmDeviceData").click(function() {
        if($("#numberOfCanisters option:selected").val() == -1) {
            if(!$(".message").length) {
                var out = "<div class='message'>";
                out += "<p>" + lang["Please fix the following errors:"] + "</p>";
                out += "<ul>";
                out += "<li>" + lang["Please choose number of canisters for this machine."] + "</li>";
                out += "</ul>";
                out += "</div>";
                $(".lineForm").append(out);
            }
        } else {
            if($(".message").length) {
                $(".message").remove();
            }

            //$(".pleaseWait").show();

            var isAutomatic = $("#isAutomatic").val();
            var serialNumber = $("#serialNumber").val();
            var deviceRemoteId = $("#deviceRemoteId").val();
            var deviceDispenserGroup = $("#deviceDispenserGroup").val();
            var deviceCode = $("#deviceCode").val();
            var cName = $("#cName").val();
            var cPhone = $("#cPhone").val();
            var cEmail = $("#cEmail").val();

            var oRemoteId = $("#oRemoteId").val();
            var oTitle = $("#oTitle").val();
            var oCountryId = $("#oCountryId").val();
            var oCountryName = $("#oCountryName").val();
            var oStreet = $("#oStreet").val();
            var oZip = $("#oZip").val();
            var oCity = $("#oCity").val();
            var oPhone = $("#oPhone").val();
            var oFax = $("#oFax").val();
            var oEmail = $("#oEmail").val();
            var oWeb = $("#oWeb").val();

            var deviceDispenserSystemId = $("#numberOfCanisters option:selected").val();

            var postWriteDeviceData = $.post("includes/ajaxCalls/writeDeviceData.php", {
                isAutomatic: isAutomatic,
                serialNumber: serialNumber,
                deviceRemoteId: deviceRemoteId,
                deviceDispenserGroup: deviceDispenserGroup,
                deviceDispenserSystemId: deviceDispenserSystemId,
                deviceCode: deviceCode,
                cName: cName,
                cPhone: cPhone,
                cEmail: cEmail,

                oRemoteId: oRemoteId,
                oTitle: oTitle,
                oCountryId: oCountryId,
                oCountryName: oCountryName,
                oStreet: oStreet,
                oZip: oZip,
                oCity: oCity,
                oPhone: oPhone,
                oFax: oFax,
                oEmail: oEmail,
                oWeb: oWeb,

                confirmedData: true});

            postWriteDeviceData.success(function(data) {

                console.log(data + " kr neki");

                if($.trim(data) == "success") {
                    console.log("activate in cloud");
                    var activeteInCloud = $.post("includes/ajaxCalls/activateInCloud.php", {deviceRemoteId: deviceRemoteId});
                    activeteInCloud.success(function(data2) {
                        if($.trim(data2) == "success") {
                            window.location.href = "jumix.php";
                        } else {
                            console.log(data2);
                        }
                    });



//                    console.log("calling initialize data.");
//                    console.log("device remote id: " + deviceRemoteId);
//                    //var timeStart = new Date();
//                    var setInitialData = $.post("setInitialData.php", {remoteId: deviceRemoteId});
//                    setInitialData.success(function(data2) {
//                        console.log(data2);
//                        //var timeEnd = new Date();
//                        //console.log("time is: " + (timeEnd - timeStart));
//                        if($.trim(data2) == "success") {
//                            // Activate device in the cloud
//                            var activeteInCloud = $.post("includes/activateInCloud.php", {deviceRemoteId: deviceRemoteId});
//                            activeteInCloud.success(function(data3) {
//                                if($.trim(data3) == "success") {
//                                    window.location.href = "jumix.php";
//                                }
//                            });
//                        }
//                    });
                }
            });
        }
    });


});