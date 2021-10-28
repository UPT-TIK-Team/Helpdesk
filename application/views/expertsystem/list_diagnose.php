<form action="<?= base_url('Expertsystem/hasilDiagnosa') ?>" method="post" id="table-diagnose"">
  <table class=" table table-striped display nowrap">
  <thead>
    <tr>
      <th scope="col">Kode</th>
      <th scope="col">Nama</th>
      <th scope="col">Kondisi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($gejala as $g) : ?>
      <tr>
        <td><?= $g['code'] ?></td>
        <td><?= $g['name'] ?></td>
        <td>
          <select class="form-select" name="kondisi[]">
            <option value="null">Pilih Kondisi</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>
  <button class="btn btn-primary m-auto" id="btn-diagnose" type="submit">Cek</button>
</form>