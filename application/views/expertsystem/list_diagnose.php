<?php if (count($symptom) != 0) : ?>
  <div id="table-list-diagnosa">
    <table class=" table table-striped display nowrap">
      <thead>
        <tr>
          <th scope="col">Kode</th>
          <th scope="col">Nama</th>
          <th scope="col">Kondisi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($symptom as $g) : ?>
          <tr>
            <td><?= $g['code'] ?></td>
            <td><?= $g['name'] ?></td>
            <td>
              <select class="form-select" name="kondisi" id="kondisi">
                <option value="null">Pilih Kondisi</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button class="btn btn-primary m-auto" id="btn-diagnose">Cek</button>
  </div>
<?php else : ?>
  <h1 id="table-list-notfound">Data Not Found</h1>
<?php endif; ?>

<script>
  $(document).ready(
    $('#btn-diagnose').on('click', e => {
      $('#table-hasil-diagnosa').remove()
      $('#table-list-notfound').remove()
      let data = {
        'kondisi': []
      }
      const kondisi = document.querySelectorAll('#kondisi')
      kondisi.forEach(e => data.kondisi.push(e.value))
      $.ajax({
        type: 'POST',
        url: `<?= base_url('Expertsystem/hasilDiagnosa') ?>`,
        dataType: 'text',
        data: data,
        success: response => {
          $('#hasil-diagnosa').append(response)
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          })
        }
      })
      kondisi.forEach(e => e.value = null)
    })
  )
</script>