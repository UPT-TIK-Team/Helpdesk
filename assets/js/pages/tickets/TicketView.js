import {
  showNotification,
  fileUpload,
  getAttachmentLabel,
} from "../../main/library.js";

$(document).ready(function () {
  var attached_files = [];

  //call a function to handle file upload on select file
  $("input[type=file]").on("change", function (e) {
    $("#result_create_ticket").html(
      `<img src="${BASE_URL}/assets/img/loading.gif" class="pull-right" style="width: 30px;">`
    );
    fileUpload(e, `${BASE_URL}API/Ticket/upload_attachment`, function (res) {
      if (res) {
        $("#result_create_ticket").html("");
        attached_files.push(res);
        var attached_link = getAttachmentLabel(res.file_name, res.path);
        $("#attached_files").append(
          "<li>" +
            attached_link +
            '<span class="remove-this" data-index="' +
            attached_files.length +
            '"><i class="fa fa-close"></i></span></li>'
        );
        removeAttachment();
      }
    });
  });

  var toolbarOptions = [
    [
      {
        font: [],
      },
    ],
    [
      {
        size: ["small", false, "large", "huge"],
      },
    ], // custom dropdown
    [
      {
        header: [1, 2, 3, 4, 5, 6, false],
      },
    ],
    ["bold", "italic", "underline", "strike"], // toggled buttons
    ["blockquote", "code-block"],
    [
      {
        color: [],
      },
      {
        background: [],
      },
    ],
    [
      {
        align: [],
      },
    ],
    [
      {
        list: "ordered",
      },
      {
        list: "bullet",
      },
    ],
    [
      {
        script: "sub",
      },
      {
        script: "super",
      },
    ], // superscript/subscript
    [
      {
        indent: "-1",
      },
      {
        indent: "+1",
      },
    ], // outdent/indent
    [
      {
        direction: "rtl",
      },
    ], // text direction
  ];

  // For Text Editor
  var cquill = new Quill("#comment", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow",
  });

  $("#reply").on("click", function (e) {
    e.preventDefault();
    var ticket_no = $(this).attr("data-ticket-no");
    var message = cquill.root.innerHTML;
    var data = {
      attachments: attached_files,
    };
    attached_files = [];
    $.ajax({
      type: "POST",
      url: `${BASE_URL}API/Ticket/addThreadMessage`,
      dataType: "text",
      data: {
        ticket_no: ticket_no,
        message: message,
        data: data,
        type: 1,
      },
      beforeSend: function () {
        $("#result_create_ticket").html(
          `<img src="${BASE_URL}/assets/img/loading.gif" class="pull-right" style="width: 30px;">`
        );
      },
      success: function (response) {
        if (JSON.parse(response)["data"]["result"]) {
          showNotification("success", "Comment added successfully", {}, () => {
            window.location.reload();
          });
        } else showNotification("error", "Some error occured");
      },
    });
  });

  $("select.form-control").on("change", function () {
    let field = $(this).attr("name");
    let value = this.value;
    let ticket_id = $(this).attr("data-id");
    let message = `Changed ${field} to <span class="tik-${field}" data-value="${value}"></span>`;
    let plain_txt_message = "Changed " + field + " to " + value + ".";
    let type = parseInt($(this).attr("data-type"));
    let data = {
      update_data: {
        id: ticket_id,
      },
      meta: {
        ticket_no,
        message,
        type,
        plain_txt_message,
      },
    };
    data["update_data"][field] = value;

    // Handle if field assign to is change, so send only id from agent
    if (field === "assign_to") {
      // Get text from select2 dropdown
      const text = $("select.form-control").select2("data")[0].text;
      data["update_data"][field] = value;
      data.meta.message = `Changed assigned to <span class="user-label" data-value="${text}" data-username="${text}"></span>`;
      data.meta.plain_txt_message = `Changed assigned to ${text}.`;
      data["update_data"]["assign_on"] = Date.now();
      data["update_data"]["status"] = 50; //hardcoded assigned status;
    }

    // Send data using ajax
    $.ajax({
      type: "POST",
      url: `${BASE_URL}API/Ticket/updateTicket`,
      dataType: "text",
      data: data,
      // beforeSend: function () {
      //   $("#au_result").html(
      //     '<img src="../../../assets/img/loader.gif" class="pull-right" style="width: 30px;">'
      //   );
      // },
      success: function (response) {
        if (JSON.parse(response)["data"]["result"]) {
          showNotification("success", data.meta.message, {}, () =>
            window.location.reload()
          );
        } else {
          showNotification("error", "Some error occured.");
        }
      },
    });
  });

  $.get(BASE_URL + "API/User/getAll?type=[60]", function (data) {
    $("#assign_to_dd").select2({
      data: data.data.map((data) => {
        return { id: data.id, text: data.username };
      }),
    });
  });

  // Check if quill editor is empty
  cquill.on("text-change", () => {
    if (cquill.getLength() > 1) return $("#reply").removeAttr("disabled");
    return $("#reply").prop("disabled", true);
  });
});

function removeAttachment() {
  $(".remove-this").on("click", function () {
    var index = parseInt($(this).attr("data-index"));
    let attached_files = $("#attached_files");
    attached_files.splice(index, 1);
    $(this).parent().remove();
  });
}
