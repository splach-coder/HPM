$(document).ready(function () {
  var formData2 = new FormData();
  var id;

  AttachChange();

  //navigate into tabs
  $("#showSale .nav .nav-link").click(function (e) {
    e.preventDefault();
    $(this).tab("show");
  });

  $("#salesTable").on("click", "tbody tr", function () {
    // Get the clicked row data
    const rowData = table.row(this).data();

    // Get the value of the 'id' property
    id = rowData.id;
    
    $.ajax({
      url: "../controller/getSale.php",
      method: "GET",
      dataType: "json",
      data: { id },
      success: function (response) {
        var data = response[0];
      
        fillModalFields2(
          data.id,
          data.name,
          data.client,
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
    $("#showSale").modal("show");
  });

  $("#showSale").on("hidden.bs.modal", function () {
    // Code to execute when the modal has finished being hidden
    // You can place your logic here
    handleChange();
    AttachChange();
    $("#update-sale-button").addClass("disabled");
  });

  //add the purchasse click event
  $("#update-sale-button").click(function () {
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
      url: "../controller/updateSale.php",
      method: "POST",
      data: formData2,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle the success response
        console.log(response);
        if (response == "Success: Sale updated successfully.") {
          resetForm2(formData2);
          $("#showSale").modal("hide");
          table.ajax.reload();
        } else {
          formMessage(response, "danger", $("#showSale .modal-body"));
          resetForm2(formData2);
        }
      },
    });
  });
});

/* functions */
function fillModalFields2(id, name, client, prix, stock, note, date) {
  // Fill input fields
  $("#Show-saleID").val(id);
  $("#Show-produitNom").val(name);
  $("#Show-client").val(client);
  $("#Show-prix").val(prix);
  $("#Show-stock").val(stock);
  $("#Show-note").text(note);
  $("#Show-date").val(date);
}

function resetForm2(formData2) {
  // Empty all inputs
  $("#showSale input[type='text']").val("");
  $("#showSale input[type='number']").val("");
  $("#showSale textarea").val("");

  $("#update-purchase-button").html("Add Supplier");
  $("#update-purchase-button").removeClass("disabled");

  $("select[id='produits'] option:not([value='none'])").remove();

  clearFormData(formData2);
}

function AttachChange() {
  // Attach change event listeners to each input element
  $("#showSale input").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSale textarea").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSale select").on("change", handleChange);
}

// Function to handle the change event
function handleChange() {
  $("#update-sale-button").toggleClass("disabled");

  // Attach change event listeners to each input element
  $("#showSale input").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSale textarea").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSale select").off("change", handleChange);
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
    formMessage(message, "danger", $("#showSale .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}
