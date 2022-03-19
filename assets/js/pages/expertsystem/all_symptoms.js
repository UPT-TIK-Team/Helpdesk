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
        data: "subservice",
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
});
