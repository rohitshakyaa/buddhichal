import { Table, actionComponent, linkFormatter } from "./TableConfig";


const table1 = Table({
  tableId: "champion-table", apiUrl: "/api/web/admin/champions", columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Name",
      field: "name",
      minWidth: 200,
    },
    {
      title: "From",
      field: "from_address",
      minWidth: 150,
    },
    {
      title: "game_at",
      field: "game_at_address",
      minWidth: 150,
    },
    {
      title: "Gender",
      field: "gender",
      formatter: (cell) => cell.getValue() === "M" ? "Male" : "Female",
      minWidth: 150,
    },
    {
      title: "Year in BS",
      field: "year",
      formatter: (cell) => cell.getValue(),
      minWidth: 150,
    },
    {
      title: "Image",
      field: "image",
      formatter: linkFormatter,
      minWidth: 150,
    },
  ]
})


function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/champions/${id}/edit`,
    delete: true,
    delRoute: `/admin/champions/${id}/destroy`,
  });
}