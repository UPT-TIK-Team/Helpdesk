<div id="table-diagnose-result">
  <table class="table table-striped display nowrap">
    <thead>
      <tr>
        <th scope="col">Gejala Yang Dialami</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($symptom_list as $key => $value) : ?>
        <tr>
          <td><?= $key ?></td>
          <td><?= $value ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="alert alert-success" role="alert">
    <h3 class="alert-heading">Hasil Diagnosa</h3>
    <p>Permasalahan yang kemungkinan anda alami adalah:</p>
    <p><?= '<strong>' . array_keys($result_problem)[0] . '</strong> / ' . round(array_values($result_problem)[0], 2) * 100 . '%' ?></p>
  </div>
  <div class="alert alert-warning" role="alert">
    <h3 class="alert-heading">Solusi</h3>
    <ul>
      <?php foreach ($solution as $value) : ?>
        <li><?= $value ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="alert alert-danger" role="alert">
    <h3 class="alert-heading">Kemungkinan Lain</h3>
    <ul>
      <?php foreach ($problem_list as $key => $value) : ?>
        <?php if ($key == array_keys($result_problem)[0]) continue; ?>
        <li><?= "{$key} / " . round($value, 2) * 100 . "% ({$value})" ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>