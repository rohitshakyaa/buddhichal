import { Table, actionComponent } from "./TableConfig";


const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

const table1 = Table({
  tableId: "tournament-table", apiUrl: `/api/web/admin/tournaments${id ? `?id=${id}` : ""}`, columns: [

    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 200,
    },
    {
      title: "Id",
      field: "id",
      minWidth: 65,
    },
    {
      title: "Title",
      field: "title",
      minWidth: 150,
    },
    {
      title: "Contact Number",
      field: "number",
      minWidth: 150,
    },
    {
      title: "Start Date",
      field: "start_date",
      minWidth: 120,
    },
    {
      title: "End Date",
      field: "end_date",
      minWidth: 120,
    },
    {
      title: "Total Prize (Rs.)",
      field: "total_prize",
      minWidth: 140,
      hozAlign: "right"
    },
    {
      title: "Register",
      field: "register",
      formatter: (cell) => cell.getValue() ? "Yes" : "No",
      minWidth: 100,
    },
    {
      title: "Description",
      field: "description",
      formatter: "textarea",
      minWidth: 130,
    },
    {
      title: "Images",
      field: "images",
      formatter: imagesFormatter,
      minWidth: 280,
    },
  ]
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  const parent = document.createElement("parent");
  parent.setAttribute("class", "flex gap-2");
  parent.appendChild(actionComponent({
    edit: true,
    editRoute: `/admin/tournaments/${id}/edit`,
    delete: true,
    delRoute: `/admin/tournaments/${id}/destroy`,
  }));
  const btn = document.createElement("a");
  btn.setAttribute("class", "button button-yellow button-xs");
  btn.innerText = "View Players";
  btn.href = `/admin/tournaments/players?tournament_id=${id}`;
  parent.appendChild(btn);
  return parent;

}



function imagesFormatter(cell) {
  const images = cell.getValue();
  const container = document.createElement("div");
  container.setAttribute("class", "flex flex-col gap-1 text-ellipsis");
  images.forEach((image) => {
    const imgTag = document.createElement('a');
    imgTag.href = image.image_url;
    imgTag.target = "_blank";
    imgTag.innerHTML = image.image_path;
    imgTag.setAttribute("class", "underline text-blue-500 hover:text-blue-600 visited:text-blue-400 text-ellipsis")
    container.appendChild(imgTag);
  });
  return container;
}