<?php 
    require_once("../connect.php");

    //order in every month of this year
    $year = date("Y",time());//2022
    $month = date("m",time());//02
    $day = date("d",time());//02

    $noP = $dbs->query("SELECT COUNT(pro_id) FROM products")->fetchColumn();
    $noT = $dbs->query("SELECT COUNT(pro_t_id) FROM product_type")->fetchColumn();
    $noB = $dbs->query("SELECT COUNT(br_id) FROM product_brand")->fetchColumn();
    $noC = $dbs->query("SELECT COUNT(cust_id) FROM customer")->fetchColumn();
    $noO = $dbs->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $noTO = $dbs->query("SELECT COUNT(*) FROM orders WHERE  DAY(ord_date) = $day")->fetchColumn();
    $noTC = $dbs->query("SELECT COUNT(cust_id) FROM customer WHERE  DAY(registered_at) = $day")->fetchColumn();


    $getProducSaleInMonths = $dbs->query("SELECT DAY(ord_list_date_added) DAY, SUM(ord_list_qty) COUNT
                                          FROM order_list 
                                          WHERE YEAR(ord_list_date_added)=$year
                                          GROUP BY DAY(ord_list_date_added) 
                                          ORDER BY DAY");

    $getProducSaleInMonths->execute();
    $allsaleProduct = $getProducSaleInMonths->fetchAll(PDO::FETCH_ASSOC);
    $allProductSaleInMonths = [];
    $allProductSaleInCount = [];
        foreach($allsaleProduct as $ord){
            array_push($allProductSaleInMonths,$ord['DAY']);
            array_push($allProductSaleInCount,$ord['COUNT']);
        }    
        
    //total product sell in month
    $totalProductSellQuery = $dbs->query("SELECT SUM(ord_list_product_price*ord_list_qty) total FROM order_list WHERE MONTH(ord_list_date_added)=$month");
    $totalProductSell = $totalProductSellQuery->fetch()['total'];

    //order in every month of this year    
    $getOrderInMonths = $dbs->query("SELECT MONTH(ord_date) MONTHS, COUNT(*) COUNTS
                                     FROM orders 
                                     WHERE YEAR(ord_date)=$year
                                     GROUP BY MONTH(ord_date) ORDER BY MONTHS");
    $getOrderInMonths->execute();
    $allOrders = $getOrderInMonths->fetchAll(PDO::FETCH_ASSOC);
    $allOrdersMonths = [];
    $allOrdersCount = [];
        foreach($allOrders as $ord){
            array_push($allOrdersMonths,$ord['MONTHS']);
            array_push($allOrdersCount,$ord['COUNTS']);
        }
    
    //daily profit of selling products
    $dayProfitSellingProducts = $dbs->query("SELECT products.price_buy,order_list.ord_list_product_price,order_list.ord_list_qty
                FROM order_list
                    LEFT JOIN products
                        ON products.pro_id = order_list.ord_list_product
                WHERE MONTH(order_list.ord_list_date_added)=$month AND DAY(order_list.ord_list_date_added)=$day");
    $dayProfitSellingProducts->execute();
    $dayProfitSellingProductsCount = $dayProfitSellingProducts->fetchAll(PDO::FETCH_ASSOC);
    $SumOfDaylyProfit=0;
    foreach($dayProfitSellingProductsCount as $row){        
        $SumOfDaylyProfit = $SumOfDaylyProfit + ($row['ord_list_product_price']-$row['price_buy']) * $row['ord_list_qty'];       
    }
    //monthly profit of selling products
    $monthProfitSellingProducts = $dbs->query("SELECT products.price_buy,order_list.ord_list_product_price,order_list.ord_list_qty
                FROM order_list
                    LEFT JOIN products
                        ON products.pro_id = order_list.ord_list_product
                WHERE MONTH(order_list.ord_list_date_added)=$month");
    $monthProfitSellingProducts->execute();
    $monthProfitSellingProductsCount = $monthProfitSellingProducts->fetchAll(PDO::FETCH_ASSOC);
    $SumOfMonthlyProfit=0;
    foreach($monthProfitSellingProductsCount as $row){        
        $SumOfMonthlyProfit = $SumOfMonthlyProfit + ($row['ord_list_product_price']-$row['price_buy']) * $row['ord_list_qty'];       
    }
    //annual profit of selling products
    $annualProfitSellingProducts = $dbs->query("SELECT products.price_buy,order_list.ord_list_product_price,order_list.ord_list_qty
                FROM order_list
                    LEFT JOIN products
                        ON products.pro_id = order_list.ord_list_product
                WHERE YEAR(order_list.ord_list_date_added)=$year");
    $annualProfitSellingProducts->execute();
    $annualProfitSellingProductsCount = $annualProfitSellingProducts->fetchAll(PDO::FETCH_ASSOC);
    $SumOfYearlyProfit=0;
    foreach($annualProfitSellingProductsCount as $row){        
        $SumOfYearlyProfit = $SumOfYearlyProfit + ($row['ord_list_product_price']-$row['price_buy']) * $row['ord_list_qty'];       
    }

    //get products sold in every day of current month
    $productSolidInEveryDay = $dbs->query("SELECT SUM(ord_list_qty) AS AVG
                                                  FROM order_list 
                                                  WHERE MONTH(ord_list_date_added)=$month AND  YEAR(ord_list_date_added)=$year ");
    $productSolidInEveryDay->execute();
    $PSIDOM = $productSolidInEveryDay->fetch(PDO::FETCH_ASSOC)['AVG'];

    //order payment methods
    $orderPaymentMethods = $dbs->query("SELECT COUNT(ord_id) AS ORD,ord_payment FROM orders GROUP BY ord_payment");
    $orderPaymentMethods->execute();
    $PAYMethod=[];
    $PAYMethodCount=[];
    $OPM = $orderPaymentMethods->fetchAll(PDO::FETCH_ASSOC);

        foreach($OPM as $payment){
            $OP = '"'.$payment['ord_payment'].'"';
            array_push($PAYMethod,$OP);
            array_push($PAYMethodCount,$payment['ORD']);
        }        
     
    //get products sold in every day of current month
    $productSolidInEveryDayOfMonth = $dbs->query("SELECT CAST(ord_list_date_added AS date) AS DA,COUNT(ord_list_product)  AS PRO,SUM(ord_list_qty) AS AVG
                                                  FROM order_list 
                                                  WHERE MONTH(ord_list_date_added)=$month AND  YEAR(ord_list_date_added)=$year
                                                  GROUP BY DA");
    $productSolidInEveryDayOfMonth->execute();
    $PSEDOM = [];
    $PSEDOP = [];
    $PSEDOAP = [];
    while($DATES = $productSolidInEveryDayOfMonth->fetch(PDO::FETCH_ASSOC)){
      array_push($PSEDOP,$DATES['PRO']);
      array_push($PSEDOAP,$DATES['AVG']);
      $dt = "'".$DATES['DA']."'";
      array_push($PSEDOM,$dt);
    }

    //today orders
    //$cartQuery = $dbs->query("SELECT * FROM orders  WHERE date(ord_date) = current_date ORDER BY ord_date DESC;");
    $ordersDelivered = $dbs->query("SELECT * FROM orders WHERE ord_status='delivered'");
    $ordersCanceled = $dbs->query("SELECT * FROM orders WHERE ord_status='canceled'");
    $ordersOfToday = $dbs->query("SELECT * FROM orders WHERE  date(ord_date) = current_date");
        ?>
        <!-- Order Start -->
            <div class="container bg-white pt-4">
                <div class="row">
                    <div class="col-lg-8 p-2  border-right border-light">                      
                        <div class="  ">
                            <h2 class="text-primary ml-3"> <i class="fa fa-chart-bar"></i> Reports </h2>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card-counter">
                                            <i class="fa fa-folder text-primary"></i>
                                            <span class="count-numbers"><?php echo $noP;?></span>
                                            <span class="count-name">Products</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card-counter">
                                            <i class="fa fa-database text-primary"></i>
                                            <span class="count-numbers"><?php echo $noO."/<small>".$noTO."<sup>Today</sup></small>";?></span>
                                            <span class="count-name">Orders</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card-counter">
                                            <i class="fa fa-users text-primary"></i>
                                            <span class="count-numbers"><?php echo $noC."/<small>".$noTC."<sup>Today</sup></small>";?></span>
                                            <span class="count-name">Customers</span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> 
                            <div class="container">
                                <div class="d-flex justify-content-between">
                                    <div class=" mb-3 mt-3">
                                        <span class="d-block font-weight-bold">Daily profit</span>
                                        <h2 class="card-title  text-primary mb-0"><sup>$</sup><?php echo number_format($SumOfDaylyProfit);?></h2>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <span class="d-block font-weight-bold">Monthly profit</span>
                                        <h2 class="card-title  text-primary mb-0"><sup>$</sup><?php echo number_format($SumOfMonthlyProfit);?></h2>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <span class="d-block font-weight-bold">Annual profit</span>
                                        <h2 class="card-title  text-primary mb-0"><sup>$</sup><?php echo number_format($SumOfYearlyProfit);?></h2>
                                    </div>
                                </div>
                            </div>                             
                            <div class="container mt-2">
                                <div id="allOrders"></div>
                            </div>

                            <div class="container">
                                <div id="profitChart"> </div>
                            </div>
                            
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="m-0 font-weight-bold">Store Statistics</h5>
                                            <small class="text-muted"><?php echo $noP;?> product in store</small>
                                            <ul class="p-0 m-0 list-group list-group-flush">
                                            <?php 
                                                $productTypesQuery = $dbs->query("SELECT * FROM product_type");
                                                $productTypesQuery->execute();
                                                while($type = $productTypesQuery->fetch(PDO::FETCH_ASSOC)){
                                                    $typeID = $type['pro_t_id'];
                                                    $getProductByType = $dbs->query("SELECT * FROM products WHERE pro_t_id=$typeID;");
                                                    $getProductByType->execute();
                                                ?>
                                                <li class="mb-2 pb-1 list-group-item">
                                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                                                        <h6 class="mb-0 text-success font-weight-bold"><?php echo $type['type'];?></h6>
                                                        <span class="badge badge-success p-1"><?php echo $getProductByType->rowCount();?> <sup>Items</sup></span>
                                                    </div>
                                                    <div class="row" style="height:100px;overflow:scroll;width:100%;">
                                                        <?php 
                                                            while($pro = $getProductByType->fetch(PDO::FETCH_ASSOC)){
                                                            ?>
                                                            <div class="col-lg-1 text-left">
                                                                <span class="p-1 badge <?php echo ($pro['pro_amount']>0) ? " badge-primary " : " badge-danger ";?> ">
                                                                    <?php echo $pro['pro_amount'];?> <sup>Qty</sup>
                                                                </span>
                                                            </div>
                                                            <div class="col-lg-11">
                                                                <small class="pl-3 text-muted"> <?php echo $pro['pro_name'];?></small>
                                                            </div>
                                                            
                                                        <?php 
                                                            }
                                                            ?>
                                                    </div>
                                                </li>
                                            <?php 
                                                }
                                                ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>             
                    </div>
                    <div class="col-lg-4 p-0">                        
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-8">
                                        <h5 class="card-title mb-1 text-nowrap text-warning">Congratulations Owner!</h5>
                                        <small class="d-block">Best seller of the month</small>
                                        <h2 class="card-title m-0 text-primary"><sup>$</sup><?php echo number_format($totalProductSell);?></h2>
                                        <small class="d-block mb-2 pb-1 text-muted"><?php echo round(($totalProductSell*100)/$target_price);?>% of target $<?php echo number_format($target_price);?></small>
                                </div>
                                <div class="col-4 pt-2 ps-0">
                                    <img src="../img/prize-light.png" alt="View Sales" width="80" height="130">
                                </div>
                            </div>
                        </div>

                        <div class="container mt-2 pb-2">
                            <div id="productsSoldInDay"></div>  
                        </div>

                        <div class="container"> 
                            <div class="row"> 
                                <div class="col-lg-12 mb-4 mt-4">
                                    <span class="font-weight-bold">New customers</span>
                                    <h2 class="text-primary "><?php echo $noC;?></h2>
                                    <small class="text-muted d-block">customers of target <?php echo $target_customers;?> customers</small>
                                    <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-primary" style="width: 22%" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="pl-2 font-weight-bold"> <?php echo round(($noC*100)/$target_customers)."%";?> </small>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <span class="font-weight-bold">Monthly product sales</span>
                                    <div class="p-1">
                                        <small class="text-muted d-block text-left"><?php echo $PSIDOM;?> products sold of target <?php echo $target_sales;?></small>
                                    </div>
                                    <div id="circle1"></div>
                                </div>

                                <div class="col-lg-12 mb-4 mt-2">
                                    <span class="d-block font-weight-bold">Monthly orders</span>
                                     <div class="p-1">
                                        <small class="text-muted d-block text-left"><?php echo $noO;?> order of target <?php echo $target_orders;?>  </small>
                                    </div>
                                    <div id="circle2"></div>
                                </div>

                                <div class="col-lg-12 mb-4 mt-2">
                                    <span class="d-block font-weight-bold">Daily profit</span>
                                    <div  class="p-1">
                                        <small class="text-muted d-block text-left">$<?php echo number_format($SumOfDaylyProfit);?> profit of target $<?php echo number_format($target_profit);?></small>
                                    </div>
                                    <div id="circle3"></div>
                                </div>

                            </div>
                        </div> 

                        <div class="container mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <span class="font-weight-bold">Payment methods</span>
                                    <div id="paymentMethods"> </div> 
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <!-- Order End -->
<script>
var allOrdersOPS = {
    series: [{
        name: "Orders",
        data: [<?php echo implode(',',$allOrdersCount);?>],
    }],
    chart: {
        type: 'area',
        background: '#FFFFFF',
        height: 300,
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    colors: ['#FF6F61'],
    stroke: {
        colors: ['#007bff'],
        curve: ['smooth', 'straight', 'stepline'],
        width: 2
    },
    fill: {
        type: "gradient",
        gradient: { 
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [50, 90, 100]
        }
    },
    title: {
        text: 'Annual orders',
        align: 'left'
    },
    // colors: ["#FF0080"],
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'],
    },
    legend: {
        horizontalAlign: 'left'
    }
};
var allOrders = new ApexCharts(document.querySelector("#allOrders"), allOrdersOPS);
    allOrders.render();

var profitChartOPS = {
    series: [{
        name: "product",
        data: [<?php echo implode(',',$allProductSaleInCount);?>]
    }],
    chart: {
        height: 400,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width:2
    },
    title: {
        text: 'Products sold in <?php echo date("F");?>',
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#007bff', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.1
        },
    },
    xaxis: {
        // type: 'datetime',
        categories: [<?php echo implode(',',$allProductSaleInMonths);?>],
    }
};
var profitChart = new ApexCharts(document.querySelector("#profitChart"), profitChartOPS);
profitChart.render();

var productsSoldInDay = {
        series: [
            {
          name: 'products',
          data: [<?php echo implode(',',$PSEDOP);?>],
          type: 'column',
        },
        {
          name: 'Quantity of product',
          type: 'column',
          data: [<?php echo implode(',',$PSEDOAP);?>]
        }],
        title: {
            text: 'Products ordered in each day',
            align: 'left'
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [0]
        },
        chart: {
            zoom:{
               enabled: false
              },
            type: 'bar',
            stacked: true,
            height: 290,
        },
        plotOptions: {
          bar: {
            columnWidth: '80%',
            borderRadius: 5,
            endingShape: 'rounded',
          }
        },
        dataLabels: {
          enabled: false,
        },
        yaxis: {
          title: {
            text: 'Products',
          },
        },
        xaxis: {
          type: 'datetime',
          categories: [<?php echo implode(',',$PSEDOM);?>],
          labels: {
            format: 'dd/MM',
            rotate: -45
          }
        }
};
var productsSoldInDaychart = new ApexCharts(document.querySelector("#productsSoldInDay"), productsSoldInDay);
productsSoldInDaychart.render();

var productSales = {
        series: [<?php echo round(($PSIDOM*100)/$target_sales);?>],
          chart: {
            type: 'radialBar',
            offsetY: 0,
            height:200,
            sparkline: {
                enabled: true
            },
        },
        plotOptions: {
          radialBar: {
            startAngle: 90,
            endAngle: 180, 
            track: { 
              background: "#FF6F61",
              strokeWidth: '50%',
              margin: 15,
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                fontSize: '30px'
              }
            },
          },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,      
        },
    };



var productSalesChart= new ApexCharts(document.querySelector("#circle1"), productSales);
productSalesChart.render();

var orders = {
        series: [<?php echo round(($noO*100)/$target_orders);?>],
          chart: {
            height:200,
            type: 'radialBar',
            sparkline: {
                enabled: true
            },
        },
        plotOptions: {
          radialBar: {
            // startAngle: -45,
            // endAngle: 45, 
            track: { 
              background: "#FF6F61",
              strokeWidth: '50%',
              margin: 15,
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                fontSize: '30px'
              }
            },
          },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            width: 2,
            dashArray: 0,      
        },
    };
var ordersChart= new ApexCharts(document.querySelector("#circle2"), orders);
ordersChart.render();

var profit = {
        series: [<?php echo round(($SumOfDaylyProfit*100)/$target_profit);?>],
          chart: {
            type: 'radialBar',
            height:200,
            sparkline: {
                enabled: true
            },
        },
        plotOptions: {
          radialBar: {
            startAngle:0,
            endAngle: 90, 
            track: { 
              background: "#FF6F61",
              strokeWidth: '50%',
              margin: 15,
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                fontSize: '30px'
              }
            },
          },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,      
        },
};
var profitChart= new ApexCharts(document.querySelector("#circle3"), profit);
profitChart.render();

var paymentmethodsOPS = {
          series: [<?php echo implode(',',$PAYMethodCount);?>],
          chart: {
          height:200,
          type: 'donut',
        },
        plotOptions: {
              pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 0
              }
            },
        labels: [<?php echo implode(',',$PAYMethod);?>],      
        dataLabels: {
          enabled: false
        },
        responsive: [{
          breakpoint: 100,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

var paymentMethods = new ApexCharts(document.querySelector("#paymentMethods"), paymentmethodsOPS);
    paymentMethods.render();

</script>



