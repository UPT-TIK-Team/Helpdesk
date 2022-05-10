<?php if (count($symptom) != 0) : ?>
  <div id="table-list-diagnosa">
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
                <option value="0">Choose Condition</option>
                <?php foreach ($condition as $c) : ?>
                  <option value=<?= $g['id'] . '_' . $c['id'] ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button class=" btn btn-primary m-auto" id="btn-diagnose">Cek</button>
  </div>
<?php else : ?>
  <h1 id="table-list-notfound">Data Not Found</h1>
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
      condition.forEach(e => data.condition.push(e.value))
      $.ajax({
        type: 'POST',
        url: `<?= base_url('Expertsystem/result') ?>`,
        data,
        success: response => {
          const url = "<?= base_url('user/userGuide') ?>"
          Swal.fire({
            title: 'info',
            html: `Terimakasih telah menggunakan fitur sistem pakar. Mohon kesediaan anda untuk mengisi kuesioner ini untuk penilaian terhadap kinerja sistem pakar pada layanan helpdesk <a href="https://docs.google.com/forms/d/e/1FAIpQLSfDjvobvNpOEjOsom0qaR5_-MslFX7pRavPfKRPE52c-ni-5Q/viewform" target:"_blank">DISINI</a>`,
            icon: 'warning'
          }).then(() => {
            Swal.fire({
              title: 'info',
              html: `Apabila masalah anda tidak terselesaikan silahkan baca petunjuk pengaduan masalah <a href="${url}" target:"_blank">DISINI</a>`,
              icon: 'warning'
            })
          })
          $('#table-list-diagnosa').remove()
          $('#diagnose-row').children('form').replaceWith(response)
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          })
        }
      })
      condition.forEach(e => e.value = null)
    })
  )
</script>