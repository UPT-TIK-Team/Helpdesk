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
  const btnAddProblem = document.getElementById("btn-add-problem");
  const problemName = document.getElementById("problem-name");
  const solution = document.getElementById("solution");
  problemName.addEventListener("keyup", () => {
    if (problemName.value !== "" && solution.value !== "") {
      btnAddProblem.removeAttribute("disabled");
    } else {
      btnAddProblem.disabled = true;
    }
  });
  solution.addEventListener("keyup", () => {
    if (solution.value !== "" && problemName.value !== "") {
      btnAddProblem.removeAttribute("disabled");
    } else {
      btnAddProblem.disabled = true;
    }
  });
});
