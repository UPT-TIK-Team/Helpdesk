<div class="container fluid-content ">
  <div class="row ">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card ticket-head custom-border-radius m-0">
            <div class="d-flex align-content-between">
              <p style="white-space: nowrap;" class="pr-2">
                <span class="tik-status text-right" data-value="<?= $info['status'] ?>"></span>
                <br>
                <span class="mt-3"><i class="fa fa-ticket"></i>
                  <?= $ticket_no ?></span>
              </p>
              <div class="pr-2">
                <?PHP
                $tik_attachments = '';
                $decoded = json_decode($info['data'], true);
                if ($decoded) $tik_attached = $decoded['attachments'];
                if ($decoded && $tik_attached) {
                  foreach ($decoded['attachments'] as $tik_attachment) {
                    $tik_attachments = $tik_attachments . '<p><span class="attachment" data-filename="' . $tik_attachment['file_name'] . '" data-filepath="' . $tik_attachment['path'] . '"></p>';
                  }
                }
                ?>
                <h3><?= $info['subject'] ?></h3>
                <p><?= $info['message'] . $tik_attachments ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="comments-container">
            <ul id="comments-list" class="comments-list">
              <?PHP foreach ($messages as $message) {
                $attachments = '';
                $decoded = json_decode($message['data'], true);
                if ($decoded)
                  $attached = $decoded['attachments'];
                if ($decoded && $attached)
                  foreach ($decoded['attachments'] as $attachment) {
                    $attachments = $attachments . '<p><span class="attachment" data-filename="' . $attachment['file_name'] . '" data-filepath="' . $attachment['path'] . '"></p>';
                  }
                if ($message['type'] == 1)
                  echo '<li>
                                <div class="comment-main-level">
                                    <div class="d-flex align-items-start">
                                        <!-- Avatar -->
                                        <div class="comment-avatar" data-username="' . $message['owner'] . '"></div>
                                        <!-- Comment & Attachments -->

                                        <div class="comment-box">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="#" class="user-name" data-username="' . $message['owner'] . '"></a></h6>
                                                <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                            </div>
                                            <div class="comment-content">
                                                ' . $message['message'] . $attachments
                    . '
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>';
                else
                  echo ' <li>
                            <!-- Activity-tag -->
                           <div class="activity-tag">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                       <i class="activity-icon" data-type="' . $message['type'] . '"></i>
                                    <div class="activity-text">
                                        <h6 class="comment-name"><a href="#">@' . $message['owner'] . '</a> ' . $message['message'] . ' 
                                            <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </li>';
              } ?>
            </ul>
            <div class="col-md-12 add-comment custom-border-radius">
              <h3>Leave a comment</h3>
              <!-- <form> -->
              <div id="comment" style="min-height: 100px;"></div>
              <br>
              <div class="row">
                <label class="col-sm-12 form-control-label" for="fileInput"><i class="fa fa-paperclip"></i> Attachment</label>
                <div class="col-sm-12">
                  <div class="custom-file">
                    <input id="fileInput" type="file" class="custom-file-input">
                    <label class="custom-file-label" for="customFile" id="attached_files">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary" id="reply" data-ticket-no="<?= $info['ticket_no'] ?>">Reply <i class="fa fa-reply"></i>
                  </button>
                </div>
              </div>

              <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-4 no-padding-left ticket-details-right">
      <div class="card custom-border-radius sticky-this">
        <div class="card-header d-flex align-items-center custom-border-radius">
          <h3 class="h4"><i class="fa fa-ticket"></i>Details</h3>
        </div>
        <div class="card-body">
          <div class="table-responsiveW">
            <table class="table">
              <tr>
                <th class="border-0">Ticket Number</th>
                <td class="border-0"><?= $info['ticket_no'] ?></td>
              </tr>
              <tr>
                <th>Created on</th>
                <td><span class="rel-time" data-value="<?= $info['created'] . '000' ?>"></span></td>
              </tr>
              <tr>
                <th>Created By</th>
                <td><span class="user-label" data-username="<?= isset($info['owner']) ? $info['owner'] : '' ?>"></span>
                </td>
              </tr>
              <tr>
                <th>Purpose</th>
                <td><?= $info['purpose'] ?></td>
              </tr>
              <tr>
                <th>Ticket Status</th>
                <td>
                  <?php if ($info['status'] == 100) : ?>
                    <select name="status" id="status_dd" data-id="<?= $info['id'] ?>" class="form-control" disabled>
                    <?php else : ?>
                      <select name="status" id="status_dd" data-id="<?= $info['id'] ?>" class="form-control">
                      <?php endif; ?>
                      <option value="<?= $info['status'] ?>"><?= $info['name_status'] ?></option>
                      </select>
                </td>
              </tr>
              <tr>
                <th>Ticket Severity</th>
                <td>
                  <select name="severity" id="severity_dd" data-id="<?= $info['id'] ?>" class="form-control">
                    <option value="<?= $info['severity'] ?>"><?= $info['name_severity'] ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Ticket Service</th>
                <td>
                  <select name="id_service" id="service" data-id="<?= $info['id'] ?>" class="form-control" disabled>
                    <option value="<?= $info['id_service'] ?>"><?= $info['name_service'] ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Ticket Sub Service</th>
                <td>
                  <select name="id_subservice" id="subservice" data-id="<?= $info['id'] ?>" class="form-control" disabled>
                    <option value="<?= $info['id_subservice'] ?>"><?= $info['name_subservice'] ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Assigned to</th>
                <td>
                  <?php if ($privilege) : ?>
                    <select name="assign_to" id="assign_to_dd" data-id="<?= $info['id'] ?>" class=" form-control">
                      <option value="<?= $info['assign_to'] ?>"><?= $info['assign_to'] ?></option>
                    </select>
                  <?php endif; ?>
              </tr>
              <tr>
                <th>Assigned on</th>
                <td><span class="rel-time" data-value="<?= $info['assign_on'] ?>"></span></td>
              </tr>
              <tr>
                <th>Last Updated on</th>
                <td><span class="rel-time" data-value="<?= $info['updated'] . '000' ?>"></span></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
<script type="module" src="<?= base_url('assets/js/pages/tickets/view_ticket.js') ?>"></script>