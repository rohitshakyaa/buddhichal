import { TabulatorFull as Tabulator } from "tabulator-tables";

export function Table({ tableId, apiUrl, columns }) {
  if (document.getElementById(tableId)) {
    let table = new Tabulator(`#${tableId}`, {
      ajaxURL: apiUrl,
      ajaxConfig: "GET",
      layout: "fitColumns",
      placeholder: "No data to view",
      columns,
      ajaxResponse: function (url, params, response) {
        if (response?.status === "1") {
          return response.response;
        }
      },
    });
    return table;
  }
}

export function linkFormatter(cell) {
  if (cell.getValue()) {
    const imgTag = document.createElement("a");
    imgTag.href = cell.getValue();
    imgTag.target = "_blank";
    imgTag.innerHTML = cell.getValue();
    imgTag.setAttribute(
      "class",
      "underline text-blue-500 hover:text-blue-600 visited:text-blue-400",
    );
    return imgTag;
  }
  return "";
}

export function actionComponent(config) {
  const parent = document.createElement("div");
  parent.setAttribute("class", "flex gap-2");
  if (config.edit) {
    const btn = document.createElement("a");
    btn.setAttribute("class", "button button-green button-xs");
    btn.innerText = "Edit";
    btn.href = config.editRoute ?? "#";
    parent.appendChild(btn);
  }

  if (config.delete) {
    const btn = document.createElement("button");
    btn.setAttribute("class", "button button-red button-xs");
    btn.innerText = "Delete";

    const formEl = document.createElement("form");
    var csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    formEl.classList.add("hidden");
    formEl.action = config.delRoute ?? "#";
    const csrfField = document.createElement("input");
    csrfField.name = "_token";
    csrfField.value = csrf;
    formEl.appendChild(csrfField);
    formEl.method = "POST";
    btn.addEventListener("click", (e) => {
      const conf = confirm("Are you sure you want to delete this ?");
      if (conf) {
        formEl.submit();
      }
    });
    parent.appendChild(formEl);
    parent.appendChild(btn);
  }
  return parent;
}
