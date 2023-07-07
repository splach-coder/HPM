var table = $("#salesTable").DataTable({
  ajax: {
    url: "../controller/getSalesJSON.php",
    dataSrc: "",
    responsive: true,
  },
  columns: [
    { data: "id" },
    { data: "produit" },
    { data: "client" },
    { data: "quantity" },
    { data: "price" },
    { data: "date" },
  ],
  dom: "Bfrtip",
  buttons: ["print", "csv", "colvis"],
});
