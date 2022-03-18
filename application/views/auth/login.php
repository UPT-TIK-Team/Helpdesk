<div class="page login-page">
  <div class="container d-flex align-items-center">
    <div class="form-holder has-shadow">
      <div class="row">
        <?php if ($this->session->flashdata('failed')) : ?>
          <!-- Handle if login failed -->
          <div class="flash-data" data-type="failed" data-flashdata="<?= $this->session->flashdata('failed') ?>"></div>
          <?php unset($_SESSION['failed']) ?>
        <?php elseif ($this->session->flashdata('success')) : ?>
          <div class="flash-data" data-type="success" data-flashdata="<?= $this->session->flashdata('success') ?>"></div>
          <?php unset($_SESSION['success']) ?>
        <?php elseif ($this->session->flashdata('new_update')) :  ?>
          <!-- Handle if login failed -->
          <div class="flash-data" data-type="failed" data-flashdata="Please login to continue!"></div>
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
              <form method="post" class="form-validate" action="">
                <div class="form-group">
                  <input id="login-email" type="text" name="email" required data-msg="Please enter your email" class="input-material">
                  <label for="login-email" class="label-material">Email</label>
                </div>
                <div class="form-group">
                  <input id="login-password" type="password" name="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required data-msg="Please enter your password" class="input-material">
                  <label for="login-password" class="label-material">Password</label>
                </div>
                <button type="submit" id="login" class="btn btn-primary">Login</button>
                <a href="<?= base_url() ?>" id="login" class="btn btn-secondary">Back</a>
              </form>
              <a href="<?= base_url('auth/forgotpassword') ?>" class="forgot-pass">Forgot Password?</a><br><small>Don't have an account? </small><a href="<?= BASE_URL ?>auth/register" class='text-primary'>Register</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyrights text-center text-dark">
    <p>Powered by <a href="<?= DEV_COMPANY_URL ?>" class="external"><img src="https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png" width="65" alt="UPT TIK UNSIKA"></a></p>
  </div>
</div>