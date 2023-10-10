import { Table, actionComponent } from "./TableConfig";

const urlParams = new URLSearchParams(window.location.search);
const product_id = urlParams.get("product_id");

const table = Table({
  tableId: "product-client-table",
  apiUrl: `/api/web/admin/products/clients${product_id ? `?product_id=${product_id}` : ""}`,
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 100,
    },
    {
      title: "Product Name",
      field: "productName",
      formatter: productLinkFormatter,
      minWidth: 165,
    },
    {
      title: "Name",
      field: "name",
      minWidth: 120,
    },
    {
      title: "Phone Number",
      field: "phone_number",
      minWidth: 140,
    },
    {
      title: "Address",
      field: "address",
      minWidth: 120,
    },
  ],
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: false,
    delete: true,
    delRoute: `/admin/products/clients/${id}/destroy`,
  });
}

function productLinkFormatter(cell) {
  const { product_id = 0 } = cell.getData();
  if (cell.getValue()) {
    const imgTag = document.createElement("a");
    imgTag.href = `/admin/products?id=${product_id}`;
    imgTag.innerText = cell.getValue();
    imgTag.setAttribute("class", "underline text-blue-500 hover:text-blue-600 ");
    return imgTag;
  }
  return "";
}
