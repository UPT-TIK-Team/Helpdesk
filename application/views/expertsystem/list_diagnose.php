<?php if (count($symptom) != 0) : ?>
  <div id="table-list-diagnosa">
    <div class="alert alert-success text-justify" role="alert">
      Silahkan memilih gejala sesuai dengan kondisi yang anda alami, anda dapat memilih kepastian kondisi gejala diantara "pasti tidak" sampai "pasti ya", jika sudah selesai silahkan tekan tombol <span class="badge badge-danger">Cek</span> dibawah
    </div>
    <table class=" table table-striped display nowrap">
      <thead>
        <tr>
          <th scope="col">Code</th>
          <th scope="col">Name</th>
          <th scope="col">Condition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($symptom as $g) : ?>
          <tr>
            <td><?= $g['code'] ?></td>
            <td><?= $g['name'] ?></td>
            <td>
              <select class="form-select" name="condition[]" id="condition">
                <option value="0">Pilih Kondisi Jika Sesuai</option>
                <?php foreach ($condition as $c) : ?>
                  <option value=<?= $g['id'] . '_' . $c['id'] ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button class=" btn btn-primary m-auto" id="btn-diagnose" data-toggle="tooltip" data-placement="bottom" title="Klik disini untuk melihat hasil diagnosa">
      CEK
    </button>
  </div>
<?php else : ?>
  <h1 id="table-list-notfound">Maaf saat ini data belum tersedia</h1>
<?php endif; ?>

<script>
  $(document).ready(
    $('#btn-diagnose').on('click', e => {
      $('#table-list-notfound').remove()
      let data = {
        'condition': [],
        'id_subservice': $('#subservice').val()
      }
      const condition = document.querySelectorAll('#condition')
      // Handle when e.value equal to '0'
      condition.forEach(e => e.value !== '0' && data.condition.push(e.value))
      try {
        if (data.condition.length === 0) {
          throw new Error('Tidak ada kondisi yang dipilih')
        }
        $.ajax({
          type: 'POST',
          url: `<?= base_url('Expertsystem/result') ?>`,
          data,
          success: response => {
            $('#table-list-diagnosa').remove()
            $('#diagnose-row').children('form').replaceWith(response)
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            })
          }
        })
        condition.forEach(e => e.value = null)
      } catch (error) {
        Swal.fire({
          title: error.message,
          icon: "error",
        });
      }
    })
  )
</script>