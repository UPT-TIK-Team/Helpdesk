import { renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#users").dataTable({
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
      url: `${BASE_URL}User/generateDatatable`,
      header: "application/json",
      type: "POST",
    },
    columns: [
      {
        data: "email",
      },
      {
        data: "mobile",
      },
      {
        data: "username",
      },
      {
        data: "type",
        render: (data) => {
          if (data == 80) {
            return `<div class="badge badge-warning">Manager</div>`;
          } else if (data == 60) {
            return `<div class="badge badge-primary">Agent</div>`;
          } else if (data == 10) {
            return `<div class="badge badge-success">User</div>`;
          }
        },
      },
      {
        data: "status",
        render: (data) => {
          if (data == 1) {
            return `<div class="badge badge-success">Active</div>`;
          } else {
            return `<div class="badge badge-danger">Non Active</div>`;
          }
        },
      },
      {
        data: "created",
        render: (data) => {
          return '<span class="rel-time" data-value="' + data + '000">';
        },
      },
    ],
  });
  const btnAddUser = document.getElementById("btn-add-user");
  const email = document.getElementById("email");
  const type = document.getElementById("type");
  email.addEventListener("keyup", () => {
    if (email.value != "" && type.value !== "") {
      btnAddUser.removeAttribute("disabled");
    } else {
      btnAddUser.disabled = true;
    }
  });
  type.addEventListener("change", () => {
    if (type.value != "") {
      btnAddUser.removeAttribute("disabled");
    } else {
      btnAddUser.disabled = true;
    }
  });
});
