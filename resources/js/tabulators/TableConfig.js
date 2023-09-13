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

export function imageFormatter(cell) {
  if (cell.getValue()) {
    const imgTag = document.createElement('a');
    imgTag.href = cell.getValue();
    imgTag.target = "_blank";
    imgTag.innerHTML = cell.getValue();
    imgTag.setAttribute("class", "underline text-blue-500 hover:text-blue-600 visited:text-blue-400")
    return imgTag;
  }
  return "";
}