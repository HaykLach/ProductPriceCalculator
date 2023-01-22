$(document).ready(() => {
    $("#check-price").on('click', (e) => {
        e.preventDefault();
        let taxNumber = $("#tax_number").val();
        let resElement = $("#response");

        console.log(taxNumber);

        if (!validateTaxNumber(taxNumber)) {
            resElement.show();
            resElement.text("Tax number is invalid");
            resElement.css("color", "red");
        } else {
            sendCalculationRequest();
        }
    })
});

function validateTaxNumber(taxNumber) {
    let reg = /[A-Z]{2}[0-9]{9,}/gm;

    return reg.test(taxNumber);
}

function sendCalculationRequest() {
    let form = $("#price-form");
    let url = form.attr("action");
    let data = form.serialize();
    let resElement = $("#response");

    $.ajax({
        type: "POST",
        url: url,
        data: data
    }).done((res) => {
        if (res.length === 0) {
            resElement.show();
            resElement.text("Some data is invalid!");
            resElement.css("color", "red");
        } else {
            resElement.show();
            resElement.text("Your product price is " + res);
            resElement.css("color", "green");
        }
    });
}