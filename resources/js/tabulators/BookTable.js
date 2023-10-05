import { Table, actionComponent, linkFormatter } from "./TableConfig";

const table1 = Table({
    tableId: "chess-book-table",
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
            minWidth: 120,
        },
        {
            title: "Type",
            field: "type",
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
