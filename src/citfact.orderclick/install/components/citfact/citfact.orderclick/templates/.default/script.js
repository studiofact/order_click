$(document).ready(function () {
    var modalWindow = $("#" + ajaxId);
    modalWindow.detach();
    modalWindow.prependTo("body");

    $(document).on("click", "." + classButtonOneClick, function () {
        $("#orderClickModalWindow").fadeIn("slow");

        var idElementBuy = $(this).attr(idElement);
        var idOfferBuy = $(this).attr(idOffer);
        var idQuantityBuy = $("#" + idQuantity + idElementBuy).val();

        console.log(idQuantity);
        console.log(idElementBuy);
        console.log(idQuantityBuy);

        $('[name = "ELEMENT"]').val(idElementBuy);
        $('[name = "OFFER"]').val(idOfferBuy);
        $('[name = "QUANTITY"]').val(idQuantityBuy);


        return false;
    });
    closeModalWindow();
});

function closeModalWindow() {
    $("#orderClickModalWindow").click(function () {
        $("#orderClickModalWindow").fadeOut("slow");
    }).children().click(function (object) {
        object.stopPropagation();
    });
    $(".closeModalWindow").click(function () {
        $("#orderClickModalWindow").fadeOut("slow");
        return false;
    });
}

function orderClick() {
    if ($(idOffer).length > 0) {
        $('[name = "OFFER"]').val($(idOffer).val());
    }
    if ($(idElement).length > 0) {
        $('[name = "ELEMENT"]').val($(idElement).val());
    }
    if ($(idQuantity).length > 0) {
        $('[name = "QUANTITY"]').val($(idQuantity).val());
    }

    var msg = $('#orderClickForm').serialize();

    $.ajax({
        type: 'POST',
        url: dirScript,
        data: msg,
        success: function (data) {
            $("#" + ajaxId).html(data);
            closeModalWindow();
        },
    });
}

	
	
