import { Table, actionComponent } from "./TableConfig";

const table1 = Table({
  tableId: "book-type-table",
  apiUrl: "/api/web/admin/books/types",
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Key",
      field: "key",
      minWidth: 150,
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
  return actionComponent({
    edit: true,
    editRoute: `/admin/books/types/${id}/edit`,
    delete: true,
    delRoute: `/admin/books/types/${id}/destroy`,
  });
}
