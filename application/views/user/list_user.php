<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser">
              Tambah Data
            </button>
            <?php if ($this->session->userdata('email') && $this->session->userdata('password')) : ?>
              <div class="alert alert-success" role="alert">
                Tambah pengguna berhasil, berikut data pengguna baru. Email: <?= $this->session->userdata('email') ?>, Password: <?= $this->session->userdata('password') ?>
              </div>
            <?php endif; ?>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="users" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Username</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Waktu Pembuatan</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserLabel">Tambah Pengguna</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('user/add_user') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
              <label for="type">Tipe Pengguna</label>
              <select id="type" name="type" class="form-control">
                <option value=""> - Select -</option>
                <option value="60">Agent</option>
                <option value="80">Manager</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn-add-user" disabled>Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/users/ListUsers.js') ?>"></script>