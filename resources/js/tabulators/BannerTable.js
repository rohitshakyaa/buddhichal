import { Table, imageFormatter } from "./TableConfig";


const table1 = Table({
  tableId: "banner-table", apiUrl: "/api/web/admin/banners", columns: [
    {
      title: "Caption",
      field: "caption",
      minWidth: 200,
    },
    {
      title: "Link",
      field: "link",
      minWidth: 150,
    },
    {
      title: "Image",
      field: "image",
      minWidth: 120,
      formatter: imageFormatter,
    },
  ]
})
