<div class="container-fluid">
  <div class="row">
    <div class="col-lg mt-3" id="diagnose-row">
      <label for="service">Pilih Layanan</label>
      <select name="category" id="service" class="form-control" style="width: 100%">
        <option value="null">Pilih Layanan</option>
      </select>
      <label for="subservice">Pilih Sub Layanan</label>
      <select name="category" id="subservice" class="form-control" style="width: 100%" disabled>
        <option value="null">Pilih Sub Layanan</option>
      </select>
    </div>
    <div class="col-lg mt-3" id="diagnose-result">
    </div>
  </div>
</div>

<script>
  $(document).ready(() => {
    $('#subservice').on('change', e => {
      $('#table-list-diagnosa').remove()
      $('#table-diagnose-result').remove()
      $('#table-list-notfound').remove()
      if ($('#subservice').val() !== 'null') {
        const data = {
          'id_subservice': $('#subservice').val()
        }
        $.ajax({
          type: 'POST',
          url: `<?= base_url() ?>API/Expertsystem/diagnose`,
          data,
          success: response => $('#diagnose-row').append(response)
        })
      }
    })
  })
</script>