<?php
require_once '../auth/ensureAuthentication.php';
include '../config/db.php';
include '../utils/helpers/functions.php';
$db = new db();
$conn = $db->getConnection();

//company id where cluase
$whereClause = " AND company_id = '" . $_SESSION['companyID'] . "'";

$purchases7 = getSingleValue($conn, "`purchase`", "COUNT(*)", "purchase_date >= NOW() - INTERVAL 7 DAY $whereClause"); //SELECT COUNT(*) FROM purchase WHERE purchase_date >= NOW() - INTERVAL 7 DAY;
$purchases30 = getSingleValue($conn, "`purchase`", "COUNT(*)", "purchase_date >= NOW() - INTERVAL 30 DAY $whereClause ");
$sumPurchases = getSingleValue($conn, "`purchase`", "SUM(price)", "purchase_date >= NOW() - INTERVAL 7 DAY $whereClause");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Purchases</title>
    <?php include 'links.php' ?>

    <!-- css and js resourcess -->
    <!-- ##### CSS ######  -->
    <link rel="stylesheet" href="../static/css/table.css">
    <link rel="stylesheet" href="../static/css/client.css">
    <link rel="stylesheet" href="../static/css/produits.css">

    <!-- ##### JS ######  -->
    <script defer src=" ../static/js/sidebar.js">
    </script>
    <script defer src="../static/js/purchase/purchase.js"></script>
    <script defer src="../static/js/purchase/addPurchase.js"></script>
    <script defer src="../static/js/purchase/updatePurchase.js"></script>

    <script defer src="../static/js/charts/purchaseChart.js"></script>

</head>

<body>
    <?php include 'sidebar.php' ?>
    <section class="home container-fluid">
        <div class="row w-100 me-0">
            <div class="col">
                <?php include 'header.php'; ?>
                <div class="row w-100 pb-5">
                    <div class="col d-flex align-items-center justify-content-between">
                        <div class="title">
                            <span> Purchases </span> <span class="table-data-rows"> |
                                <?= $purchases30 ?> purchases this month
                            </span>
                        </div>
                        <div class="buttons">
                            <button type="button" class="hpm-button" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-plus"></i>
                                add Purchase
                            </button>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-column w-100 my-4 products-overview">
                        <div class="row d-flex w-100 row-cols-3">
                            <div class="col-3 d-flex  align-items-center  justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Purchases
                                    </div>
                                    <div class="number py-2 ">
                                        <?= $purchases7 ?>
                                    </div>
                                    <div class="s-title py-2">
                                        last 7 days ago
                                    </div>
                                </div>
                                <div class="devider"></div>
                            </div>

                            <div class="col-3 d-flex align-items-center justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Total Price
                                    </div>
                                    <div class="number py-2 ">
                                        <?= ($sumPurchases) == '' ? 0 : $sumPurchases; ?>
                                    </div>
                                    <div class="s-title py-2">
                                        last 7 days ago
                                    </div>
                                </div>
                                <div class="devider"></div>
                            </div>

                            <div class="col-6 d-flex">
                                <div class="chartdiv" id="chartdiv" style="width: 100%;height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row me-0">
                    <div class="col pb-5">
                        <table id="purchasesTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produit Name</th>
                                    <th>Supplier Name</th>
                                    <th>Prix</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>

    <!-- add product Modal -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog" style="max-width: 550px !important;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Purchases</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#Produit">Produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#price">Prix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#stock">Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#note">Note</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content add">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="Produit">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="query">Search </label>
                                    <input type="text" id="query" class="p-1" name="query" placeholder="produit id or nom">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="produits">Produits </label>
                                    <select name="produits" id="produits" class="p-2">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select produits</option>
                                    </select>
                                </div>

                                <input type="hidden" name="produitID" id="produitID">

                                <div class="form-group d-flex flex-column">
                                    <label for="query">Produit nom </label>
                                    <input type="text" id="produitNom" class="p-1" name="produitNom" placeholder="produit nom">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="price">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="prix">Prix d'achat </label>
                                    <input type="number" id="prix" class="p-1" name="prix" placeholder="prix d'achat" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="margeht">Marge HT </label>
                                    <input type="number" id="margeht" class="p-1" name="margeht" placeholder="marge HT" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="margeht100">Marge HT en %</label>
                                    <input type="number" id="margeht100" class="p-1" name="margeht100" max="100" min="0" placeholder="marge HT en %" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="prixvente">P.ventes TTC</label>
                                    <input type="number" id="prixvente" class="p-1" name="prixvente" placeholder="prix du vente ttc" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="prixActuel">Prix d'achat Actuel</label>
                                    <input type="number" id="prixActuel" class="p-1" name="prixActuel" value="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- stock Tab -->
                        <div class="tab-pane fade show" id="stock">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="stock">Stock </label>
                                    <input type="number" id="stockI" class="p-1" name="stock" disabled>
                                </div>


                                <div class="form-group d-flex flex-column">
                                    <label for="stockActuel">Stock Actuel</label>
                                    <input type="number" id="stockActuel" class="p-1" name="stockActuel" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- note Tab -->
                        <div class="tab-pane fade" id="note">
                            <div class="form d-flex gap-2">
                                <div class="form-group d-flex flex-column w-100">
                                    <label for="note">Note </label>
                                    <textarea id="note" rows="14" cols="14" class="p-1" name="note">
                                       </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add-purchase-button" class="hpm-button">Add Purchase</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add product Modal -->
    <div id="showPurchase" class="modal fade">
        <div class="modal-dialog" style="max-width: 550px !important;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Purchases</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#ProduitS">Produit</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#noteS">Note</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content show">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="ProduitS">
                            <div class="form d-flex flex-column gap-3">
                                <input type="hidden" name="Show-purchaseID" id="Show-purchaseID">

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-produitNom">Produit nom </label>
                                    <input type="text" id="Show-produitNom" class="p-1" name="Show-produitNom" placeholder="produit nom" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-supplier">Supplier </label>
                                    <input type="text" id="Show-supplier" class="p-1" name="Show-supplier" placeholder="produit nom" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-prix">Prix</label>
                                    <input type="number" id="Show-prix" class="p-1" name="Show-prix" value="0.00">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-stock">Quantity </label>
                                    <input type="number" id="Show-stock" class="p-1" name="Show-stock">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-date">Date </label>
                                    <input type="text" id="Show-date" class="p-1" name="Show-date" value="0" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- note Tab -->
                        <div class="tab-pane fade show" id="noteS">
                            <div class="form d-flex gap-2">
                                <div class="form-group d-flex flex-column w-100">
                                    <label for="Show-note">Note </label>
                                    <textarea id="Show-note" rows="14" cols="14" class="p-1" name="Show-note">
                                       </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="update-purchase-button" class="hpm-button disabled">Update
                        Purchase</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>