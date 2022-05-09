<section class="forms">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="POST">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Kode</label>
                      <div class="col-sm-9">
                        <input type="text" name="code" required class="form-control" value="<?= $problem['code'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" required class="form-control" value="<?= $problem['name'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Solution</label>
                      <div class="col-sm-9">
                        <textarea name="solution" required class="form-control" style="height: 20rem;"><?= $problem['solution'] ?></textarea>
                        <small class="text-danger">*Jika solusi lebih dari 1, pisahkan dengan tanda titik koma (;)</small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12 ml-3">
                      <input type="submit" value="Simpan" class="btn btn-success pull-right">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>