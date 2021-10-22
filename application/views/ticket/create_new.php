<section class="forms">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label" for="subject">Subjek Masalah</label>
                      <div class="col-sm-6">
                        <input id="subject" type="text" name="subject" required="" class="form-control" placeholder="Subject of the ticket">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label">Layanan</label>
                      <div class="col-sm-6 select">
                        <select name="category" id="service" class="form-control" style="width: 100%">
                          <option value="null">Pilih Layanan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label">Sub Layanan</label>
                      <div class="col-sm-6 select">
                        <select name="subservice" id="subservice" class="form-control" style="width: 100%">
                          <option value="null">Pilih Sub Layanan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label">Urgensi</label>
                      <div class="col-sm-6 select">
                        <select name="severity" id="severity_dd" class="form-control">
                          <option value="null">Pilih Urgensi</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label">Tujuan</label>
                      <div class="col-sm-6">
                        <input id="purpose" type="text" name="purpose" required="" class="form-control" placeholder="Tujuan Pembuatan Tiket">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label">Message</label>
                      <div class="col-sm-6">
                        <div id="message"></div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 form-control-label" for="fileInput"><i class="fa fa-paperclip"></i> Attachment</label>
                      <div class="col-sm-6">
                        <div class="custom-file">
                          <input id="fileInput" type="file" class="custom-file-input">
                          <label class="custom-file-label" for="customFile">Choose
                            file</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-12 col-sm-12" id="file_submit_result">
                    </div>
                    <input type="hidden" class="form-control" id="comp_upload_filename">
                    <input type="hidden" class="form-control" id="file_submit_result_tbox">
                  </div>
                  <div class="row" style="margin-top: 1em;">
                    <div class="offset-2 col-md-6">
                      <ul id="attached_files">
                      </ul>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-8">
                      <input type="submit" id="create_ticket" value="Create Ticket" class="btn btn-success pull-right">
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="row" style="margin-top: 1em;">
              <div class="col-md-12" id="result_create_ticket">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {

    var attached_files = [];

    //call a function to handle file upload on select file
    $('input[type=file]').on('change', function(e) {
      var res = fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function(res) {
        console.log(res);
        if (res) {
          attached_files.push(res);
          var attached_link = getAttachmentLabel(res.file_name, res.path);
          $('#attached_files').append('<li>' + attached_link + '<span class="remove-this" data-index="' + attached_files.length + '"><i class="fa fa-close"></i></span></li>');
          removeAttachment();
        }
      });
    });


    var toolbarOptions = [
      [{
        'font': []
      }],
      [{
        'size': ['small', false, 'large', 'huge']
      }], // custom dropdown
      [{
        'header': [1, 2, 3, 4, 5, 6, false]
      }],
      ['bold', 'italic', 'underline', 'strike'], // toggled buttons
      ['blockquote', 'code-block'],
      [{
        'color': []
      }, {
        'background': []
      }],
      [{
        'align': []
      }],
      [{
        'list': 'ordered'
      }, {
        'list': 'bullet'
      }],
      [{
        'script': 'sub'
      }, {
        'script': 'super'
      }], // superscript/subscript
      [{
        'indent': '-1'
      }, {
        'indent': '+1'
      }], // outdent/indent
      [{
        'direction': 'rtl'
      }], // text direction
    ];

    var quill = new Quill('#message', {
      modules: {
        toolbar: toolbarOptions
      },
      theme: 'snow'
    });

    // create new ticket
    $("#create_ticket").on('click', function(a) {
      a.preventDefault();
      var purpose = $("#purpose").val();
      var subject = $("#subject").val();
      var message = quill.root.innerHTML
      const id_subservice = parseInt($("#subservice").val());
      var severity = parseInt($("#severity_dd").val());
      var id_service = parseInt($("#service").val());
      var data = {
        "attachments": attached_files
      }
      attached_files = [];
      var fdata = {
        'purpose': purpose,
        'subject': subject,
        'message': message,
        'severity': severity,
        'id_service': id_service,
        'id_subservice': id_subservice,
        'data': data
      }
      console.log(fdata);
      if (!purpose || !subject || !message) {
        showNotification('error', 'Please fill all fields.');
      } else {
        $.ajax({
          type: 'POST',
          url: BASE_URL + 'API/Ticket/create',
          dataType: 'text',
          data: fdata,
          beforeSend: function() {
            $("#result_create_ticket").html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
          },

          success: function(response) {
            console.log(response)
            if (JSON.parse(response)['data']['result']) {
              showNotification('success', 'Ticket created successfully.', {}, function() {});
              window.location.href = "<?= BASE_URL ?>/tickets/view_ticket/" + JSON.parse(response)['data']['result'];
            } else {
              $('#attached_files').html('');
              showNotification('error', 'Some error occurred, please try again.');
            }

          }

        });
      }
    });
  });


  function removeAttachment() {
    $('.remove-this').on('click', function() {
      var index = parseInt($(this).attr('data-index'));
      let attached_files = $("#attached_files");
      attached_files.splice(index, 1);
      console.log(attached_files);
      $(this).parent().remove();
    });
  }
</script>