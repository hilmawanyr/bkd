<?php $this->load->view('template/message_alert'); ?>

<h3>
	<i class="fa fa-copy"></i> Tugas Tambahan Dosen Tahun Akademik 
	<span data-toggle="tooltip" title="lihat rincian lain-lain">
		<a href="#otherInfo" data-toggle="modal" onclick="load_structural_position()">
			<i class="fa fa-eye"></i>
		</a>
	</span>
</h3>
<br>
<form class="form-horizontal" action="<?= base_url('struktural/store') ?>" method="post">
	<div class="control-group">
		<label for="position" class="control-label">Jabatan Struktural</label>
		<div class="controls">
			<select name="position" id="position" class="form-control span4">
				<option disabled="" selected="" value="">-- Pilih Jabatan --</option>
				<?php foreach ($jabatan as $other) { ?>
					<option value="<?= $other->id.'-'.$other->sks ?>"><?= $other->jabatan ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label for="sks" class="control-label">Beban SKS</label>
		<div class="controls">
			<input type="text" name="sks" readonly="" value="" id="sks" class="form-control span1" placeholder="SKS">
		</div>
	</div>
	
	<div class="control-group" style="margin-top: 5px;">
		<button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Tambah</button>
	</div>
</form>

<div id="otherInfo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Informasi Jabatan Struktural</h4>
			</div>
			<div class="modal-body">
				<p id="textContent"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

		// set sks to input box
		$('#position').change(function() {
			var credits = $(this).val().split("-")[1];
			$('#sks').val(credits);
		})
	})

	function load_structural_position() {
		$.get('<?= base_url('struktural/show') ?>', function(response) {
			var dataParse = JSON.parse(response);
			if (typeof(dataParse.data) !== 'undefined') {
				let res = dataParse.data
					$('#textContent').text(`Sebagai ${res.jabatan}, pada tahun akademik ${res.tahunakademik}`);
					$('#textContent').append(`
						<a 
							class="btn btn-danger pull-right" 
							onclick="return confirm('Yakin ingin menghapus data ini?')"
							href="<?= base_url('struktural/remove/') ?>` + res.id + ` "
							data-toggle="tooltip" 
							title="hapus tugas tambahan">
							<i class="fa fa-trash"></i>
						</a>`)
				
			}else{
				$("#textContent").text("Tidak ada data")
			}

		})
	}
</script>