<!-- Dashboard Counts Section-->
<section class="">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <?php if ($this->session->flashdata('change_password')) : ?>
              <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('change_password') ?>
              </div>
            <?php endif; ?>
            <form action="<?= base_url('API/User_API/change_password') ?>" method="POST">
              <div class="col-md-12 p-2">
                <div class="row ">
                  <div class="col-md-3">New Password</div>
                  <div class="col-md-4"><input type="password" id="new_password" name="new_password" class="form-control"></div>
                </div>
              </div>
              <div class="col-md-12 p-2">
                <div class="row ">
                  <div class="col-md-3">Confirm New Password</div>
                  <div class="col-md-4"><input type="password" id="confirm_password" class="form-control"></div>
                </div>
              </div>
              <hr>
              <div class="col-md-12 p-2">
                <div class="form group ">
                  <a href="<?= BASE_URL ?>user/profile" class="btn btn-secondary mr-3"><i class="fa fa-arrow-left"></i> Back to profile</a>
                  <button class="btn btn-success" type="submit">Update Password</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>