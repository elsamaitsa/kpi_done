<div class="container">
	<div class="login-lay">
		<div class="card-box">
			<div class="body-card">
				<h6 class="text-dark-blue fs-20">Masuk</h6>
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_header" style="width: 400px">
				<h6 class="font-weight-normal fs-12 text-gray lh-1">
					Pilih satu cara untuk masuk menggunakan alamat email atau nomor telepon yang terdaftar.
				</h6>
				<!-- Tab -->
				<ul class="nav nav-pills nav-fill pills-custom mt-3 mb-3" id="pills-tab" role="tablist">
					<li class="nav-item nav-item-pills-custom">
						<a class="nav-link active" id="pills-email-tab" data-toggle="pill" href="#pills-email" role="tab" aria-controls="pills-email" aria-selected="true">Alamat Email</a>
					</li>
					<li class="nav-item nav-item-pills-custom">
						<a class="nav-link" id="pills-ponsel-tab" data-toggle="pill" href="#pills-ponsel" role="tab" aria-controls="pills-ponsel" aria-selected="false">Nomor Telepon</a>
					</li>
				</ul>

				<!-- Tab Content 2 -->
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">

						<div class="form-group form-cust-login">
							<label>Alamat Email</label>
							<input type="email" class="form-control email" placeholder="Masukan Alamat Email">
						</div>
						<button class="btn btn-main btn-block fs-13 btn-submit-email">MASUK</button>
						<div class="d-flex flex-column">
							<div class="spinner-border align-self-center d-none" id="spinners-email" style="color: #229BD8;" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>

						<!-- Button disabled -->
						<!-- <button type="submit" class="btn btn-main btn-block fs-14" disabled>Lanjut</button> -->
						<!-- /Button disabled -->

					</div>
					<div class="tab-pane fade" id="pills-ponsel" role="tabpanel" aria-labelledby="pills-ponsel-tab">

						<div class="form-group form-cust-login">
							<label>Nomor Telepon</label>
							<input type="number" class="form-control no_telepon" placeholder="Masukan Nomor Telepon">
						</div>
						<button class="btn btn-main btn-block fs-13 btn-submit-no-telepon">MASUK</button>
						<div class="d-flex flex-column">
							<div class="spinner-border align-self-center d-none" id="spinners-telp" style="color: #229BD8;" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>

						<!-- Button disabled -->
						<!-- <button type="submit" class="btn btn-main btn-block fs-14" disabled>Lanjut</button> -->
						<!-- /Button disabled -->

					</div>
				</div> <!-- /Tab Content 2 -->
				<!-- /Tab -->
			</div>
		</div>
	</div>

	<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column">
						<div class="spinner-border align-self-center" id="spinners-telp" style="color: #229BD8; width: 3rem; height: 3rem;" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<span class="align-self-center mt-3">Loading...</span>
					</div>


				</div>

			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#myTab a').on('click', function(e) {
			e.preventDefault()
			$(this).tab('show');
		})

		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

		$('.btn-submit-email').on('click', function() {
			var email = $('.email').val();
			var tokenCode = $('#csrf_header').val();

			if (!isEmail(email)) {
				swal({
					title: "Perhatian!",
					text: "Harap isi email dengan benar!",
					confirmButtonColor: "#229BD8",
					confirmButtonText: "OK",
					closeOnConfirm: false
				});
				return false;
			}

			if (email == "") {
				swal({
					title: "Perhatian!",
					text: "Harap isi email!",
					confirmButtonColor: "#229BD8",
					confirmButtonText: "OK",
					closeOnConfirm: false
				});
				return false;
			}

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>../auth/login",
				data: {
					'email': email,
					'PLToken': tokenCode,
				},
				cache: false,
				beforeSend: function() {
					$("#loading").modal("show");
				},
				success: function(data) {
					console.log(data)
					$("#loading").modal("hide");
					if (data.response.status == 'success') {
						window.location.href = "<?php echo base_url() ?>../home";
					} else if (data.response.status == 'not_registered') {
						swal({
							title: "Perhatian!",
							text: "Akun anda belum terdaftar",
							confirmButtonColor: "#229BD8",
							confirmButtonText: "OK",
							closeOnConfirm: false
						}, function() {
							location.reload(true);
						});
					}
				},
				complete: function(data) {
					$("#loading").modal("hide");
				},
				error: function(e) {
					$("#loading").modal("hide");
				}
			})

		});

		$('.btn-submit-no-telepon').on('click', function() {
			var no_telp = $('.no_telepon').val();
			var tokenCode = $('#csrf_header').val();

			if (no_telp == "") {
				swal({
					title: "Perhatian!",
					text: "Harap isi nomor telepon dengan benar!",
					confirmButtonColor: "#229BD8",
					confirmButtonText: "OK",
					closeOnConfirm: false
				});
				return false;
			}

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>../auth/login",
				data: {
					'no_telp': no_telp,
					'PLToken': tokenCode,
				},
				cache: false,
				beforeSend: function() {
					$("#loading").modal("show");
				},
				success: function(data) {
					$("#loading").modal("hide");
					if (data.response.status == 'success') {
						window.location.href = "<?php echo base_url() ?>../home";
					} else if (data.response.status == 'not_registered') {
						swal({
							title: "Perhatian!",
							text: "Akun anda belum terdaftar",
							confirmButtonColor: "#229BD8",
							confirmButtonText: "OK",
							closeOnConfirm: false
						}, function() {
							location.reload(true);
						});
					}
				},
				complete: function(data) {
					$("#loading").modal("hide");
				},
				error: function(e) {
					$("#loading").modal("hide");
				}
			})

		});
	});
</script>