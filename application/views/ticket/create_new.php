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
                        <input id="subject" type="text" name="subject" required="" class="form-control" placeholder="Subject of Problem">
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
              <div class="col-md-12" id="result_create_ticket"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="module" src="<?= base_url('assets/js/pages/users/CreateNew.js') ?>"></script>