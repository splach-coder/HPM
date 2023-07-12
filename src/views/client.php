<?php require_once '../auth/ensureAuthentication.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HPM | Clients</title>
    <link rel="stylesheet" type="text/css" href="../controller/Changeablepallete.css.php">
    <?php include 'links.php' ?>

    <!-- css and js resourcess -->
    <!-- ##### CSS ######  -->
    <link rel="stylesheet" href="../static/css/table.css">
    <link rel="stylesheet" href="../static/css/client.css">

    <!-- ##### JS ######  -->
    <script defer src=" ../static/js/sidebar.js">
    </script>
    <script defer src="../static/js/client.js"></script>
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
                            <span> Clients </span> <span class="table-data-rows">| 100 clients right now</span>
                        </div>
                        <div class="buttons">
                            <button type="button" class="hpm-button" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-plus"></i>
                                add Client
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row me-0">
                    <div class="col pb-5">
                        <table id="clientsTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Raison Social </th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Civilité</th>
                                    <th>Email</th>
                                    <th>Tel</th>
                                </tr>
                            </thead>
                            <tbo-dy>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>

    <!-- add client Modal -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Clients</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contacts">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#infos">Infos</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="general">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="businessName">Raison Social </label>
                                    <input type="text" id="businessName" class="p-1" name="raisonSocial" placeholder="Raison Social">
                                </div>
                                <div class="form-group d-flex flex-column ">
                                    <label for="lastName">Nom </label>
                                    <input type="text" id="lastName" class="p-1" name="nom" placeholder="Nom">
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <label for="firstName">Prenom </label>
                                    <input type="text" id="firstName" class=" p-1" name="prenom" placeholder="Prénom">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="gender">Civilité </label>
                                    <select name="gender" id="gender" class="p-2">
                                        <!-- This option will be populated with data from an API -->

                                        <option value="none" selected=" selected">select gender</option>
                                    </select>
                                </div>

                                <label for="drag-box mt-2">Profile Photo </label>
                                <div class="drag-drop" id="drag-box">
                                    <div class="box add" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        <span class="drop-text">Drop down here or select a file</span>
                                        <img id="previewImage" src="#" alt="Preview" style="display: none;">
                                        <span class="delete-icon" onclick="deleteImage(event)">&#x2715;</span>
                                    </div>
                                    <input type="file" name="image" id="fileInput" style="display: none;" onchange="handleFileSelect(event)">
                                </div>
                            </div>

                        </div>

                        <!-- Contacts Tab -->
                        <div class="tab-pane fade" id="contacts">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="email">Email </label>
                                    <input type="email" id="email" class="p-1" name="email" placeholder="Email">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="phone">Tel </label>
                                    <input type="text" id="phone" class="p-1" name="phone" placeholder="Tel ">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="codePostal">Code Postal </label>
                                    <input type="text" id="codePostal" class="p-1" name="codePostal" placeholder="code postal">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="city">Ville </label>
                                    <input type="text" id="city" class="p-1" name="city" placeholder="Ville ">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="country">Pays </label>
                                    <input type="text" id="country" class="p-1" name="country" placeholder="Pays " value="Maroc">
                                </div>
                            </div>
                        </div>

                        <!-- Infos Tab -->
                        <div class="tab-pane fade" id="infos">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="adress1">Adress 1 </label>
                                    <textarea id="adress1" rows="5" cols="10" class="p-1" name="adress1">
                                       </textarea>
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <label for="adress2">Adress 2</label>
                                    <textarea id="adress2" rows="5" cols="10" class="p-1" name="adress2">
                                       </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add-client-button" class="hpm-button">Add Client</button>
                </div>
            </div>
        </div>
    </div>

    <!-- update or delete client modal -->
    <div id="showClient" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Client</h3>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- List in Modal Header -->
                <ul class="nav d-flex gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#data-general">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#data-contacts">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#data-infos">Infos</a>
                    </li>
                </ul>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="tab-content show">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="data-general">
                            <div class="form d-flex flex-column gap-2">
                                <label for="drag-box mt-2 mx-auto">Profile Photo </label>
                                <div class="drag-drop mx-auto" id="show-drag-box">
                                    <i id="show-image" data-bs-toggle="modal" class="fas fa-eye hpm-button-secondary" style="position: absolute;"></i>
                                    <div class="box show-box" ondrop="drop2(event)" ondragover="allowDrop(event)">
                                        <span class="show-drop-text">Drop down here or select a file</span>
                                        <img id="show-previewImage" src="#" alt="Preview" style="display: none;">
                                        <span class="delete-icon show" onclick="deleteImage2(event)">&#x2715;</span>
                                    </div>
                                    <input type="file" name="image" id="showFileInput" onchange="handleFileSelect2(event)" style="display: none;">
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <label for="show-businessName">Raison Social </label>
                                    <input type="text" id="show-businessName" class="p-1" name="raisonSocial" placeholder="Raison Social">
                                </div>
                                <div class="form-group d-flex flex-column ">
                                    <label for="show-lastName">Nom </label>
                                    <input type="text" id="show-lastName" class="p-1" name="nom" placeholder="Nom">
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <label for="show-firstName">Prenom </label>
                                    <input type="text" id="show-firstName" class=" p-1" name="prenom" placeholder="Prénom">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="show-gender">Civilité </label>
                                    <select name="gender" id="show-gender" class="p-2">
                                        <!-- This option will be populated with data from an API -->

                                        <option value="none" selected=" selected">select gender</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- Contacts Tab -->
                        <div class="tab-pane fade" id="data-contacts">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="show-email">Email </label>
                                    <input type="email" id="show-email" class="p-1" name="email" placeholder="Email">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="show-phone">Tel </label>
                                    <input type="text" id="show-phone" class="p-1" name="phone" placeholder="Tel ">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="show-codePostal">Code Postal </label>
                                    <input type="text" id="show-codePostal" class="p-1" name="codePostal" placeholder="code postal">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="show-city">Ville </label>
                                    <input type="text" id="show-city" class="p-1" name="city" placeholder="Ville ">
                                </div>

                                <div class="form-group d-flex flex-column">
                                    <label for="show-country">Pays </label>
                                    <input type="text" id="show-country" class="p-1" name="country">
                                </div>
                            </div>
                        </div>

                        <!-- Infos Tab -->
                        <div class="tab-pane fade" id="data-infos">
                            <div class="form d-flex flex-column gap-2">
                                <div class="form-group d-flex flex-column">
                                    <label for="show-adress1">Adress 1 </label>
                                    <textarea id="show-adress1" rows="5" cols="10" class="p-1" name="adress1">
                                       </textarea>
                                </div>
                                <div class="form-group d-flex flex-column">
                                    <label for="show-adress2">Adress 2</label>
                                    <textarea id="show-adress2" rows="5" cols="10" class="p-1" name="adress2">
                                       </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="hpm-button-secondary" id="delete-client-button" data-bs-dismiss="modal">Delete</button>
                    <button type="button" id="update-client-button" class="hpm-button disabled">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="imageModalLabel" src="#" class="img-fluid" alt="Large Image">
                </div>
            </div>
        </div>
    </div>

</body>

</html>