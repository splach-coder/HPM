<?php
require_once '../auth/ensureAuthentication.php';
//get infos 
include '../config/db.php';
include '../utils/helpers/functions.php';

//connect with db
$db = new db();
$conn = $db->getConnection();


//company id where cluase
$whereClause = " AND company_id = '" . $_SESSION['companyID'] . "'";

//get the clients data
$clients = getSingleValue(
    $conn,
    "`clients`",
    "COUNT(*)",
    "1 $whereClause"
);

//get the suppliers data
$suppliers = getSingleValue(
    $conn,
    "`suppliers`",
    "COUNT(*)",
    "1 $whereClause"
);

//get the total value data
$totalValue = getSingleValue(
    $conn,
    "`products`",
    "COALESCE(SUM(purchase_price * stock), 0)",
    "1 $whereClause"
);

//get the quantity in hand data
$quantityInHand = getSingleValue(
    $conn,
    "`products`",
    "COALESCE(SUM(stock), 0)",
    "1 $whereClause "
);

//get the products data
$products = getSingleValue(
    $conn,
    "`products`",
    "COUNT(*)",
    "1 $whereClause "
);

//get the low stock data
$lowStock = getSingleValue(
    $conn,
    "`products`",
    "COUNT(*)",
    "stock_status = 'Stock faible' $whereClause"
);

//get the products data
$categories = getSingleValue(
    $conn,
    "`family`",
    "COUNT(*)",
    "1 $whereClause "
);

//get the purchases data
$purchases = getSingleValue(
    $conn,
    "`purchase`",
    "COUNT(*)",
    "YEAR(purchase_date) = YEAR(CURDATE()) AND MONTH(purchase_date) = MONTH(CURDATE()) $whereClause"
);



$purchasesCoast = getSingleValue(
    $conn,
    "`purchase`",
    "COALESCE(SUM(Quantity * price), 0) AS total_cost",
    "YEAR(purchase_date) = YEAR(CURDATE()) AND MONTH(purchase_date) = MONTH(CURDATE()) $whereClause"
);


$purchasesAvgQuantity = getSingleValue(
    $conn,
    "`purchase`",
    "COALESCE(AVG(Quantity), 0)",
    "YEAR(purchase_date) = YEAR(CURDATE()) AND MONTH(purchase_date) = MONTH(CURDATE()) $whereClause"
);

$purchaseFrequency = getSingleValue(
    $conn,
    "`purchase`",
    "COUNT(*) / DAY(CURDATE()) AS purchase_frequency",
    "YEAR(purchase_date) = YEAR(CURDATE()) AND MONTH(purchase_date) = MONTH(CURDATE()) $whereClause"
);

//get the sales data
$sales = getSingleValue(
    $conn,
    "`sales`",
    "COUNT(*)",
    "YEAR(sale_date) = YEAR(CURDATE()) AND MONTH(sale_date) = MONTH(CURDATE()) $whereClause"
);

$revenue = getSingleValue(
    $conn,
    "`sales`",
    "COALESCE(SUM(price * quantity), 0)",
    "YEAR(sale_date) = YEAR(CURDATE()) AND MONTH(sale_date) = MONTH(CURDATE()) $whereClause"
);

$salesCoast = getSingleValue(
    $conn,
    "`sales`",
    "COALESCE(SUM(Quantity * price), 0)",
    "YEAR(sale_date) = YEAR(CURDATE()) AND MONTH(sale_date) = MONTH(CURDATE()) $whereClause"
);

