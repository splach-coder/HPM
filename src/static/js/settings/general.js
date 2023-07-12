$(document).ready(function () {
  //get the company data
  $.ajax({
    url: "../controller/getCompanyJSON.php",
    method: "GET",
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response

      var data = response[0];

      console.log(data);
      fillData(data);
    },
  });

  $("#update-button-general").click(function () {
    if (!validateInputs()) return;
    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
    $(this).addClass("disabled");

    // Get the form element
    const form = $(".tab-pane#general");

    // Append all form fields to the FormData object
    form.find(":input:not([type='file'])").each(function () {
      const field = $(this);

      // Append other inputs, selects, and textareas to the FormData object
      formData.append(field.attr("name"), field.val());
    });

    //Make the AJAX POST request
    $.ajax({
      url: "../controller/updateCompany.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle the success response
        console.log(response);
        if (response == "Success: Company Infos updated successfully.") {
          formMessage(response, "success", $(".row.errors .col"));
          $("#update-button-general").html("Update");
          $("#update-button-general").removeClass("disabled");
        } else {
          formMessage(response, "danger", $(".row.errors .col"));
        }
      },
    });
  });
});

function validateInputs() {
  // Get the values of the required inputs
  const businessName = $("#name").val().trim();
  const email = $("#email").val().trim();

  // Check if any of the required inputs are empty or the gender is "none"
  if (businessName === "" || email === "") {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $(".row.errors .col"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

function fillData(data) {
  $("#name").val(data.business_name);
  $("#email").val(data.email);
  $("#address1").val(data.address_line1);
  $("#address2").val(data.address_line2);
  $("#city").val(data.city);
  $("#zip").val(data.postal_code);
  $("#country").val(data.country);
  $("#telephone").val(data.telephone);
  $("#fax").val(data.fax);
  $("#mobile").val(data.mobile);
}
