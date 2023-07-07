var table = $("#purchasesTable").DataTable({
  ajax: {
    url: "../controller/getPurchasesJSON.php",
    dataSrc: "",
    responsive: true,
  },
  columns: [
    { data: "id" },
    { data: "produit" },
    { data: "supplier" },
    { data: "quantity" },
    { data: "price" },
    { data: "date" },
  ],
  dom: "Bfrtip",
  buttons: ["print", "csv", "colvis"],
});
