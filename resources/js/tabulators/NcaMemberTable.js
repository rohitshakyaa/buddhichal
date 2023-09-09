import { TabulatorFull as Tabulator } from "tabulator-tables";

if (document.getElementById("nca-member-table")) {
  let table = new Tabulator("#nca-member-table", {
    ajaxURL: "/api/web/admin/ncas",
    ajaxConfig: "GET",
    layout: "fitColumns",
    placeholder: "No data to view",
    columns: [
      {
        title: "Position",
        field: "position",
        minWidth: 95,
      },
      {
        title: "Name",
        field: "name",
        minWidth: 150,
      },
      {
        title: "Phone Number",
        field: "phone_number",
        minWidth: 140,
      },
      {
        title: "Post",
        field: "post",
        minWidth: 120,
      },
      {
        title: "Email",
        field: "email",
        minWidth: 140,
      },
      {
        title: "Image",
        field: "image",
        minWidth: 120,
        formatter: ncaImageFormatter
      }
    ],
  });
}

function ncaImageFormatter(cell) {
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
