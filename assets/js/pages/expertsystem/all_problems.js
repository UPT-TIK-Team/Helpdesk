import { renderCustomHTML } from "../../main/library.js";
document.addEventListener("DOMContentLoaded", () => {
  renderCustomHTML();
  $("#problems").dataTable({
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
      url: `${BASE_URL}API/expertsystem/generatedatatable`,
      header: "application/json",
      type: "POST",
      data: {
        endpoint: "problems",
      },
    },
    columns: [
      {
        data: "code",
      },
      {
        data: "name",
      },
    ],
  });
  const btnAddProblem = document.getElementById("btn-add-problem");
  const problemName = document.getElementById("problem-name");
  const solution = document.getElementById("solution");
  let subservice = "null";
  problemName.addEventListener("keyup", () => {
    if (
      problemName.value !== "" &&
      solution.value !== "" &&
      subservice !== "null"
    ) {
      btnAddProblem.removeAttribute("disabled");
    } else {
      btnAddProblem.disabled = true;
    }
  });
  solution.addEventListener("keyup", () => {
    if (
      solution.value !== "" &&
      problemName.value !== "" &&
      subservice !== "null"
    ) {
      btnAddProblem.removeAttribute("disabled");
    } else {
      btnAddProblem.disabled = true;
    }
  });
  $("#subservice").on("change", (e) => {
    // Set subservice value to id of subservice
    subservice = e.target.value;
    if (
      e.target.value !== "null" &&
      problemName.value !== "" &&
      solution.value !== ""
    ) {
      btnAddProblem.removeAttribute("disabled");
    } else {
      btnAddProblem.disabled = true;
    }
  });
});
