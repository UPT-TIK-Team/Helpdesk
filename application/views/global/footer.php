</div>
</div>
</div>
<!-- Page Footer-->
<footer class="main-footer">
  <div class="container-fluid text-center">
    <p><?= DEV_COMPANY_NAME ?> &copy; 2021</p>
  </div>
</footer>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/main/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="<?= base_url('assets/js/main/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js') ?>"></script>
<script>
  const BASE_URL = "<?= base_url() ?>";
  $(document).ready(function() {
    $('.side-navbar ul li a').each(function() {
      var url = window.location.href;
      var $this = $(this);
      if ($this.attr('href').trim() === url) {
        var current = $this.parent();
        var current_parent = $this.parent().parent().siblings('a').parent();
        current.addClass('nav-active');
        current_parent.addClass('nav-active');
      }
    })
  });

  $(function() {
    $(".loader").fadeIn();
  });

  setTimeout(function() {
    $('.event-notification').fadeOut('fast');
  }, 5000); // <-- time in milliseconds
</script>
<script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js') ?>"></script>
<script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="module" src="<?= base_url('assets/js/main/front.js') ?>"></script>
<script type="module" src="<?= base_url('assets/js/main/library.js') ?>"></script>
<script type="module" src="<?= base_url() ?>assets/js/main/tik-script.js"></script>
<script src="<?= base_url('assets/js/main/bootstrap.bundle.min.js') ?>"></script>
<script src="//code-eu1.jivosite.com/widget/jxLWhHG4Qu" async></script>
</body>

</html>