(function($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function() {
        function toggleNavbarMethod() {
            if ($(window).width() > 768) {
                $('.navbar .dropdown').on('mouseover', function() {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function() {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    $('.back-to-top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

    // Header slider
    $('.header-slider').slick({
        autoplay: true,
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    //add to cart
    $(".add_to_cart").each(function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            var pro_id = $(this).attr('id');
            var qty = ($("#quantity").val() !== "undefined") ? parseInt($("#quantity").val()) : 1;
            $.post(
                "/actions.php", {
                    "add_to": 'ok',
                    "action": 'cart',
                    "product_qty": qty,
                    "product_id": pro_id,
                },
                function(data, status) {
                    if (status == "success") {
                        window.alert(data);
                    } else {
                        alert("try agan");
                    }
                });
        });
    });

    //add to wish list
    $(".add_to_wishlist").each(function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            var pro_id = $(this).attr('id');
            var qty = $("#quantity").val() !== "undefined" ? parseInt($("#quantity").val()) : 1;
            $.post(
                "/actions.php", {
                    "add_to": 'ok',
                    "action": 'wishlist',
                    "product_qty": qty,
                    "product_id": pro_id,
                },
                function(data, status) {
                    if (status == "success") {
                        window.alert(data);
                    } else {
                        alert("try agan");
                    }
                });
        });
    });

    //delete from cart and wishlist
    $(".deleteProduct").each(function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            var pro_id = $(this).attr('id');
            var action = $(this).attr('action');
            var a = "";
            if (action === 'cart') {
                a = "cart";
            } else {
                a = "wishlist";
            }
            $.post(
                "/actions.php", {
                    "action": a,
                    "remove_from": 'ok',
                    "product_id": pro_id,
                },
                function(data, status) {
                    if (status == "success") {
                        if (data == "ok") {
                            location.reload();
                        } else {
                            window.alert(data);
                        }

                    } else {
                        alert("try agan");
                    }
                });
        });
    });

    //Quantity in product details    
    $('.updateQty button').on('click', function() {
        var $button = $(this);
        var qty = $button.parent().find('input').val();
        if ($button.hasClass('btn-plus')) {
            var newVal = parseFloat(qty) + 1;
        } else {
            if (qty > 1) {
                var newVal = parseFloat(qty) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    // Quantity in cart
    $('.qty button').on('click', function() {
        var $button = $(this);
        var pro_id = $button.parent().attr('id');
        var isAdding = "sub";
        if ($button.hasClass('btn-plus')) {
            isAdding = "add";
        }
        //change from server        
        $.post(
            "/actions.php", {
                "action": isAdding,
                "change_quantity": 'ok',
                "product_id": pro_id,
            },
            function(data, status) {
                if (status == "success") {
                    if (data == "ok") {
                        location.reload();
                    } else {
                        console.log(data);
                    }
                } else {
                    alert("try agan");
                }
            });

    });

    //set buy now  quantity
    var qty = $("#quantity").val();
    var pprice = $("#product_price").val();
    $("#subtotal").text("$" + parseInt((pprice * qty)));
    $("#grandtotal").text("$" + parseInt((pprice * qty) + 10));

    $('.buynow button').on('click', function() {
        var qty = $("#quantity").val();
        var pprice = $("#product_price").val();
        $("#subtotal").text("$" + parseInt((pprice * qty)));
        $("#grandtotal").text("$" + parseInt((pprice * qty) + 10));
    });

    //buynow product
    $("#buynow").on("click", function(e) {
        e.preventDefault();
        if (confirm("Are you sure to order product!")) {
            var payment = "";
            if ($("#payment-1").is(":checked")) {
                payment = "ZainCash";
            } else if ($("#payment-2").is(":checked")) {
                payment = "FastPay";
            } else if ($("#payment-3").is(":checked")) {
                payment = "OnDelivery";
            } else {
                payment = "OnDelivery";
            }
            var product_id = $("#product_id").val();
            var product_qty = $("#quantity").val();

            if ($("#full_name").val() != "" && $("#phone").val() != "" && $("#email").val() != "" && $("#address").val()) {
                var sddress = $("#full_name").val() + "-" + $("#phone").val() + "-" + $("#email").val() + "/" + $("#address").val();

                $.post(
                    "/actions.php", {
                        "product": product_id,
                        "buynow": 'ok',
                        "qty": product_qty,
                        "payment": payment,
                        "address": sddress
                    },
                    function(data, status) {
                        if (status == "success") {
                            alert(data);
                            location.href = "./";
                        } else {
                            alert("try agan");
                        }
                    });
            } else {
                alert("Please,fill all required shipping address!");
            }
        }

    });


    //empty cart
    $("#emptyCart").on("click", function(e) {
        e.preventDefault();
        if (confirm("Are you sure to empty your Cart!")) {
            $.post(
                "/actions.php", {
                    "emptyCart": 'ok',
                },
                function(data, status) {
                    if (status == "success") {
                        if (data == "ok") {
                            location.href = "./";
                        } else {
                            console.log(data);
                        }
                    } else {
                        alert("try agan");
                    }
                });
        }

    });

    // Product fav
    $('.product-fav-single').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        fade: true,
        slidesToShow: 1,
        speed: 100,
        slidesToScroll: 1,
        asNavFor: '.product-fav-single-nav'
    });
    //product fav
    $('.product-fav-single-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 100,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.product-fav-single'
    });
    // Product Detail Slider
    $('.product-slider-single').slick({
        infinite: true,
        autoplay: true,
        dots: false,
        fade: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.product-slider-single-nav'
    });

    $('.product-slider-single-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 500,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.product-slider-single'
    });

    // Product Slider 3 Column
    $('.product-slider-3').slick({
        autoplay: true,
        infinite: true,
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });

    // Payment methods show hide
    $('.payment-content').each(function() {
        $(this).hide();
    });

    $('.checkout .payment-method .custom-control-input').change(function() {
        if ($(this).prop('checked')) {
            var checkbox_id = $(this).attr('id');
            $('.checkout .payment-method .payment-content').slideUp();
            $('#' + checkbox_id + '-show').slideDown();
        }
    });

    //order cart
    $("#orderCart").on("click", function(e) {
        e.preventDefault();
        if (confirm("Are you sure to order Cart!")) {

            var payment = "";
            if ($("#payment-1").is(":checked")) {
                payment = "ZainCash";
            } else if ($("#payment-2").is(":checked")) {
                payment = "FastPay";
            } else if ($("#payment-3").is(":checked")) {
                payment = "OnDelivery";
            } else {
                payment = "OnDelivery";
            }
            if ($("#full_name").val() != "" && $("#phone").val() != "" && $("#email").val() != "" && $("#address").val()) {
                var sddress = $("#full_name").val() + "-" + $("#phone").val() + "-" + $("#email").val() + "/" + $("#address").val();

                $.post(
                    "/actions.php", {
                        "orderCart": 'ok',
                        "payment": payment,
                        "address": sddress
                    },
                    function(data, status) {
                        if (status == "success") {
                            alert("Order has been done");
                            location.href = "./";
                        } else {
                            alert("try agan");
                        }
                    });
            } else {
                alert("Please,fill all required shipping address!");
            }
        }

    });

    //search results
    $("#popup-reference").keyup(function() {
        var key = $(this).val();
        $.post("/actions.php", {
            "search": 'yes',
            "key": key
        }, function(data, status) {
            $('#popup').hide();
            $("#popup").html('');
            if (status == "success") {
                $("#popup").html(data);
                $('#popup').show();
            } else {
                $('#popup').hide();
            }
        });

    }); //.change(function() { $('#popup').hide(); });

})(jQuery);