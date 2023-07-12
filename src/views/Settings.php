<?php
require_once '../auth/ensureAuthentication.php';

//
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Settings</title>
    <link rel="stylesheet" type="text/css" href="../controller/Changeablepallete.css.php">
    <?php include 'links.php' ?>

    <!-- css and js resourcess -->
    <!-- ##### CSS ######  -->
    <link rel="stylesheet" type="text/css" href="../static/css/client.css">
    <link rel="stylesheet" type="text/css" href="../static/css/settings.css">
    <link rel="stylesheet" type="text/css" href="../static/css/pallete-generator.css">

    <!-- ##### JS ######  -->
    <script defer src="../static/js/sidebar.js"></script>
    <script defer src="../static/js/settings/colors.js"></script>
    <script defer src="../static/js/settings/logo.js"></script>
    <script defer src="../static/js/settings/general.js"></script>
    <script defer src="../static/js/settings/palleteGenerator.js"></script>
</head>

<body>
    <?php include 'sidebar.php' ?>
    <section class="home container-fluid">
        <div class="row w-100 me-0">
            <div class="col w-100">
                <?php include 'header.php'; ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors"
                            type="button" role="tab" aria-controls="colors" aria-selected="false">Color
                            Pallete</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                            type="button" role="tab" aria-controls="general" aria-selected="false">general</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#logo"
                            type="button" role="tab" aria-controls="logo" aria-selected="false">logo</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- colors tab pane -->
                    <div class="tab-pane fade show active" id="colors" role="tabpanel" aria-labelledby="colors-tab">
                        <div class="row py-3">
                            <div class="col fs-6 fw-bold">
                                Current Color Pallete
                            </div>
                        </div>
                        <div class="row py-3 row-cols-1 mx-3 d-flex w-100 gap-3">
                            <div class="col">
                                <button type="button" class="hpm-button" style="max-width: 150px;"
                                    id="generate-pallete-button" data-toggle="modal"
                                    data-target="#palleteGenerator">Generate
                                    Pallete</button>
                            </div>
                        </div>
                        <div class="row py-3 mx-3 d-flex w-100 gap-3">
                            <div class="col d-flex gap-5 flex-wrap" id="colorsContainer">

                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">

                        <div class="row py-3">
                            <div class="col fs-6 fw-bold">
                                General Informations
                            </div>
                        </div>
                        <div class="row row-cols-1 errors">
                            <div class="col">

                            </div>
                        </div>
                        <div class="row py-3 mx-3 d-flex w-100 gap-3">
                            <div class="row row-cols-3">
                                <div class="form-group col-md-6">
                                    <label for="name">name <span class="star">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="company name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">email <span class="star">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="row row-cols-1">
                                <div class="col">
                                    <label for="address1">Address</label>
                                    <input type="text" class="form-control" id="address1" name="address1"
                                        placeholder="1234 Main St">
                                </div>
                            </div>
                            <div class="row row-cols-1">
                                <div class="col">
                                    <label for="address2">Address 2</label>
                                    <input type="city" class="form-control" id="address2" name="address2"
                                        placeholder="Apartment, studio, or floor">
                                </div>
                            </div>
                            <div class="row row-cols-3">
                                <div class="form-group col-md-4">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="zip">Code Postal</label>
                                    <input type="text" class="form-control" id="zip" name="zip">
                                </div>
                            </div>
                            <div class="row row-cols-3">
                                <div class="form-group col-md-4">
                                    <label for="telephone">Tel </label>
                                    <input type="text" class="form-control" id="telephone" name="telephone">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fax">Fax</label>
                                    <input type="text" class="form-control" id="fax" name="fax">
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile">
                                </div>
                            </div>
                            <div class="row row-cols-1 justify-content-end mt-3">
                                <div class="col">
                                    <button type="button" class="hpm-button" style="max-width: 150px;"
                                        id="update-button-general">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                        <div class="row py-3">
                            <div class="col fs-6 fw-bold">
                                Company Logo
                            </div>
                        </div>
                        <div class="row py-3 mx-3 d-flex w-100 gap-3">
                            <div class="drag-drop my-2 mx-5" style="position: relative;">

                                <i id="show-logo" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    class="fas fa-eye hpm-button-secondary"></i>
                                <div class="box">
                                    <img id="company-logo" src="../static/images/<?= $_SESSION['logo'] ?>"
                                        alt="Preview">

                                </div>
                                <i class="fas fa-gear" id="editLogo" data-bs-toggle="modal"
                                    data-bs-target="#updateLogo"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


    </section>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog" style="max-width: 550px !important;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Edit Color</h3>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <label for="colorPicker" class="form-label">Color picker</label>
                    <input type="color" class="form-control form-control-color" id="colorPicker" name="colorPicker"
                        title="Choose your color">
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit-color-button" class="hpm-button disabled">Edit
                        Color</button>
                </div>
            </div>
        </div>
    </div>


    <!-- the pallete generator modal -->
    <div id="palleteGenerator" class="modal fade">
        <div class="modal-dialog" style="max-width: 750px !important;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Pallete Generator</h3>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <ul class="container palleteGenerator"></ul>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-pallete-button" class="hpm-button">Save
                        Color</button>
                    <button class="refresh-btn hpm-button">Refresh Palette</button>
                </div>
            </div>
        </div>
    </div>

    <!-- update the logo -->
    <div id="updateLogo" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Update Logo</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content add">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="general">
                            <div class="form d-flex flex-column gap-2">
                                <label for="drag-box mt-2">Logo image</label>
                                <div class="drag-drop mx-auto" id="drag-box">
                                    <div class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        <span class="drop-text">Drop down here or select a file</span>
                                        <img id="previewImage" src="#" alt="Preview" style="display: none;">
                                        <span class="delete-icon" onclick="deleteImage(event)">&#x2715;</span>
                                    </div>
                                    <input type="file" name="image" id="fileInput" style="display: none;"
                                        onchange="handleFileSelect(event)">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="update-logo-button" class="hpm-button">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- show company logo modal -->
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="imageModalLabel" src="../static/images/<?= $_SESSION['logo'] ?>" class="img-fluid"
                        alt="Large Image">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
