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

  var quill = new Quill("#message", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow",
  });

  // create new ticket
  $("#create_ticket").on("click", function (a) {
    a.preventDefault();
    const id_service = parseInt($("#service").val());
    const id_subservice = parseInt($("#subservice").val());
    const id_priority = parseInt($("#priority").val());
    const purpose = $("#purpose").val();
    const message = quill.root.innerHTML;
    const assign_to = 0;
    const data = {
      attachments: attached_files,
    };
    attached_files = [];
    var fdata = {
      id_service,
      id_subservice,
      id_priority,
      purpose,
      message,
      assign_to,
      data,
    };
    if (!id_priority) {
      return showNotification("error", "Please fill sub service fields");
    } else if (!purpose) {
      return showNotification("error", "Please fill purpose fields");
    } else {
      $.ajax({
        type: "POST",
        url: `${BASE_URL}API/Ticket/create`,
        dataType: "text",
        data: fdata,
        beforeSend: function () {
          $("#result_create_ticket").html(
            `<img src="${BASE_URL}/assets/img/loading.gif" class="pull-right" style="width: 30px;">`
          );
        },
        success: function (response) {
          if (JSON.parse(response)["data"]["result"]) {
            showNotification(
              "success",
              "Ticket created successfully.",
              {},
              function () {
                window.location.href = `${BASE_URL}/tickets/view_ticket/${
                  JSON.parse(response)["data"]["result"]
                }`;
              }
            );
          } else {
            $("#attached_files").html("");
            showNotification("error", "Some error occurred, please try again.");
          }
        },
      });
    }
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
