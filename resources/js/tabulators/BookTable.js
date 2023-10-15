import { Table, actionComponent, linkFormatter } from "./TableConfig";

const urlParams = new URLSearchParams(window.location.search);
const type_id = urlParams.get("type_id");

const table1 = Table({
  tableId: "chess-book-table",
  apiUrl: `/api/web/admin/books${type_id ? `?type_id=${type_id}` : ""}`,
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Name",
      field: "name",
      minWidth: 120,
    },
    {
      title: "Type",
      field: "type",
      formatter: bookTypeLinkFormatter,
      minWidth: 120,
    },
    {
      title: "Book File",
      field: "book_file",
      minWidth: 300,
      formatter: linkFormatter,
    },
    {
      title: "Image",
      field: "image",
      minWidth: 300,
      formatter: linkFormatter,
    },
  ],
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/books/${id}/edit`,
    delete: true,
    delRoute: `/admin/books/${id}/destroy`,
  });
}

function bookTypeLinkFormatter(cell) {
  const { book_type_id = 0 } = cell.getData();
  if (cell.getValue()) {
    const imgTag = document.createElement('a');
    imgTag.href = `/admin/books/types?id=${book_type_id}`;
    imgTag.innerText = cell.getValue();
    imgTag.setAttribute("class", "underline text-blue-500 hover:text-blue-600 ")
    return imgTag;
  }
  return "";
}