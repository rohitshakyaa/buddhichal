import { Table, actionComponent } from "./TableConfig";

const table1 = Table({
  tableId: "book-type-table",
  apiUrl: "/api/web/admin/books/types",
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 200,
    },
    {
      title: "Title",
      field: "title",
      minWidth: 200,
    },
  ],
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  const parent = document.createElement("div");
  parent.setAttribute("class", "flex gap-2");
  parent.appendChild(
    actionComponent({
      edit: true,
      editRoute: `/admin/books/types/${id}/edit`,
      delete: true,
      delRoute: `/admin/books/types/${id}/destroy`,
    }),
  );
  const btn = document.createElement("a");
  btn.setAttribute("class", "button button-yellow button-xs");
  btn.innerText = "View Books";
  btn.href = `/admin/books?type_id=${id}`;
  parent.appendChild(btn);
  return parent;
}
