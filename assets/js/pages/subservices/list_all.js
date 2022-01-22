import { renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#subservices").dataTable({
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
      url: link,
      header: "application/json",
      type: "POST",
    },
    columns: [
      {
        data: "code",
      },
      {
        data: "name",
      },
      {
        data: "priority",
        render: (data) => {
          if (data == "Low") {
            return `<div class="badge badge-success">${data}</div>`;
          } else if (data == "Medium") {
            return `<div class="badge badge-warning">${data}</div>`;
          } else if (data == "High") {
            return `<div class="badge badge-danger">${data}</div>`;
          } else if (data == "Critical") {
            return `<div class="badge badge-dark">${data}</div>`;
          }
        },
      },
      {
        data: "service",
      },
      {
        data: "created",
        render: (data) => {
          return '<span class="rel-time" data-value="' + data + '000">';
        },
      },
      {
        data: "action",
      },
    ],
  });
});
