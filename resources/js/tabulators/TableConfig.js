import { TabulatorFull as Tabulator } from "tabulator-tables";

export function Table({ tableId, apiUrl, columns }) {
  if (document.getElementById(tableId)) {
    let table = new Tabulator(`#${tableId}`, {
      ajaxURL: apiUrl,
      ajaxConfig: "GET",
      layout: "fitColumns",
      placeholder: "No data to view",
      columns: columns,
      ajaxResponse: function (url, params, response) {
        if (response?.status === "1") {
          return response.response;
        }
      },
    });
    return table;
  }
}