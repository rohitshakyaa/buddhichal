import { Table, actionComponent, linkFormatter } from "./TableConfig";


const table1 = Table({
  tableId: "banner-table", apiUrl: "/api/web/admin/banners", columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Caption",
      field: "caption",
      minWidth: 200,
    },
    {
      title: "Link",
      field: "link",
      formatter: linkFormatter,
      minWidth: 150,
    },
    {
      title: "Image",
      field: "image",
      minWidth: 120,
      formatter: linkFormatter,
    },
  ]
})


function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/banners/${id}/edit`,
    delete: true,
    delRoute: `/admin/banners/${id}/destroy`,
  });
}