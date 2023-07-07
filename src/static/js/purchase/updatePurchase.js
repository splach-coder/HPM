$(document).ready(function () {
  var formData2 = new FormData();
  var id;

  AttachChange();

  //navigate into tabs
  $("#showPurchase .nav .nav-link").click(function (e) {
    e.preventDefault();
    $(this).tab("show");
  });

  $("#purchasesTable").on("click", "tbody tr", function () {
    // Get the clicked row data
    const rowData = table.row(this).data();

    // Get the value of the 'id' property
    id = rowData.id;

    $.ajax({
      url: "../controller/getPurchase.php",
      method: "GET",
      dataType: "json",
      data: { id },
      success: function (response) {
        var data = response[0];
        fillModalFields2(
          data.id,
          data.name,
          data.supplier,
          data.price,
          data.quantity,
          data.Note,
          data.date
        );
      },
      errors: (err) => {
        console.log("errors: " + err);
      },
    });

    // Display the id in an alert
    $("#showPurchase").modal("show");
  });

  $("#showPurchase").on("hidden.bs.modal", function () {
    // Code to execute when the modal has finished being hidden
    // You can place your logic here
    handleChange();
    AttachChange();
    $("#update-purchase-button").addClass("disabled");
  });

  //add the purchasse click event
  $("#update-purchase-button").click(function () {
    if (!validateInputs2()) return;
    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
    $(this).addClass("disabled");

    let inputs = ["Show-date"];

    // Get the form element
    const form = $(".tab-content.show");

    formData2.append("id", id);

    // Append all form fields to the FormData object
    form.find(":input:not([type='file'])").each(function () {
      const field = $(this);

      if (!inputs.includes(field.attr("name")))
        // Append other inputs, selects, and textareas to the FormData object
        formData2.append(field.attr("name"), field.val());
    });

    //Make the AJAX POST request
    $.ajax({
      url: "../controller/updatePurchase.php",
      method: "POST",
      data: formData2,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle the success response
        console.log(response);
        if (response == "Success: Purchase updated successfully.") {
          resetForm2(formData2);
          $("#showPurchase").modal("hide");
          table.ajax.reload();
        } else {
          formMessage(response, "danger", $("#showPurchase .modal-body"));
          resetForm2(formData2);
        }
      },
    });
  });
});

/* functions */
function fillModalFields2(id, name, supplier, prix, stock, note, date) {
  // Fill input fields
  $("#Show-purchaseID").val(id);
  $("#Show-produitNom").val(name);
  $("#Show-supplier").val(supplier);
  $("#Show-prix").val(prix);
  $("#Show-stock").val(stock);
  $("#Show-note").text(note);
  $("#Show-date").val(date);
}

function resetForm2(formData2) {
  // Empty all inputs
  $("#showPurchase input[type='text']").val("");
  $("#showPurchase input[type='number']").val("");
  $("#showPurchase textarea").val("");

  $("#update-purchase-button").html("Add Supplier");
  $("#update-purchase-button").removeClass("disabled");

  $("select[id='produits'] option:not([value='none'])").remove();

  clearFormData(formData2);
}

function AttachChange() {
  // Attach change event listeners to each input element
  $("#showPurchase input").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showPurchase textarea").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showPurchase select").on("change", handleChange);
}

// Function to handle the change event
function handleChange() {
  $("#update-purchase-button").toggleClass("disabled");

  // Attach change event listeners to each input element
  $("#showPurchase input").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showPurchase textarea").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showPurchase select").off("change", handleChange);
}

function clearFormData2() {
  formData2 = new FormData();
}

function validateInputs2() {
  // Get the values of the required inputs
  const prix = $("#Show-prix").val().trim();
  const stock = $("#Show-stock").val().trim();

  // Check if any of the required inputs are empty or the gender is "none"
  if (prix === "" || stock === "" || prix == "0" || stock === "0") {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#showPurchase .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}
