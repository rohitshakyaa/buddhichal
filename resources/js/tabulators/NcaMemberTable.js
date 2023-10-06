import { Table, actionComponent } from "./TableConfig";


const columns = [
  {
    title: "Action",
    formatter: actionFormatter,
    resizable: false,
    width: 130,
  },
  {
    title: "Position",
    field: "position",
    width: 95,
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
    formatter: ncalinkFormatter
  }
];
let table1 = Table({ tableId: "nca-member-table", apiUrl: "/api/web/admin/ncas", columns })

function ncalinkFormatter(cell) {
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

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/ncas/${id}/edit`,
    delete: true,
    delRoute: `/admin/ncas/${id}/destroy`,
  });
}
