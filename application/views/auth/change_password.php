<div class="page login-page">
  <div class="container d-flex align-items-center">
    <div class="form-holder has-shadow">
      <div class="row">
        <!-- Logo & Information Panel-->
        <div class="col-lg-6">
          <div class="info d-flex align-items-center">
            <div class="m-auto">
              <img src="https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png" style="width:100%; margin:20%;" alt="upttik-logo">
            </div>
          </div>
        </div>
        <!-- Form Panel    -->
        <div class="col-lg-6 bg-white">
          <div class="form d-flex align-items-center">
            <div class="content">
              <h4>Change Password For</h4>
              <p><?= $this->session->userdata('reset_email'); ?></p>
              <form method="post" class="form-validate">
                <div class="form-group">
                  <input id="password1" type="password" name="password1" required data-msg="Please enter your password" class="input-material">
                  <label for="password" class="label-material">Password</label>
                  <?= form_error('password1', '<span class="text-danger pl-3">', '</span>'); ?>
                </div>
                <div class="form-group">
                  <input id="password2" type="password" name="password2" required data-msg="Please enter your password" class="input-material">
                  <label for="password2" class="label-material">Retype Password</label>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyrights text-center text-dark">
    <p>Powered by <a href="<?= DEV_COMPANY_URL ?>" class="external"><img src="https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png" width="65" alt="tikaj"></a></p>
  </div>
</div>