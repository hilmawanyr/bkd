<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Unggah Bukti Penelitian</h4>
</div>
<form class="form-horizontal" action="<?= base_url('submit-doc/'.$doc_key) ?>" method="post">
	<div class="modal-body">
		<div class="row">
			<?php foreach ($data as $docs) : ?>
				<div class="col-md-6 col-xs-12">
					<div class="callout">
						<label for="exampleInputFile"><?= $docs->jenis ?></label>
						<?php $is_doc_exist = $this->rrscm->is_research_has_doc($doc_key, $docs->kode);
						if ($is_doc_exist->num_rows() > 0) : ?>
						 	<a href="<?= $is_doc_exist->row()->url ?>" style="color: #001F3F">
						 		<?= $is_doc_exist->row()->url ?>
						 	</a>&nbsp;&nbsp;&nbsp;
						 	<a 
						 		href="<?= base_url('remove-doc-link/'.$docs->kode.'/'.$doc_key) ?>" 
						 		style="color: #001F3F"
						 		data-toggle="tooltip"
						 		title="Hapus lampiran"
						 		onclick="return confirm('Anda yakin ingin menghapus data ini?')">
						 		<i class="fa fa-trash"></i>
						 	</a>
						 <?php else : ?>
						 	<input type="url" class="form-control" placeholder="Masukan link dokumen" name="attachment[]">
	                  		<input type="hidden" name="doctype[]" value="<?= $docs->kode ?>">
						 <?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="modal-footer">
		<?php if ($is_doc_complete == 0 || $is_doc_complete == 1) : ?>
			<button type="submit" class="btn bg-olive">Submit</button>
		<?php endif; ?>
		
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>

<script>
	$(document).ready(function () {
		$('[data-toggle="tooltip"]').tooltip({ trigger: "hover" })
	})
</script>