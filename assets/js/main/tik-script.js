import { getUserLabel, renderCustomHTML, renderDropdowns } from "./library.js";

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  // Animate loader off screen
  $(".loader").fadeOut(1000);
});

/*to get user icon*/
$(".current-user-avatar").each(function () {
  var username = $(this).attr("data-username");
  var name = username
    .split(".")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ");
  $(this).append(getUserLabel(name, username));
});

// change password
$("#change_password").on("click", function () {
  var password = $("#current_password").val();
  var new_password = $("#new_password").val();
  var confirm_password = $("#confirm_password").val();

  if (!new_password || !confirm_password || new_password !== confirm_password) {
    showNotification(
      "error",
      "New password and confirm password does not match or password fields can not be empty"
    );
  } else {
    $.ajax({
      type: "POST",
      url: BASE_URL + "API/User/change_password",
      dataType: "text",
      data: { password: password, new_password: new_password },
      success: function (response) {
        if (response)
          showNotification("success", "Password changed successfully");
        else showNotification("error", "Password could not be changed.");
      },
    });
  }
});

//registras
$("#regis_user").on("click", function (e) {
  e.preventDefault();
  var name = $("#name").val();
  var email = $("#email").val();
  var mobile = $("#mobile").val();
  var type = $("#type").val();
  var password = $("#password").val();

  // alert(name + " - "+ email + " - "+ mobile + " - "+ type);
  if (!name || !email || !mobile || !type) {
    $("#au_result").html(
      '<div class="alert alert-danger event-notification"> All fields are required. Please fill all fields.</div>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: BASE_URL + "API/Pub/regis_user",
      dataType: "text",
      data: {
        name: name,
        email: email,
        mobile: mobile,
        type: type,
        password: password,
      },

      beforeSend: function () {
        $("#au_result").html(
          '<img src="' +
            BASE_URL +
            'assets/img/loader.gif" class="pull-right" style="width: 30px;">'
        );
      },

      success: function (response) {
        if (JSON.parse(response)["data"]) {
          // showNotification('success', 'User created successfully');
          window.location.href = "/auth";
        } else
          showNotification(
            "error",
            "User coukd not be created, please try again."
          );
      },
    });
  }
});
// Add user
$("#add_user").on("click", function (e) {
  e.preventDefault();
  var name = $("#name").val();
  var email = $("#email").val();
  var mobile = $("#mobile").val();
  var type = $("#type").val();
  var password = $("#password").val();

  // alert(name + " - "+ email + " - "+ mobile + " - "+ type);
  if (!name || !email || !mobile || !type) {
    $("#au_result").html(
      '<div class="alert alert-danger event-notification"> All fields are required. Please fill all fields.</div>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: BASE_URL + "API/User/add_user",
      dataType: "text",
      data: {
        name: name,
        email: email,
        mobile: mobile,
        type: type,
        password: password,
      },

      beforeSend: function () {
        $("#au_result").html(
          '<img src="' +
            BASE_URL +
            'assets/img/loader.gif" class="pull-right" style="width: 30px;">'
        );
      },

      success: function (response) {
        if (JSON.parse(response)["data"]["result"]) {
          showNotification("success", "User created successfully");
          window.location.href = "/user/dashboard";
        } else
          showNotification(
            "error",
            "User could not be created, please try again."
          );
      },
    });
  }
});

$(".assign_to_modal").on("click", function (e) {
  e.preventDefault();
  var href = $(this).attr("href");
  $("#myModal").modal();
  $(".modal-footer").hide();
  $.ajax({
    url: href,
    beforeSend: function () {
      $(".modal-title").html("Please wait..");
      $(".modal-body").html(
        '<center><br><img src="' +
          BASE_URL +
          'assets/img/loader.gif" style="width: 30px;"></center><br>'
      );
    },

    success: function (response) {
      $(".modal-title").html("Assign Ticket..");
      $(".modal-body").html(response);
    },
  });
  // $(".modal-body").html(href);
});

// Handle when service input change, and get subservice depends on service id
$("#service").on("select2:select", (e) => {
  $("#service option[value='null']").remove();
  // Reset priority option default. First, delete option default
  $("#priority").find("option").remove();
  // Second, add new option and set it to null
  const defaultDropdown = new Option("Priority", null);
  $("#priority").append(defaultDropdown).trigger("change");
  $.get(
    `${BASE_URL}API/Ticket/getSubServices/${e.target.value}`,
    ({ data }) => {
      $("#subservice").find("option").remove();
      const defaultDropdown = new Option("Choose Sub Service", null);
      $("#subservice").append(defaultDropdown).trigger("change");
      $("#subservice").removeAttr("disabled");
      data.map((item) => {
        const itemDropdown = new Option(item.name, item.id);
        $("#subservice").append(itemDropdown).trigger("change");
      });
    }
  );
});

// Handle when subservice input change, and set priority
$("#subservice").on("select2:select", (e) => {
  $("#subservice option[value='null']").remove();
  // Get priority based on subservice id
  $.get(`${BASE_URL}API/Ticket/getPriority/${e.target.value}`, (data) => {
    $("#priority").find("option").remove();
    $("#priority").select2({
      width: "resolve",
      data: data.data.map((data) => {
        return { id: data.id, text: data.name };
      }),
    });
  });
  // Get problem based on subservice id
  $.get(`${BASE_URL}API/Expertsystem/getproblem/${e.target.value}`, (data) => {
    $("#problem").find("option").remove();
    // Append dropdown to subproblem and set to null value
    const defaultDropdown = new Option("Choose Problem", "null");
    // Add change trigger to dropdown
    $("#problem").append(defaultDropdown).trigger("change");
    // Fill problem item dropdown with select2 library
    $("#problem").select2({
      width: "resolve",
      data: data.data.map((data) => {
        return { id: data.id, text: data.name };
      }),
    });
  });
  // Get symptom based on subservice id
  $.get(`${BASE_URL}API/Expertsystem/getsymptom/${e.target.value}`, (data) => {
    $("#symptom").find("option").remove();
    // Append dropdown to subproblem and set to null value
    const defaultDropdown = new Option("Choose Symptom", "null");
    // Add change trigger to dropdown
    $("#symptom").append(defaultDropdown).trigger("change");
    // Fill symptom item dropdown with select2 library
    $("#symptom").select2({
      width: "resolve",
      data: data.data.map((data) => {
        return { id: data.id, text: data.name };
      }),
    });
  });
});
