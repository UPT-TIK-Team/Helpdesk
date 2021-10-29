<div class="container-fluid diagnose-row">
  <div class="row">
    <div class="col-lg-7 mt-3 select">
      <label for="service">Choose Service</label>
      <select name="category" id="service" class="form-control" style="width: 100%">
        <option value="null">Choose Service</option>
      </select>
    </div>
  </div>
</div>

<script>
  $(document).ready(() => {
    $('#service').on('change', e => {
      $('#table-diagnose').remove()
      const data = {
        'idservice': $('#service').val()
      }
      $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>Expertsystem/diagnose`,
        dataType: 'text',
        data: data,
        success: response => $('.diagnose-row').append(response)
      })
    })
  })
</script>