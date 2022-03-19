<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRules">
              Add New Rules
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="rules">
                <thead>
                  <tr>
                    <th>Problem</th>
                    <th>Symptom</th>
                    <th>MB</th>
                    <th>MD</th>
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
  <div class="modal fade" id="addRules" tabindex="-1" role="dialog" aria-labelledby="addRulesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRulesLabel">Add Rules</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('API/expertsystem/addrules') ?>" method="POST">
          <div class="modal-body">
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
              <h4><i class='icon fa fa-exclamation-triangle'></i>Petunjuk Pengisian Pakar !</h4>
              Silahkan pilih gejala yang sesuai dengan masalah yang ada, dan berikan <b>nilai kepastian (MB & MB)</b> dengan cakupan sebagai berikut:<br><br>
              <b>1.0</b> (Pasti Ya)&nbsp;&nbsp;|&nbsp;&nbsp;<b>0.8</b> (Hampir Pasti)&nbsp;&nbsp;|<br>
              <b>0.6</b> (Kemungkinan Besar)&nbsp;&nbsp;|&nbsp;&nbsp;<b>0.4</b> (Mungkin)&nbsp;&nbsp;|<br>
              <b>0.2</b> (Hampir Mungkin)&nbsp;&nbsp;|&nbsp;&nbsp;<b>0.0</b> (Tidak Tahu atau Tidak Yakin)&nbsp;&nbsp;|<br><br>
              <b>CF(Pakar) = MB – MD</b><br>
              MB : Ukuran kenaikan kepercayaan (measure of increased belief) MD : Ukuran kenaikan ketidakpercayaan (measure of increased disbelief) <br> <br>
              <b>Contoh:</b><br>
              Jika kepercayaan <b>(MB)</b> anda terhadap gejala Indikator Lan card tidak menyala untuk masalah Network cable is Unplugged adalah <b>0.8 (Hampir Pasti)</b><br>
              Dan ketidakpercayaan <b>(MD)</b> anda terhadap gejala Indikator Lan card tidak menyala untuk masalah Network cable is Unplugged adalah <b>0.2 (Hampir Mungkin)</b><br><br>
              <b>Maka:</b> CF(Pakar) = MB – MD (0.8 - 0.2) = <b>0.6</b> <br>
              Dimana nilai kepastian anda terhadap gejala Indikator Lan card tidak menyala untuk masalah Network cable is Unplugged adalah <b>0.6 (Kemungkinan Besar)</b>
            </div>
            <div class="form-group">
              <label for="service">Service</label>
              <select class="form-control" name="service" id="service" style="width: 100%;">
                <option value="null">Choose Service</option>
              </select>
            </div>
            <div class="form-group">
              <label for="subservice">Subservice</label>
              <select class="form-control" name="subservice" id="subservice" style="width: 100%;" disabled>
                <option value="null">Choose Service</option>
              </select>
            </div>
            <div class="form-group">
              <label for="problem">Problem Name</label>
              <select type="text" class="form-control" id="problem" name="problem" style="width: 100%;" aria-describedby="problem" disabled>
                <option value="null">Choose Problem</option>
              </select>
            </div>
            <div class="form-group">
              <label for="symptom">Symptom Name</label>
              <select type="text" class="form-control" id="symptom" name="symptom" style="width: 100%;" aria-describedby="symptom" disabled>
                <option value="null">Choose Symptom</option>
              </select>
            </div>
            <div class="form-group">
              <label for="mb">MB</label>
              <input type="number" class="form-control" step="0.2" min="0" max="1" id="mb" name="mb" aria-describedby="mb" placeholder="Enter the number of MB">
            </div>
            <div class="form-group">
              <label for="md">MD</label>
              <input type="number" class="form-control" step="0.2" min="0" max="1" id="md" name="md" aria-describedby="md" placeholder="Enter the number of MD">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-add-rules" disabled>Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/expertsystem/all_rules.js') ?>"></script>