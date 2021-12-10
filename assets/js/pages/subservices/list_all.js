import { renderCustomHTML } from "../../library.js";
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
