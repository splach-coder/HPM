//************************** this for add supplier ****************************/
var formData = new FormData();

//show the files in the local machine
$(".box.add").click(function () {
  $("#fileInput").click();
});

$("#myModal .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

$("#myModal").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  // You can place your logic here
  resetForm();
});

$("#add-supplier-button").on("click", function () {
  if (!validateInputs()) return;
  $(this).html('<i class="fas fa-spinner fa-spin"></i>');
  $(this).addClass("disabled");

  // Get the form element
  const form = $(".tab-content.add");

  // Append all form fields to the FormData object
  form.find(":input:not([type='file'])").each(function () {
    const field = $(this);

    // Append other inputs, selects, and textareas to the FormData object
    formData.append(field.attr("name"), field.val());
  });

  for (let entry of formData.entries()) {
    console.log(entry);
  }

  //Make the AJAX POST request
  $.ajax({
    url: "../controller/addSupplier.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Supplier added successfully.") {
        resetForm();
        $("#myModal").modal("hide");
        table.ajax.reload();
      } else {
        formMessage(response, "danger", $("#myModal .modal-body"));
        resetForm();
      }
    },
  });
});

//functions
function allowDrop(event) {
  event.preventDefault();
}

function drop(event) {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  handleFile(file);
}

function handleFileSelect(event) {
  const file = event.target.files[0];
  handleFile(file);
}

function handleFile(file) {
  const reader = new FileReader();
  reader.onload = function (event) {
    const previewImage = document.getElementById("previewImage");
    previewImage.src = event.target.result;
    previewImage.style.display = "block";
    $(".delete-icon").css("display", "flex");
  };

  if (file) {
    $(".drop-text").css("display", "none");
    reader.readAsDataURL(file);
  } else {
    $(".drop-text").css("display", "block");
    $("#previewImage").attr("src", "").hide();
    $(".delete-icon").css("display", "none");
  }

  formData.append("image", file);
}

function deleteImage(event) {
  event.stopPropagation();
  const previewImage = document.getElementById("previewImage");
  previewImage.src = "#";
  previewImage.style.display = "none";
  $(".delete-icon").css("display", "none");
  $(".drop-text").css("display", "block");
  formData.delete("image");
}

function validateInputs() {
  // Get the values of the required inputs
  const businessName = $("#businessName").val().trim();
  const lastName = $("#lastName").val().trim();
  const firstName = $("#firstName").val().trim();
  const gender = $("#gender").val();

  // Check if any of the required inputs are empty or the gender is "none"
  if (
    businessName === "" ||
    lastName === "" ||
    firstName === "" ||
    gender === "none"
  ) {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#myModal .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

function resetForm() {
  // Empty all inputs
  $("input[type='text']").val("");

  $("input#country").val("Maroc");

  // Remove the image source and hide it
  $("#previewImage").attr("src", "").hide();

  // Set display of .drop-text to "block"
  $(".drop-text").css("display", "block");

  // Select the first option in the select element
  $("select[id='gender']").prop("selectedIndex", 0);

  // Hide the delete icon
  $(".delete-icon").css("display", "none");

  $("#add-supplier-button").html("Add Supplier");
  $("#add-supplier-button").removeClass("disabled");

  clearFormData(formData);
}

function clearFormData() {
  formData = new FormData();
}
