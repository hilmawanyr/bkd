<section class="content-header">
	<h1>Tugas Tambahan Dosen <small>Kelola data tugas tambahan</small></h1>
	<ol class="breadcrumb">
		<li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
		<li><a href="javascript:void(0);">Tugas Tambahan</a></li>
	</ol>
</section>

<section class="content">
  	<div class="row">
    	<div class="col-xs-12">
			<div class="box box-primary">
				<?php $this->load->view('template/message_alert'); ?>
			    <div class="box-header with-border">
			      	<h3 class="box-title">Tambah Data</h3>
			    </div>

			    <div class="box-body">
			      	<form class="form-horizontal" action="<?= base_url('struktural/store') ?>" method="post">
						<div class="form-group">
							<label for="position" class="col-sm-2 control-label">Jabatan Struktural</label>
							<div class="col-sm-10">
								<select name="position" id="position" class="form-control" required="">
									<option disabled="" selected="" value="">-- Pilih Jabatan --</option>
									<?php foreach ($jabatan as $other) { ?>
										<option value="<?= $other->id.'-'.$other->sks ?>"><?= $other->jabatan ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="sks" class="col-sm-2 control-label">Beban SKS</label>
							<div class="col-sm-10">
								<input type="text" name="sks" readonly="" value="" id="sks" class="form-control" placeholder="SKS">
							</div>
						</div>
					</form>
			    </div>

			    <div class="box-footer text-center">
					<button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Tambah</button>
					<a href="#otherInfo" class="btn bg-olive" data-toggle="modal" onclick="load_structural_position()">
						<i class="fa fa-eye"></i> Lihat Data Tersimpan
					</a>
			    </div>
			</div>
		</div>
	</div>
</section>


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
					$('#textContent').text(`Sebagai ${res.jabatan}, pada tahun akademik ${res.nama_tahunakademik}`);
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