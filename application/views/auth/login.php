<style>
  @media (max-width: 576px) {

    #btn-masuk {
      margin-left: 4.5rem !important;
    }

    #txt-atau {
      margin-left: 8.5rem !important;
    }

    #btn-google {
      margin-left: 3rem !important;
    }
  }
</style>
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
              <img src="<?= base_url('assets/img/upttik-logo.png') ?>" style="width:100%; margin:20%;" alt="upttik-logo">
            </div>
          </div>
        </div>
        <!-- Form Panel    -->
        <div class="col-lg-6 bg-white">
          <div class="form d-flex align-items-center">
            <div class="content">
              <form method="post" class="form-validate mb-3">
                <div class="form-group">
                  <input id="login-email" type="text" name="email" required data-msg="Harap masukkan email anda!" class="input-material">
                  <label for="login-email" class="label-material">Email</label>
                </div>
                <div class="form-group">
                  <input id="login-password" type="password" name="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required data-msg="Harap masukkan password anda!" class="input-material">
                  <label for="login-password" class="label-material">Password</label>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-masuk" style="margin-left: 8rem">Masuk</button>
                <a href="<?= base_url() ?>" class="ml-2 btn btn-secondary">Kembali</a>
              </form>
              <h5 class="mt-2" style="margin-left: 12rem" id="txt-atau">Atau</h5>
              <a href="<?= $google_login_url ?>" class="btn btn-danger mb-3 mt-2" style="margin-left: 6.5rem" id="btn-google"><i class="fa fa-google mr-2" aria-hidden="true"></i>Masuk dengan Google</a>
              <br>
              <a href="<?= base_url('auth/forgotpassword') ?>" class="forgot-pass">Lupa Password?</a>
              <br>
              <small>Tidak mempunyai akun? </small><a href="<?= BASE_URL ?>auth/register" class='text-primary'>Daftar disini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyrights text-center text-dark">
    <p>Powered by <a href="<?= DEV_COMPANY_URL ?>"><img src="<?= base_url('assets/img/landing-page/unsika-logo.png') ?>" width="30rem"></a></p>
  </div>
</div>