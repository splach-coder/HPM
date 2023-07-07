$(document).ready(function () {
  var formData = new FormData();

  //navigate into tabs
  $("#myModal .nav .nav-link").click(function (e) {
    e.preventDefault();
    $(this).tab("show");
  });

  //search for products
  $("#query").on("input", function () {
    const query = $(this).val();

    $.ajax({
      url: "../controller/searchProductsJSON.php",
      method: "GET",
      dataType: "json",
      data: { query },
      success: function (response) {
        var data = response;
        $("select[id='produits'] option:not([value='none'])").remove();

        $.each(data, function (item) {
          var res = response[item];
          var option = $("<option>").val(res.id).text(res.name);
          $("select[id='produits']").append(option);
        });
      },
      errors: (err) => {
        console.log("errors: " + err);
      },
    });
  });

  //search for clients
  $("#queryC").on("input", function () {
    const query = $(this).val();

    $.ajax({
      url: "../controller/searchClientsJSON.php",
      method: "GET",
      dataType: "json",
      data: { query },
      success: function (response) {
        var data = response;
        $("select[id='clientsS'] option:not([value='none'])").remove();

        $.each(data, function (item) {
          var res = response[item];
          var option = $("<option>").val(res.id).text(res.business_name);
          $("select[id='clientsS']").append(option);
        });
      },
      errors: (err) => {
        console.log("errors: " + err);
      },
    });
  });

  /* handle the click of the produit */
  $("select[id='produits']").on("change", (e) => {
    const query = $(e.target).val();

    if (query != "none" && query != "")
      $.ajax({
        url: "../controller/searchProductsJSON.php",
        method: "GET",
        dataType: "json",
        data: { query },
        success: function (response) {
          console.log(response);
          var data = response[0];

          fillProductFields(
            data.id,
            data.name,
            data.purchase_price,
            data.selling_price,
            data.stock,
            data.gross_margin,
            data.gorss_margin_100
          );
        },
        errors: (err) => {
          console.log("errors: " + err);
        },
      });
  });

  /* handle the click of the produit */
  $("select[id='clientsS']").on("change", (e) => {
    const query = $(e.target).val();

    if (query != "none" && query != "")
      $.ajax({
        url: "../controller/searchClientsJSON.php",
        method: "GET",
        dataType: "json",
        data: { query },
        success: function (response) {
          var data = response[0];

          $("#clientNom").val(data.business_name);
          $("#clientID").val(data.id);
        },
        errors: (err) => {
          console.log("errors: " + err);
        },
      });
  });

  //when the modal hides
  $("#myModal").on("hidden.bs.modal", function () {
    // Code to execute when the modal has finished being hidden
    // You can place your logic here
    resetForm(formData);
  });

  //add the purchasse click event
  $("#add-sale-button").click(function () {
    if (!validateInputs()) return;
    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
    $(this).addClass("disabled");

    let inputs = ["produitID", "clientID", "prixActuel", "stockActuel", "note"];

    // Get the form element
    const form = $(".tab-content.add");

    // Append all form fields to the FormData object
    form.find(":input:not([type='file'])").each(function () {
      const field = $(this);

      if (inputs.includes(field.attr("name")))
        // Append other inputs, selects, and textareas to the FormData object
        formData.append(field.attr("name"), field.val());
    });

    //Make the AJAX POST request
    $.ajax({
      url: "../controller/addSale.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle the success response
        console.log(response);
        if (response == "Success: Sale Affectted successfully.") {
          resetForm(formData);
          $("#myModal").modal("hide");
          table.ajax.reload();
        } else {
          formMessage(response, "danger", $("#myModal .modal-body"));
          resetForm(formData);
        }
      },
    });
  });

  $("#prixActuel").one("input", function () {
    var prixAchat = $("#prix").val();
    var prixActuel = $("#prixActuel").val();
    let res = prixActuel / prixAchat;

    $("#stockActuel").val(Math.floor(res));
  });
});

/* functions */
function fillProductFields(
  id,
  name,
  prix,
  vente,
  stock,
  gross_margin,
  gross_margin_100
) {
  // Fill input fields
  $("#produitID").val(id);
  $("#produitNom").val(name);
  $("#prix").val(prix);
  $("#prixvente").val(vente);
  $("#stockI").val(stock);
  $("#margeht").val(gross_margin);
  $("#margeht100").val(gross_margin_100);
}

function resetForm(formData) {
  // Empty all inputs
  $("#myModal input[type='text']").val("");
  $("#myModal input[type='number']").val("");
  $("#myModal textarea").val("");

  $("#add-sale-button").html("Add Supplier");
  $("#add-sale-button").removeClass("disabled");

  $("select[id='produits'] option:not([value='none'])").remove();
  $("select[id='clientsS'] option:not([value='none'])").remove();

  clearFormData(formData);
}

function clearFormData() {
  formData = new FormData();
}

function validateInputs() {
  // Get the values of the required inputs
  const prix = $("#prixActuel").val().trim();
  const stock = $("#stockActuel").val().trim();

  // Check if any of the required inputs are empty or the gender is "none"
  if (prix === "" || stock === "" || prix == "0" || stock === "0") {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#myModal .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}
