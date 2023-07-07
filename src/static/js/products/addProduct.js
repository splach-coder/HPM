/**************************variables **********************/
var formData = new FormData();

/*********************** the supppliers section ***************/
$("input#suppliers").on("input", function () {
  let input = $(this).val();

  //populate the suppliers modal
  $.ajax({
    url: "../controller/searchSuppliersJSON.php",
    method: "GET",
    data: { query: input },
    // dataType: "json",
    success: function (response) {
      $("#suppliers_list option:not([value='none'])").remove();

      $.each(response, function (item) {
        var res = response[item];
        var option = $("<option>")
          .val(res.id)
          .text(res.nom + " " + res.prenom + "     |   " + res.business_name);
        $("select[id='suppliers_list']").append(option);
      });
    },
    error: function (xhr, status, error) {
      console.log("AJAX request error:", error);
    },
  });
});

/********************the price calculations******************************************/
$("#prix").on("input", calculateMargins);
$("#margeht100").on("input", calculateMargins);
$("#prixvente").on("input", calculateMarginsFromPrixVente);

function calculateMargins() {
  const prix = parseFloat($("#prix").val());
  const margeHTPercent = parseFloat($("#margeht100").val());

  if (!isNaN(prix) && !isNaN(margeHTPercent)) {
    const margeHT = prix * (margeHTPercent / 100);
    const prixVenteTTC = prix + margeHT;

    $("#margeht").val(margeHT.toFixed(2));
    $("#prixvente").val(prixVenteTTC.toFixed(2));
  }
}

function calculateMarginsFromPrixVente() {
  const prixVente = parseFloat($("#prixvente").val());
  const prix = parseFloat($("#prix").val());

  if (!isNaN(prixVente) && !isNaN(prix) && prix !== 0) {
    const margeHT = prixVente - prix;
    const margeHTPercent = (margeHT / prix) * 100;

    $("#margeht").val(margeHT.toFixed(2));
    $("#margeht100").val(margeHTPercent.toFixed(2));
  }
}

/***********************the picture handless ***********************/

$(".box.add").click(function (e) {
  $("#fileInput").click();
});

function allowDrop(event) {
  event.preventDefault();
}

function drop(event) {
  event.preventDefault();
  const files = event.dataTransfer.files;
  handleFile(files);
}

function handleFileSelect(event) {
  const files = event.target.files;
  handleFile(files);
}

function handleFile(files) {
  Array.from(files).forEach((file) => {
    const reader = new FileReader(); // Create a new FileReader for each file

    reader.onload = function (event) {
      const previewImage = $(".product-images");
      previewImage.prepend(
        `
        <div class="product-image">
          <img src="${event.target.result}" data-image-name="${file.name}" alt="product image">
          <span class="delete-icon" onclick="deleteImage(event)">&#x2715;</span>
        </div>
        `
      );
    };

    if (file) {
      reader.readAsDataURL(file);
      formData.append("images[]", file); // Append file to the 'images' array in the formData
    }
  });

  $(".product-images").animate(
    { scrollTop: $(".product-images")[0].scrollHeight },
    "slow"
  );
}

function deleteImage(event) {
  const imageContainer = $(event.target).parent(".product-image");
  imageContainer.remove();

  const imageSrc = imageContainer.find("img").attr("data-image-name");

  // Retrieve the files from the FormData object
  let files = formData.getAll("images[]");

  // Find the index of the file to remove
  let index = -1;
  for (let i = 0; i < files.length; i++) {
    if (files[i].name === imageSrc) {
      index = i;
      break;
    }
  }

  // If the file was found, remove it from the array and FormData
  if (index > -1) {
    files.splice(index, 1);
    formData.delete("images[]");
    for (let i = 0; i < files.length; i++) {
      formData.append("images[]", files[i]);
    }
  }
}

function clearFormData() {
  formData = new FormData();
}

function validateInputs() {
  // Get the values of the required inputs
  const produitNom = $("#produitNom").val().trim();
  const prix = $("#prix").val().trim();
  const margeht = $("#margeht").val().trim();
  const margeht100 = $("#margeht100").val().trim();
  const prixvente = $("#prixvente").val().trim();
  const category = $("#category").val().trim();
  const unit = $("#unit").val().trim();
  const activite = $("#activite").val();
  const suppliers = $("select[id='suppliers_list'").val();

  // Check if any of the required inputs are empty or the gender is "none"
  if (
    produitNom === "" ||
    prix === "" ||
    margeht === "" ||
    margeht100 === "" ||
    prixvente === "" ||
    category === "none" ||
    unit === "none" ||
    activite === "none" ||
    suppliers === "none"
  ) {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#myModal .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

/**********************add product*********************/
$("#add-product-button").click(function () {
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

  //Make the AJAX POST request
  $.ajax({
    url: "../controller/addProduct.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Product added successfully.") {
        resetForm();
        $("#myModal").modal("hide");
        table.ajax.reload();
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});

$("#myModal").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  resetForm();
});

function resetForm() {
  // Empty all inputs
  $("input[type='text']").val("");

  $("textarea").val("");

  $(".product-images").find(".product-image").remove();

  // Select the first option in the select element
  $("select").prop("selectedIndex", 0);

  $("#add-product-button").html("Add Product");
  $("#add-product-button").removeClass("disabled");

  $("select[id='suppliers_list'").empty();

  clearFormData();
}
