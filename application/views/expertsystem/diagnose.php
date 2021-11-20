<div class="container-fluid">
  <div class="row">
    <div class="col-lg mt-3" id="diagnose-row">
      <label for="service">Choose Service</label>
      <select name="category" id="service" class="form-control" style="width: 100%">
        <option value="null">Choose Service</option>
      </select>
    </div>
    <div class="col-lg mt-3" id="hasil-diagnosa">
    </div>
  </div>
</div>

<script>
  $(document).ready(() => {
    $('#service').on('change', e => {
      $('#table-list-diagnosa').remove()
      $('#table-hasil-diagnosa').remove()
      $('#table-list-notfound').remove()
      const data = {
        'idservice': $('#service').val()
      }
      $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>Expertsystem/diagnose`,
        dataType: 'text',
        data: data,
        success: response => $('#diagnose-row').append(response)
      })
    })
  })
</script>