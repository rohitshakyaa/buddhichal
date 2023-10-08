import { Table, actionComponent, linkFormatter } from "./TableConfig";

const table1 = Table({
  tableId: "team-champion-table",
  apiUrl: "/api/web/admin/team-champions",
  columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 130,
    },
    {
      title: "Priority",
      field: "priority",
      minWidth: 80,
    },
    {
      title: "Title",
      field: "title",
      minWidth: 150,
    },
    {
      title: "Location",
      field: "location",
      minWidth: 150,
    },
    {
      title: "Captain Name",
      field: "captain_name",
      minWidth: 150,
    },
    {
      title: "Phone Number",
      field: "phone_number",
      minWidth: 150,
    },
    {
      title: "Year in BS",
      field: "year",
      minWidth: 150,
    },
    {
      title: "Images",
      field: "images",
      formatter: imagesFormatter,
      minWidth: 300,
    },
  ],
});

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: true,
    editRoute: `/admin/team-champions/${id}/edit`,
    delete: true,
    delRoute: `/admin/team-champions/${id}/destroy`,
  });
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
