import { Table, actionComponent } from "./TableConfig";


const table1 = Table({
  tableId: "tournament-table", apiUrl: "/api/web/admin/tournaments", columns: [

    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Id",
      field: "id",
      minWidth: 65,
    },
    {
      title: "Title",
      field: "title",
      minWidth: 200,
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
      minWidth: 300,
    },
  ]
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/tournaments/${id}/edit`,
    delete: true,
    delRoute: `/admin/tournaments/${id}/destroy`,
  });
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