import { deleteSwal, renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#services").dataTable({
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
        data: "name",
      },
      {
        data: "created",
        render: (data) => {
          return '<span class="rel-time" data-value="' + data + '000">';
        },
      },
      {
        data: "id",
        render: (data) => {
          return `<a href="edit/${data}" class="badge badge-primary" id="action">Ubah</a><a href="delete/${data}" class="ml-1 badge badge-danger" id="action">Hapus</a>`;
        },
      },
    ],
  });
});
