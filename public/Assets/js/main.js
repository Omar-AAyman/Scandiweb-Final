

//Delete Selected Items 
$("#delete-product-btn").on('click', function () {
    $('#product_form').submit();
});

// Store New Item Into Database
$('#save-btn').on('click', function () {
    let sku = $("#sku").val();
    let name = $("#name").val();
    let price = $("#price").val();
    let productType = $("#productType").val();
    let size = $("#size").val();
    let weight = $("#weight").val();
    let height = $("#height").val();
    let width = $("#width").val();
    let length = $("#length").val();

    $.ajax({
        url: "/add-product",
        method: "POST",
        data: {
            sku: sku,
            name: name,
            price: price,
            productType: productType,
            size: size,
            weight: weight,
            height: height,
            width: width,
            length: length,
        },
        beforeSend: function () {
            $(document).find('div.invalid-feedback').text('');
        },
        success: function (response) {
            if (JSON.parse(response).status == false) {
                $.each(JSON.parse(response).errors, function (prefix, val) {
                    $('#' + prefix).addClass('is-invalid')
                    $('.' + prefix + '_error').text(val[0])
                })
            } else if (JSON.parse(response).status == true) {
                window.location.replace("/");
            }

        }
    })
});



// Make Item's div bordered when click on it
function checkBox(product) {
    let checkBoxes = $('.item-part #btn-check' + product);
    checkBoxes.attr("checked", !checkBoxes.attr("checked"))
    $("#item-part" + product).toggleClass('item-checked');
}

// Show Product Inputs According to This Product Type
$('#productType').change(function () {
    let productType = $('#productType').val();
    let dvd = $('#dvd-inputs');
    let book = $('#book-inputs');
    let furniture = $('#furniture-inputs');
    switch (productType) {
        case "dvd":
            dvd.removeClass('d-none');
            book.addClass('d-none');
            furniture.addClass('d-none');
            break;
        case "book":
            dvd.addClass('d-none');
            book.removeClass('d-none');
            furniture.addClass('d-none');
            break;
        case "furniture":
            dvd.addClass('d-none');
            book.addClass('d-none');
            furniture.removeClass('d-none');
            break;
        default:
            dvd.addClass('d-none');
            book.addClass('d-none');
            furniture.addClass('d-none');
            break;
    }
});

