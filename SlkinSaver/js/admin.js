(function($) {
    "use strict";
    $(document).ready(
        function() {
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

            //date picker
            $('.expire_date').datepicker({
                format: 'yyyy-mm-dd'
            });

            //categories added
            var optionSelected = [];
            $('#categories option').each(function() {
                optionSelected.push($(this).val());
            });
            $('#categorySelected').val(optionSelected);

            var CategoryArray = [];
            $('#add_category').on('click', function() {
                var catID = $('#category').val();
                var catName = $('#category option:selected').text();
                if (($("#categories option[value='" + catID + "']").length) == 0) {
                    $('#categories').append('<option value=' + catID + '>' + catName + '</option>');
                    CategoryArray = optionSelected;
                    $('#categorySelected').val(catID);
                    CategoryArray.push(catID);
                    $('#categorySelected').val(CategoryArray);
                }
                //flashing border when adding
                $('#categories').addClass('border-warning');
                setInterval(function() {
                    $('#categories').removeClass('border-warning');
                }, 1000);
                console.log(CategoryArray);

            });

            $('#remove_category').on('click', function() {
                var catID = $('#categories').val();
                var proID = $('#product_id').val();
                if (catID != 0) {
                    //remove from server side
                    $.post("/actions.php", {
                        "delete_category_from_product": 'ok',
                        "pro_cat_id": catID,
                        "pro_id": proID
                    }, function(data, status) {
                        if (status == "success") {
                            if (data == "ok") {
                                //remove client side
                                $('#categories option:selected').remove();
                                var index = CategoryArray.indexOf(catID);
                                CategoryArray.splice(index, 1);
                                $('#categorySelected').val(CategoryArray);
                                //flashing border when removing
                                $('#categories').addClass('border-warning');
                                setInterval(function() {
                                    $('#categories').removeClass('border-warning');
                                }, 1000);
                                console.log(CategoryArray);
                            } else {
                                console.log("Error cat has not been deleted!");
                            }

                        } else {
                            alert("Error in sql");
                        }
                    });




                }
            });

            //shout down system
            $(".shoutdown").click(function() {
                $(this).prop("disabled", true);
                $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...`);
                var $button = $(this);
                var action = $button.attr('action');
                $.post("/actions.php", {
                    "powerStystem": 'Yes',
                    "action": action
                }, function(data, status) {
                    if (status == "success") {
                        if (data == "ok") {
                            $button.prop("disabled", false);
                            if (action == "1") {
                                $button.html("Power System Off");
                                $button.removeClass("btn-success");
                                $button.addClass("btn-danger");
                                $button.attr('action', '0');
                            } else {
                                $button.html("Power System On");
                                $button.removeClass("btn-danger");
                                $button.addClass("btn-success");
                                $button.attr('action', '1');
                            }

                        } else {
                            $button.prop("disabled", false);
                        }
                    }
                });
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

            //order actions
            //order is delevered
            $(".orderDelivered").on("click", function() {
                var ord_id = $(this).attr('ord_id');
                $.post("/actions.php", {
                    "orderAction": 'Yes',
                    "action": 'delivered',
                    "order": ord_id
                }, function(data, status) {
                    if (status == "success") {
                        if (data == "ok") {
                            alert("order has been delevered");
                        } else {
                            alert("sql error");
                        }
                    }
                });
            });
            //order Canceling
            $(".orderCancel").on("click", function() {
                var ord_id = $(this).attr('ord_id');
                $.post("/actions.php", {
                    "orderAction": 'Yes',
                    "action": 'canceled',
                    "order": ord_id
                }, function(data, status) {
                    if (status == "success") {
                        if (data == "ok") {
                            alert("order has been canceled");
                        } else {
                            alert("sql error");
                        }
                    }
                });
            });

            //target actions
            $(".target").each(function() {
                var $button = $(this);
                $($button).on("click", function() {
                    var value = $(this).closest('div .input-group').find('input').val();
                    var action = $(this).closest('div .input-group').find('input').attr('id');
                    $.post(
                        "/actions.php", {
                            "setTarget": action,
                            "value": value
                        },
                        function(data, status) {
                            if (status == "success") {
                                alert(data);
                            } else {
                                alert("sql error");
                            }

                        });
                });
            });

            //get product images 
            $("#product_default_image").change(function() {
                var product_id = $(this).val();
                $.post('/actions.php', {
                    "getProductImages": 'ok',
                    "product_id": product_id
                }, function(data, status) {
                    if (status == "success") {
                        $("#images_preview").html(data);
                    } else {
                        alert("error");
                    }

                });
            });



        });

})(jQuery);


var options2 = {
    series: [76],
    chart: {
        type: 'radialBar',
        offsetY: -20,
        sparkline: {
            enabled: true
        }
    },

    plotOptions: {
        radialBar: {
            startAngle: -90,
            endAngle: 90,
            track: {
                background: "#e7e7e7",
                strokeWidth: '97%',
                margin: 5, // margin is in pixels
                dropShadow: {
                    enabled: true,
                    top: 2,
                    left: 0,
                    color: '#999',
                    opacity: 1,
                    blur: 2
                }
            },
            dataLabels: {
                name: {
                    show: false
                },
                value: {
                    offsetY: -2,
                    fontSize: '22px'
                }
            }
        }
    },
    grid: {
        padding: {
            top: -10
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            shadeIntensity: 0.4,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 53, 91]
        },
    },
    labels: ['Average Results'],
};

// var chart2 = new ApexCharts(document.querySelector("#customerChart"), options2);
// chart2.render();