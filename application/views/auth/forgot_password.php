<div class="page login-page">
  <div class="container d-flex align-items-center">
    <div class="form-holder has-shadow">
      <div class="row">
        <?php if ($this->session->flashdata('failed')) : ?>
          <!-- Handle if email failed sent -->
          <div class="flash-data" data-type="failed" data-flashdata="<?= $this->session->flashdata('failed') ?>"></div>
          <?php unset($_SESSION['failed']) ?>

        <?php elseif ($this->session->flashdata('success')) : ?>
          <!-- Handle if email successfully sent -->
          <div class="flash-data" data-type="success" data-flashdata="<?= $this->session->flashdata('success') ?>"></div>
          <?php unset($_SESSION['success']) ?>
        <?php endif; ?>
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
              <form method="post" class="form-validate">
                <div class="form-group">
                  <input id="email" type="text" name="email" required data-msg="Please enter your email" class="input-material">
                  <label for="email" class="label-material">Email</label>
                  <?= form_error('email', '<span class="text-danger pl-3">', '</span>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Forgot Password</button>
              </form>
              <div class="form-group">
                <a href="<?= base_url('auth/login') ?>" class="ml-auto mt-3">Already have an account?</a>
              </div>
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