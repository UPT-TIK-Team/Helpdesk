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
                      <label class="col-sm-3 form-control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="name" required class="form-control" value="<?= $symptom['name_symptom'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Sub Layanan</label>
                      <div class="col-sm-9 select">
                        <select name="subservice" id="subservice" class="form-control">
                          <option value="<?= $symptom['id_subservice'] ?>"><?= $symptom['name_subservice'] ?></option>
                        </select>
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