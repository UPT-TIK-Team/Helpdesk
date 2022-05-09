import { deleteSwal, renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#symptoms").dataTable({
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
      url: `${BASE_URL}API/expertsystem/generatedatatable`,
      header: "application/json",
      type: "POST",
      data: {
        endpoint: "symptoms",
      },
    },
    columns: [
      { data: "code" },
      { data: "symptom" },
      { data: "subservice" },
      {
        data: "id_symptom",
        render: (data) => {
          return `<a href="edit_symptom/${data}" class="badge badge-primary" id="action">Ubah</a><a href="delete_symptom/${data}" class="ml-1 badge badge-danger" id="action">Hapus</a>`;
        },
      },
    ],
  });
  const btnAddSymptom = document.getElementById("btn-add-symptom");
  const symptomName = document.getElementById("symptom-name");
  let subservice = "null";
  symptomName.addEventListener("keyup", () => {
    if (symptomName.value !== "" && subservice !== "null") {
      btnAddSymptom.removeAttribute("disabled");
    } else {
      btnAddSymptom.disabled = true;
    }
  });
  $("#subservice").on("change", (e) => {
    // Set subservice value to id of subservice
    subservice = e.target.value;
    if (e.target.value !== "null" && symptomName.value !== "") {
      btnAddSymptom.removeAttribute("disabled");
    } else {
      btnAddSymptom.disabled = true;
    }
  });
  document.addEventListener("click", (e) => {
    if (e.target.innerHTML === "Hapus") {
      e.preventDefault();
      const href = e.target.href;
      deleteSwal(href);
    }
  });
});