$salesProfit = getSingleValue(
    $conn,
    "`purchase`",
    "COALESCE(SUM(price * quantity) - $revenue, 0)",
    "YEAR(purchase_date) = YEAR(CURDATE()) AND MONTH(purchase_date) = MONTH(CURDATE()) $whereClause"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../controller/Changeablepallete.css.php">
    <?php include 'links.php' ?>

    <!-- css and js resourcess -->
    <!-- ##### CSS ######  -->
    <link rel="stylesheet" type="text/css" href="../static/css/dashboard.css">

    <!-- ##### JS ######  -->
    <script defer src="../static/js/sidebar.js"></script>
    <script defer src="../static/js/charts/dashboardChart.js"></script>
</head>

<body>
    <?php include 'sidebar.php' ?>
    <section class="home container-fluid">
        <div class="row w-100 me-0">
            <div class="col w-100">
                <?php include 'header.php'; ?>
                <div class="row w-100 row-cols-2 mb-3 justify-content-between">
                    <div class="col-6 dash-part" style="max-width: 49% !important;">
                        <div class="row">
                            <div class="title-chart fs-6">
                                Sales Overview
                            </div>
                        </div>
                        <div class="row row-cols-2 px-3">
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/sales.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Total Sales
                                        </div>
                                        <div class="number">
                                            <?= $sales ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/revenue.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Revenue
                                        </div>
                                        <div class="number">
                                            <?= $revenue ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/dollar.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Cost
                                        </div>
                                        <div class="number">
                                            <?= $salesCoast ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/up.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Profit
                                        </div>
                                        <div class="number">
                                            <?= $salesProfit ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 dash-part" style="max-width: 49% !important;">
                        <div class="row">
                            <div class="title-chart fs-6">
                                Purchases Overview
                            </div>
                        </div>
                        <div class="row row-cols-2 px-3">
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/sales.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            No of purchases
                                        </div>
                                        <div class="number">
                                            <?= $purchases ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/calendar.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Purchase Frequency
                                        </div>
                                        <div class="number">
                                            <?= $purchaseFrequency ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/dollar.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Coast
                                        </div>
                                        <div class="number">
                                            <?= $purchasesCoast ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 py-4">
                                <div class="row">
                                    <div class="col-3 icon">
                                        <img src="../static/images/icons/pieChart.png" alt="">
                                    </div>
                                    <div class="col-9 infos">
                                        <div class="title">
                                            Average Quantity
                                        </div>
                                        <div class="number">
                                            <?= $purchasesAvgQuantity ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 row-cols-3 mb-3 justify-content-between">
                    <div class="col-4 dash-part" style="max-width: 32.5% !important;">
                        <div class="row mb-2">
                            <div class="title-chart fs-6">
                                Inventory summary
                            </div>
                        </div>
                        <div class="row row-cols-2 px-3 justify-content-between">
                            <div class="col summary" style="max-width: 49% ">
                                <div class="row">
                                    <div class="icon S">
                                        <img src=" ../static/images/icons/box.png" alt="icon">
                                    </div>
                                    <div class="infos S">
                                        <div class="title">
                                            Quanitity in Hand
                                        </div>
                                        <div class="number">

                                            <?= $quantityInHand ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col summary" style="max-width: 49%">
                                <div class="row">
                                    <div class="icon S">
                                        <img src="../static/images/icons/coins.png" alt="icon">
                                    </div>
                                    <div class="infos S">
                                        <div class="title">
                                            Total Value
                                        </div>
                                        <div class="number">
                                            <?= $totalValue ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 dash-part" style="max-width: 32.5% !important;">
                        <div class="row mb-2">
                            <div class="title-chart fs-6">
                                Product Details
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="m-0 px-3">
                                    <li class="d-flex justify-content-between align-items-center py-2">
                                        <div class="title fs-6">
                                            Low Stock items
                                        </div>
                                        <div class="number">
                                            <?= $lowStock ?>
                                        </div>
                                    </li>
                                    <hr style="max-width: 70%;" class="my-0 py-0 ms-5">
                                    <li class="d-flex justify-content-between align-items-center py-2">
                                        <div class="title fs-6">
                                            item Group
                                        </div>
                                        <div class="number">
                                            <?= $categories ?>
                                        </div>
                                    </li>
                                    <hr style="max-width: 70%;" class="my-0 py-0 ms-5">
                                    <li class="d-flex justify-content-between align-items-center py-2">
                                        <div class="title fs-6">
                                            No of items
                                        </div>
                                        <div class="number">
                                            <?= $products ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 dash-part" style="max-width: 32.5% !important;">
                        <div class="row mb-2">
                            <div class="title-chart fs-6">
                                Inventory summary
                            </div>
                        </div>
                        <div class="row row-cols-2 px-3 justify-content-between">
                            <div class="col summary" style="max-width: 49% ">
                                <div class="row">
                                    <div class="icon S">
                                        <img src=" ../static/images/icons/users.png" alt="icon">
                                    </div>
                                    <div class="infos S">
                                        <div class="title">
                                            Clients
                                        </div>
                                        <div class="number">
                                            <?= $clients ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col summary" style="max-width: 49%">
                                <div class="row">
                                    <div class="icon S">
                                        <img src="../static/images/icons/users.png" alt="icon">
                                    </div>
                                    <div class="infos S">
                                        <div class="title">
                                            Suppliers
                                        </div>
                                        <div class="number">
                                            <?= $suppliers ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- the chart data -->
                <div class="row w-100 row-cols-1">
                    <div class="col dash-part">
                        <div class="title-chart py-4">
                            Sales And Purchases Statistics
                        </div>
                        <div id="chartdiv" style="width: 100%;height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>

</html>