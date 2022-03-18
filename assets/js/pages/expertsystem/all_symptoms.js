import { renderCustomHTML } from "../../main/library.js";
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
      {
        data: "code",
      },
      {
        data: "symptom",
      },
      {
        data: "service",
      },
    ],
  });
  const btnAddSymptom = document.getElementById("btn-add-symptom");
  const symptomName = document.getElementById("symptom-name");
  const service = document.getElementById("service");
  symptomName.addEventListener("keyup", () => {
    if (symptomName.value !== "" && service.value !== "") {
      btnAddSymptom.removeAttribute("disabled");
    } else {
      btnAddSymptom.disabled = true;
    }
  });
  $("#service").on("change", (e) => {
    if (service.value !== "" && symptomName.value !== "") {
      btnAddSymptom.removeAttribute("disabled");
    } else {
      btnAddSymptom.disabled = true;
    }
  });
});
