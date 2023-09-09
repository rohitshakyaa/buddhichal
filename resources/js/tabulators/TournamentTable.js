import { TabulatorFull as Tabulator } from "tabulator-tables";

if (document.getElementById("tournament-table")) {
  let table = new Tabulator("#tournament-table", {
    ajaxURL: "/api/web/tournaments",
    ajaxConfig: "GET",
    layout: "fitColumns",
    placeholder: "No data to view",
    columns: [
      {
        title: "Title",
        field: "title",
        minWidth: 200,
      },
      {
        title: "Contact Number",
        field: "number",
        minWidth: 150,
      },
      {
        title: "Start Date",
        field: "start_date",
        minWidth: 120,
      },
      {
        title: "End Date",
        field: "end_date",
        minWidth: 120,
      },
      {
        title: "Total Prize (Rs.)",
        field: "total_prize",
        minWidth: 140,
        hozAlign: "right"
      },
      {
        title: "Register",
        field: "register",
        formatter: (cell) => cell.getValue() ? "Yes" : "No",
        minWidth: 100,
      },
      {
        title: "Description",
        field: "description",
        formatter: "textarea",
        minWidth: 130,
      },
    ],
  });
}
