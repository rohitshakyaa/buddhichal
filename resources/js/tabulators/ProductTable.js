import { Table, actionComponent } from "./TableConfig";

const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");

const table1 = Table({
  tableId: "product-table",
  apiUrl: `/api/web/admin/products${id ? `?id=${id}` : ""}`,
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 200,
    },
    {
      title: "Priority",
      field: "priority",
      minWidth: 150,
    },
    {
      title: "Title",
      field: "title",
      minWidth: 150,
    },
    {
      title: "Price",
      field: "price",
      minWidth: 120,
    },
    {
      title: "Images",
      field: "images",
      formatter: imagesFormatter,
      minWidth: 280,
    },
  ],
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  const parent = document.createElement("parent");
  parent.setAttribute("class", "flex gap-2");
  parent.appendChild(
    actionComponent({
      edit: true,
      editRoute: `/admin/products/${id}/edit`,
      delete: true,
      delRoute: `/admin/products/${id}/destroy`,
    }),
  );
  const btn = document.createElement("a");
  btn.setAttribute("class", "button button-yellow button-xs");
  btn.innerText = "View Clients";
  btn.href = `/admin/products/clients?product_id=${id}`;
  parent.appendChild(btn);
  return parent;
}

function imagesFormatter(cell) {
  const images = cell.getValue();
  const container = document.createElement("div");
  container.setAttribute("class", "flex flex-col gap-1 text-ellipsis");
  images.forEach((image) => {
    const imgTag = document.createElement("a");
    imgTag.href = image.image_url;
    imgTag.target = "_blank";
    imgTag.innerHTML = image.image_path;
    imgTag.setAttribute(
      "class",
      "underline text-blue-500 hover:text-blue-600 visited:text-blue-400 text-ellipsis",
    );
    container.appendChild(imgTag);
  });
  return container;
}
