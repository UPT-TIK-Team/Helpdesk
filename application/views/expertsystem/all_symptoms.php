<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSymptom">
              Add New Symptom
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="symptoms">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Subservice</th>
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
  <div class="modal fade" id="addSymptom" tabindex="-1" role="dialog" aria-labelledby="addSymptomLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSymptomLabel">Add Symptom</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('API/expertsystem/addsymptom') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="symptom-name">Name</label>
              <input type="text" class="form-control" id="symptom-name" name="symptom-name" aria-describedby="symptom-name" placeholder="Enter name of the symptom">
            </div>
            <div class="form-group">
              <label for="service">Service</label>
              <select class="form-control" name="service" id="service" style="width: 100%;">
                <option value="">Choose Service</option>
              </select>
            </div>
            <div class="form-group">
              <label for="subservice">Subservice</label>
              <select class="form-control" name="subservice" id="subservice" style="width: 100%;" disabled>
                <option value="">Choose Subservice</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-add-symptom" disabled>Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/expertsystem/all_symptoms.js') ?>"></script>