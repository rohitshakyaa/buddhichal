import { Table, actionComponent } from "./TableConfig";

const urlParams = new URLSearchParams(window.location.search);
const tournament_id = urlParams.get('tournament_id');

const table = Table({
  tableId: "tournament-player-table", apiUrl: `/api/web/admin/tournaments/players${tournament_id ? `?tournament_id=${tournament_id}` : ""}`, columns: [
    {
      title: "Action",
      formatter: actionFormatter,
      resizable: false,
      width: 100,
    },
    {
      title: "Tournament Title",
      field: "tournament_title",
      formatter: tournamentLinkFormatter,
      minWidth: 165,
    },
    {
      title: "Name",
      field: "name",
      minWidth: 120,
    },
    {
      title: "Phone Number",
      field: "phone_number",
      minWidth: 140,
    },
    {
      title: "Address",
      field: "address",
      minWidth: 120,
    },
    {
      title: "DOB",
      field: "dob",
      minWidth: 100,
    },
    {
      title: "Fide Id",
      field: "fide_id",
      minWidth: 100,
    },
    {
      title: "Fide Rating",
      field: "fide_rating",
      minWidth: 120,
    },
    {
      title: "Email",
      field: "email",
      minWidth: 100,
    },
  ]
})

function actionFormatter(cell) {
  const { id = 0 } = cell.getData();
  return actionComponent({
    edit: false,
    delete: true,
    delRoute: `/admin/tournaments/players/${id}/destroy`,
  });
}

function tournamentLinkFormatter(cell) {
  const { tournament_id = 0 } = cell.getData();
  if (cell.getValue()) {
    const imgTag = document.createElement('a');
    imgTag.href = `/admin/tournaments?id=${tournament_id}`;
    imgTag.innerText = cell.getValue();
    imgTag.setAttribute("class", "underline text-blue-500 hover:text-blue-600 ")
    return imgTag;
  }
  return "";
}