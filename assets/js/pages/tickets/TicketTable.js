$(document).ready(() => {
  $(function () {
    $("#tickets").dataTable({
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
          data: "ticket_no",
        },
        {
          data: "owner",
        },
        {
          data: "username",
        },
        {
          data: "status",
          render: (data) => {
            if (data == 100) {
              return `<div class="badge badge-danger">Close</div>`;
            } else if (data == 50) {
              return `<div class="badge badge-warning">In Progress</div>`;
            } else {
              return `<div class="badge badge-success">Open</div>`;
            }
          },
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
          data: "subservice",
        },
        {
          data: "ticket_no",
          render: (data) => {
            return `<a href="view_ticket/${data}" class="badge badge-primary">Lihat</a>`;
          },
        },
      ],
      order: [[0, "desc"]],
    });
  });
});
