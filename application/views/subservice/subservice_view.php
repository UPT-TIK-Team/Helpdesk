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
                        <input type="text" name="code" required class="form-control" value="<?= $subservice['code'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Sub Layanan</label>
                      <div class="col-sm-9">
                        <input type="text" name="subservice" required class="form-control" value="<?= $subservice['name_subservice'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Layanan</label>
                      <div class="col-sm-9 select">
                        <select name="service" id="service" class="form-control">
                          <option value="<?= $subservice['id_service'] ?>"><?= $subservice['name_service'] ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Prioritas</label>
                      <div class="col-sm-9 select">
                        <select name="priority" id="priority" class="form-control">
                          <option value="<?= $subservice['id_priority'] ?>"><?= $subservice['name_priority'] ?></option>
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