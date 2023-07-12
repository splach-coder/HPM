<?php
require_once '../auth/ensureAuthentication.php';
include '../config/db.php';
include '../utils/helpers/functions.php';
//company id where cluase
$whereClause = " AND company_id = '" . $_SESSION['companyID'] . "'";
$db = new db();
$conn = $db->getConnection();;
$categories = getSingleValue($conn, "`family`", "COUNT(*)", "1 $whereClause");
$products = getSingleValue($conn, "`products`", "COUNT(*)", "1 $whereClause");
$lowStock = getSingleValue($conn, "`products`", "COUNT(*)", "`stock` <= 5 AND `stock` >= 1 $whereClause;");
$outOfStock = getSingleValue($conn, "`products`", "COUNT(*)", "`stock` < 1 $whereClause;");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Products</title>
    <link rel="stylesheet" type="text/css" href="../controller/Changeablepallete.css.php">
    <?php include 'links.php' ?>

    <!-- css and js resourcess -->
    <!-- ##### CSS ######  -->
    <link rel="stylesheet" href="../static/css/table.css">
    <link rel="stylesheet" href="../static/css/client.css">
    <link rel="stylesheet" href="../static/css/produits.css">

    <!-- ##### JS ######  -->
    <script defer src=" ../static/js/sidebar.js">
    </script>
    <script defer src="../static/js/products/products.js"></script>
    <script defer src="../static/js/products/addProduct.js"></script>
    <script defer src="../static/js/products/updateProduct.js"></script>

    <style>
    .product-images {
        padding-top: 10px;
        max-height: 400px;
        overflow-y: scroll;
    }

    .delete-icon {
        display: flex;
    }

    .product-images::-webkit-scrollbar {
        background-color: #ccc;
        width: 2px;
        border-radius: 5px;
    }

    .product-images::-webkit-scrollbar-thumb {
        background-color: var(--light-primary);
        border-radius: 5px;
    }

    .product-image {
        position: relative;
        width: 40%;
        aspect-ratio: 1/1;
        padding: 10px;
        border: 1px solid #ccc;
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #show-image {
        top: 4%;
    }

    </style>
</head>

