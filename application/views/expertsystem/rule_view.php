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
                      <label class="col-sm-3 form-control-label">Masalah</label>
                      <div class="col-sm-9 select">
                        <select name="problem" id="problem" class="form-control">
                          <option value="<?= $rule['id_problem'] ?>"><?= $rule['name_problem'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-3 form-control-label">Gejala</label>
                      <div class="col-sm-9 select">
                        <select name="symptom" id="symptom" class="form-control">
                          <option value="<?= $rule['id_symptom'] ?>"><?= $rule['name_symptom'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">MB</label>
                        <div class="col-sm-9">
                          <input type="text" name="mb" required class="form-control" value="<?= $rule['mb'] ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 form-control-label">MD</label>
                        <div class="col-sm-9">
                          <input type="text" name="md" required class="form-control" value="<?= $rule['md'] ?>">
                        </div>
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