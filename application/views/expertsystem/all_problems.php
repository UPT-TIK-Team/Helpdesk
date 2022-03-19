<!-- Dashboard Counts Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card  custom-border-radius">
          <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProblems">
              Add New Problem
            </button>
            <div class="table-responsive mt-3">
              <table class="table table-striped display nowrap" id="problems">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Solution</th>
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
  <div class="modal fade" id="addProblems" tabindex="-1" role="dialog" aria-labelledby="addProblemsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProblemsLabel">Add Problem</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('API/expertsystem/addproblem') ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="problem-name">Name</label>
              <input type="text" class="form-control" id="problem-name" name="problem-name" aria-describedby="problem-name" placeholder="Enter name of the problem">
            </div>
            <div class="form-group">
              <label for="solution">Solution</label>
              <input type="text" class="form-control" id="solution" name="solution" aria-describedby="solution" placeholder="Enter a solution">
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
            <button type="submit" class="btn btn-primary" id="btn-add-problem" disabled>Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= base_url('assets/js/pages/expertsystem/all_problems.js') ?>"></script>