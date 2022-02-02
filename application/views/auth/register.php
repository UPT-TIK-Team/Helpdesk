<!-- Login form -->
<form class="col-md justify-content-center" action="<?= base_url('auth/register') ?>" method="post">
	<div class="card login-card">
		<div class="card-body">
			<div class="text-center mb-3">
				<h5 class="mb-0" style="color:black">Create account</h5>
				<span class="d-block text-muted" style="color:black">Please enter the information below</span>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class=" control-label">Username<code>*</code></label>
						<input type="text" id="username" name="username" class="form-control empty required" placeholder="" minlength="3" maxlength="30" required value="<?= set_value('username') ?>">
						<?= form_error('username', '<span class="text-danger pl-3">', '</span>'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Email address</label><code>*</code>
						<input type="email" id="email" name="email" class="form-control empty user-existance-validation" required value="<?= set_value('email') ?>" placeholder="example@unsika.ac.id">
						<?= form_error('email', '<span class="text-danger pl-3">', '</span>'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class=" control-label">Mobile</label><code>*</code>
						<div>
							<input type="text" name="country_code" id="country_code" class="form-control loan-object col-sm-3" style="float: left;" value="+62" disabled />
							<input type="text" id="mobile" name="mobile" class="form-control empty user-existance-validation required col-sm-9" placeholder="8881686666" minlength="10" maxlength="15" value="<?= set_value('mobile') ?>">
							<?= form_error('mobile', '<span class="text-danger pl-3">', '</span>'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class=" control-label">Password<code>*</code></label>
						<input type="password" id="password1" name="password1" class="form-control empty required" placeholder="" minlength="3" maxlength="30" required>
						<?= form_error('password1', '<span class="text-danger pl-3">', '</span>'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class=" control-label">Retype Password<code>*</code></label>
						<input type="password" id="password2" name="password2" class="form-control empty required" placeholder="" minlength="3" maxlength="30" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Proceed <i class="icon-circle-right2 ml-2"></i></button>
			</div>
			<div class="form-group text-center">
				<a href="<?= URL_LOGIN ?>" class="ml-auto">Already have an
					account?</a>
			</div>
		</div>
	</div>

</form>
<!-- /login form -->