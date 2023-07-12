var table = $("#productsTable").DataTable({
  ajax: {
    url: "../controller/getProductsJSON.php",
    dataSrc: "",
  },
  columns: [
    { data: "id" },
    { data: "name" },
    { data: "purchase_price" },
    { data: "gross_margin" },
    { data: "stock_status" },
    { data: "unit" },
    { data: "family" },
  ],
  dom: "Bfrtip",
  buttons: ["print", "csv", "colvis"],
});

console.log($(".unitSelect"));
console.log($("select[name='category']"));
console.log($("select[name='activite']"));

//get the number of data
var dataLength = 0;

table.on("draw", function () {
  dataLength = table.rows().count();
  $(".table-data-rows").html(" | " + dataLength + " products right now");
});

table.draw();

$("#myModal .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

//populate the activity modal
$.ajax({
  url: "../controller/getActivityJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select#Show-activite").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

//populate the activity modal
$.ajax({
  url: "../controller/getActivityJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select[id='activite']").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

//populate the unit modal
$.ajax({
  url: "../controller/getUnitsJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select#Show-unit").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

//populate the unit modal
$.ajax({
  url: "../controller/getUnitsJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select[id='unit']").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

//populate the family modal
$.ajax({
  url: "../controller/getFamilyJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("#Show-category").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

//populate the family modal
$.ajax({
  url: "../controller/getFamilyJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    console.log(response);
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select[id='category']").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});
