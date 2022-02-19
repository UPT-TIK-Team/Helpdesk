<section class="forms">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <?php if (!$this->session->userdata('access_token')) : ?>
                  <div class="alert alert-danger" role="alert">
                    Please connect with <?= $loginButton ?>, to use this feature
                  </div>
                <?php else : ?>
                  <form>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">Service</label>
                        <div class="col-sm-9 select">
                          <select name="service" id="service" class="form-control">
                            <option value="null">Choose Service</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">Sub Service</label>
                        <div class="col-sm-9 select">
                          <select name="subservice" id="subservice" class="form-control" disabled>
                            <option value="null">Choose Sub Service</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">Priority</label>
                        <div class="col-sm-9 select">
                          <select name="priority" id="priority" class="form-control" disabled>
                            <option value="null">Priority</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">Purpose</label>
                        <div class="col-sm-9">
                          <input id="purpose" type="text" name="purpose" required class="form-control" placeholder="Purpose of Ticket">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">Message</label>
                        <div class="col-sm-9">
                          <div id="message"></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group attachments">
                      <div class="row">
                        <label class="col-sm-3 form-control-label attachments-label" for="fileInput"><i class="fa fa-paperclip"></i> Attachment</label>
                        <div class="col-sm-9">
                          <div class="custom-file">
                            <input id="fileInput" type="file" class="custom-file-input">
                            <label class="custom-file-label" for="customFile">Choose
                              file</label>
                            <ul id="attached_files">
                            </ul>
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
                      <div class="col-md-12" id="result_create_ticket"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12 ml-3">
                        <input type="submit" id="create_ticket" value="Create Ticket" class="btn btn-success pull-right">
                      </div>
                    </div>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="module" src="<?= base_url('assets/js/pages/tickets/CreateNewTicket.js') ?>"></script>