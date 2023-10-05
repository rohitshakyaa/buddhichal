import { Table, actionComponent, linkFormatter } from "./TableConfig";

const table1 = Table({
    tableId: "book-table",
    apiUrl: "/api/web/admin/books",
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
            minWidth: 200,
        },
        {
            title: "Type",
            field: "type",
            minWidth: 150,
        },
        {
            title: "File Path",
            field: "file_path",
            minWidth: 150,
            formatter: linkFormatter,

        },
        {
            title: "Image",
            field: "image",
            minWidth: 120,
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
