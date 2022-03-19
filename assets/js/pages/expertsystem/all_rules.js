import { renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#rules").dataTable({
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
      url: `${BASE_URL}API/expertsystem/generatedatatable`,
      header: "application/json",
      type: "POST",
      data: {
        endpoint: "rules",
      },
    },
    columns: [
      {
        data: "problem",
      },
      {
        data: "symptom",
      },
      {
        data: "mb",
      },
      {
        data: "md",
      },
    ],
  });
  // Handle all input form in modal
  const btnAddRules = document.getElementById("btn-add-rules");
  let subserviceID = "null";
  let problemID = "null";
  let symptomID = "null";
  let mbValue = 0;
  let mdValue = 0;
  // Handle subservice dropdown change
  $("#subservice").on("change", (e) => {
    subserviceID = e.target.value;
    // Check subservice id, if not equal to null enable problem and symptom dropdown
    if (subserviceID !== "null") {
      $("#problem").prop("disabled", false);
      $("#symptom").prop("disabled", false);
    } else {
      btnAddRules.disabled = true;
    }
  });
  // Handle problem dropdown on change
  $("#problem").on("change", (e) => {
    problemID = e.target.value;
    if (
      problemID !== "null" &&
      mbValue >= 0.1 &&
      mbValue <= 1 &&
      mdValue >= 0.1 &&
      mdValue <= 1 &&
      symptomID !== "null" &&
      subserviceID !== "null"
    ) {
      btnAddRules.removeAttribute("disabled");
    } else {
      btnAddRules.disabled = true;
    }
  });

  // Handle symptom dropdown on change
  $("#symptom").on("change", (e) => {
    symptomID = e.target.value;
    if (
      problemID !== "null" &&
      mbValue >= 0.1 &&
      mbValue <= 1 &&
      mdValue >= 0.1 &&
      mdValue <= 1 &&
      symptomID !== "null" &&
      subserviceID !== "null"
    ) {
      btnAddRules.removeAttribute("disabled");
    } else {
      btnAddRules.disabled = true;
    }
  });
  // Handle mb (measure of belief) dropdown
  $("#mb").on("keyup mouseup", (e) => {
    mbValue = parseFloat(e.target.value);
    if (
      problemID !== "null" &&
      mbValue >= 0.1 &&
      mbValue <= 1 &&
      mdValue >= 0.1 &&
      mdValue <= 1 &&
      symptomID !== "null" &&
      subserviceID !== "null"
    ) {
      btnAddRules.removeAttribute("disabled");
    } else {
      btnAddRules.disabled = true;
    }
  });
  // Handle md (measure of disbelief) dropdown
  $("#md").on("keyup mouseup", (e) => {
    mdValue = parseFloat(e.target.value);
    if (
      problemID !== "null" &&
      mbValue >= 0.1 &&
      mbValue <= 1 &&
      mdValue >= 0.1 &&
      mdValue <= 1 &&
      symptomID !== "null" &&
      subserviceID !== "null"
    ) {
      btnAddRules.removeAttribute("disabled");
    } else {
      btnAddRules.disabled = true;
    }
  });
});
