<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Unggah Bukti Pengabdian</h4>
</div>
<form class="form-horizontal" action="<?= base_url('submit-dev-doc/'.$key) ?>" onsubmit="return confirm('Link yang telah diunggah tidak dapat diubah, pastikan link tersebut telah benar! Lanjutkan pengunggahan?')" method="post">
	<div class="modal-body">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-xs-2">URL</label>
				<div class="col-xs-9">
					<input type="text" class="form-control" name="url" required="">
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn bg-olive">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>

<script>
	$(document).ready(function () {
		$('[data-toggle="tooltip"]').tooltip({ trigger: "hover" })
	})
</script>