<body>
    <?php include 'sidebar.php' ?>
    <section class="home container-fluid">
        <div class="row w-100 me-0">
            <div class="col">
                <?php include 'header.php'; ?>
                <div class="row w-100 pb-5">
                    <div class="col-12 d-flex flex-column w-100 my-4 products-overview">
                        <div class="row">
                            <h6>Stock total</h6>
                        </div>
                        <div class="row d-flex w-100 row-cols-4">
                            <div class="col d-flex justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Categories
                                    </div>
                                    <div class="number py-2 ">
                                        <?= $categories ?>
                                    </div>
                                    <div class="s-title py-2">

                                    </div>
                                </div>
                                <div class="devider"></div>
                            </div>

                            <div class="col d-flex justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Total Products
                                    </div>
                                    <div class="number py-2 ">
                                        <?= $products ?>
                                    </div>
                                    <div class="s-title py-2">

                                    </div>
                                </div>
                                <div class="devider"></div>
                            </div>

                            <div class="col d-flex justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Low Stock
                                    </div>
                                    <div class="number py-2 ">
                                        <?= $lowStock ?>
                                    </div>
                                    <div class="s-title py-2">

                                    </div>
                                </div>
                                <div class="devider"></div>
                            </div>

                            <div class="col d-flex justify-content-between px-3">
                                <div>
                                    <div class="title py-2">
                                        Out of Stock
                                    </div>
                                    <div class="number py-2 ">
                                        <?= $outOfStock ?>
                                    </div>
                                    <div class="s-title py-2">
                                        Ordered
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-between">
                        <div class="title">
                            <span> Products </span> <span class="table-data-rows">| </span>
                        </div>
                        <div class="buttons">
                            <button type="button" class="hpm-button" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-plus"></i>
                                add Produit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row me-0">
                    <div class="col pb-5">
                        <table id="productsTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Prix</th>
                                    <th>Marge HT</th>
                                    <th>Stock status</th>
                                    <th>Unit</th>
                                    <th>Catégorie</th>
                                </tr>
                            </thead>
                            <tbo-dy>
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
                    <h3 class="modal-title">Products</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info">Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#price">Prix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#stock">Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#suppliers">Fournisseurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#note">Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#picture">picture</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content add">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="info">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="produitNom">Nom </label>
                                    <input type="text" id="produitNom" class="p-1" name="produitNom" placeholder="nom">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="category">Family </label>
                                    <select name="category" id="category" class="p-2">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select family</option>
                                    </select>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="unit">Unit </label>
                                    <select name="unit" id="unit" class="p-2 unitSelect">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select unit</option>
                                    </select>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="activite">Activite </label>
                                    <select name="activite" id="activite" class="p-2 activiteSelect">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select activite</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade show" id="price">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="prix">Prix d'achat </label>
                                    <input type="number" id="prix" class="p-1" name="prix" value="0.00">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="margeht">Marge HT </label>
                                    <input type="number" id="margeht" class="p-1" name="margeht" placeholder="marge HT"
                                        value="0.00" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="margeht100">Marge HT en %</label>
                                    <input type="number" id="margeht100" class="p-1" name="margeht100" max="100" min="0"
                                        value="0.00" placeholder="marge HT en %">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="prixvente">P.ventes TTC</label>
                                    <input type="number" id="prixvente" class="p-1" name="prixvente" value="0.00"
                                        placeholder="prix du vente ttc">
                                </div>
                            </div>

                        </div>

                        <!-- Suppliers Tab -->
                        <div class="tab-pane fade show" id="stock">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="stock">Stock </label>
                                    <input type="number" id="produitNomstock" class="p-1" name="stock" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- Suppliers Tab -->
                        <div class="tab-pane fade" id="suppliers">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="suppliers">Suppliers </label>
                                    <input type="text" id="suppliers" class="p-1 mb-2" name="suppliers"
                                        placeholder="search for suppliers">

                                    <select class="p-2" id="suppliers_list" name="suppliers_list">
                                        <option value="none">select supplier </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contacts Tab -->
                        <div class="tab-pane fade" id="note">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="desc">Description </label>
                                    <textarea id="desc" rows="7" cols="10" class="p-1" name="desc">
                                       </textarea>

                                    <label for="note">Note </label>
                                    <textarea id="note" rows="7" cols="10" class="p-1" name="note">
                                       </textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Infos Tab -->
                        <div class="tab-pane fade" id="picture">
                            <label for="drag-box" class="mt-2 mb-3 w-100 text-center fs-5  fw-bold  ">product images
                            </label>
                            <div class="product-images w-100 d-flex flex-wrap gap-3 justify-content-center">
                                <div class="drag-drop" id="drag-box">
                                    <div class="box add" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        <span class="drop-text">Drop down here or select a file</span>

                                    </div>
                                    <input type="file" name="image" id="fileInput" multiple="true"
                                        style=" display: none;" onchange="handleFileSelect(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add-product-button" class="hpm-button">Add Produit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- update product Modal -->
    <div id="showProduct" class="modal fade">
        <div class="modal-dialog" style="max-width: 550px !important;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Products</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#show-info">Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#show-price">Prix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#show-stock">Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#show-suppliers">Fournisseurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#show-note">Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#show-picture">picture</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content show">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="show-info">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="Show-produitNom">Nom </label>
                                    <input type="text" id="Show-produitNom" class="p-1" name="Show-produitNom"
                                        placeholder="nom">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-category">Family </label>
                                    <select name="Show-category" id="Show-category" class="p-2">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select family</option>
                                    </select>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-unit">Unit </label>
                                    <select name="Show-unit" id="Show-unit" class="p-2">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select unit</option>
                                    </select>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-activite">Activite </label>
                                    <select name="Show-activite" id="Show-activite" class="p-2">
                                        <!-- This option will be populated with data from an API -->
                                        <option value="none" selected=" selected">select activite</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade show" id="show-price">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="Show-prix">Prix d'achat </label>
                                    <input type="number" id="Show-prix" class="p-1" name="Show-prix" value="0.00">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-margeht">Marge HT </label>
                                    <input type="number" id="Show-margeht" class="p-1" name="Show-margeht"
                                        placeholder="marge HT" value="0.00" disabled>
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-margeht100">Marge HT en %</label>
                                    <input type="number" id="Show-margeht100" class="p-1" name="Show-margeht100"
                                        max="100" min="0" value="0.00" placeholder="marge HT en %">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="Show-prixvente">P.ventes TTC</label>
                                    <input type="number" id="Show-prixvente" class="p-1" name="Show-prixvente"
                                        value="0.00" placeholder="prix du vente ttc">
                                </div>
                            </div>

                        </div>

                        <!-- Suppliers Tab -->
                        <div class="tab-pane fade show" id="show-stock">
                            <div class="form d-flex flex-column gap-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="Show-stock">Stock </label>
                                    <input type="number" id="Show-stock" class="p-1" name="Show-stock" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- Suppliers Tab -->
                        <div class="tab-pane fade" id="show-suppliers">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="Show-suppliers">Suppliers </label>
                                    <input type="text" id="Show-suppliers" class="p-1 mb-2" name="Show-suppliers"
                                        placeholder="search for suppliers">

                                    <select class="p-2" id="Show-suppliers_list" name="Show-suppliers_list">
                                        <option value="none">select supplier </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contacts Tab -->
                        <div class="tab-pane fade" id="show-note">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="Show-desc">Description </label>
                                    <textarea id="Show-desc" rows="7" cols="10" class="p-1" name="Show-desc">
                                       </textarea>

                                    <label for="Show-note">Note </label>
                                    <textarea id="Show-note" rows="7" cols="10" class="p-1" name="Show-note">
                                       </textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Infos Tab -->
                        <div class="tab-pane fade" id="show-picture">
                            <label for="Show-drag-box" class="mt-2 mb-3 w-100 text-center fs-5  fw-bold">product
                                images
                            </label>
                            <i id="show-image" class="fas fa-eye hpm-button-secondary" data-bs-toggle="modal"
                                data-bs-target="#imageModal" style="position: absolute;">
                            </i>
                            <div class="Show-product-images w-100 d-flex flex-wrap gap-3 justify-content-center">
                                <div class="drag-drop" id="Show-drag-box">
                                    <div class="box show" ondrop=" Showdrop(event)" ondragover="allowDrop(event)">
                                        <span class="drop-text">Drop down here or select a file</span>
                                    </div>
                                    <input type="file" name="image" id="Show-fileInput" multiple="true"
                                        style=" display: none;" onchange=" ShowhandleFileSelect(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="update-product-button" class="hpm-button disabled">Update Produit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content img">
                <div class="modal-body img">
                    <div class="swiper-container" style="overflow: hidden;">
                        <div class="swiper-wrapper">

                        </div>

                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
    </script>

</body>

</html>
