var formData = new FormData();
var hasImage = false;

$("#updateLogo").on("hidden.bs.modal", function () {
  formData = new FormData();

  const previewImage = document.getElementById("previewImage");
  previewImage.src = "#";
  previewImage.style.display = "none";
  $(".delete-icon").css("display", "none");
  $(".drop-text").css("display", "block");
});

$(".box").click(function (e) {
  $("#fileInput").click();
});

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
    hasImage = true;
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
  formData = new FormData();
}

$("#update-logo-button").click(function () {
  if (!hasImage) {
    formMessage("Please set an image.", "danger", $("#updateLogo .modal-body"));
    return;
  }

  $(this).html('<i class="fas fa-spinner fa-spin"></i>');
  $(this).addClass("disabled");

  $.ajax({
    url: "../controller/updateLogo.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Logo updated successfully.") {
        location.reload();
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});
