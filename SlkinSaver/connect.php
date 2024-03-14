<?php
    $dsn = 'mysql:dbname=saveskin;host=127.0.0.1';
    $user = 'root';
    $password = '';
    $dbs = new PDO($dsn, $user, $password);
    $dbs->exec("SET CHARACTER SET utf8");// Sets encoding UTF-8
    
    //set Baghdad time zoon
    date_default_timezone_set("Asia/Baghdad");
    //system status
    $checkSystemQuery  = $dbs->query("SELECT * FROM settings WHERE setting_key='operating';");
    $checkSystemQuery->execute();
    $operating = $checkSystemQuery->fetch(PDO::FETCH_ASSOC)['setting_value'];
    //fav product id
    $fav_product_query = $dbs->query("SELECT * FROM settings WHERE setting_key='fav_product';");
    $fav_product_query->execute();
    $fav_product = $fav_product_query->fetch(PDO::FETCH_ASSOC)['setting_value'];
    //target price
    $target_price_query = $dbs->query("SELECT setting_value FROM settings WHERE setting_key='target_price'");
    $target_price_query->execute();
    $target_price = $target_price_query->fetch()['setting_value'];
    //target profit
    $target_profit_query = $dbs->query("SELECT setting_value FROM settings WHERE setting_key='target_profit'");
    $target_profit_query->execute();
    $target_profit = $target_profit_query->fetch()['setting_value'];
    //target of customers
    $target_customers_query = $dbs->query("SELECT setting_value FROM settings WHERE setting_key='target_customers'");
    $target_customers_query->execute();
    $target_customers = $target_customers_query->fetch()['setting_value'];
    //target of orders
    $target_orders_query = $dbs->query("SELECT setting_value FROM settings WHERE setting_key='target_orders'");
    $target_orders_query->execute();
    $target_orders = $target_orders_query->fetch()['setting_value'];
    //target of sales
    $target_sales_query = $dbs->query("SELECT setting_value FROM settings WHERE setting_key='target_sales'");
    $target_sales_query->execute();
    $target_sales = $target_sales_query->fetch()['setting_value'];

    ?>