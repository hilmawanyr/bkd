<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Detail Penelitian</h4>
</div>
<div class="modal-body">

	<form class="form-horizontal" id="temporaryform" method="post">
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Judul</label>
	        <div class="col-md-10">
	        	<textarea class="form-control" disabled=""><?= $rsc->judul ?></textarea>	
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Program</label>
	        <div class="col-md-10">
	        	<textarea class="form-control" disabled=""><?= $rsc->program ?></textarea>	
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Kegiatan</label>
	        <div class="col-md-10">
	        	<input type="text" class="form-control" value="<?= $rsc->kegiatan ?>" disabled="" />
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Peran/Progres</label>
	        <div class="col-md-10">
	        	<input type="text" class="form-control" value="<?= $rsc->parameter ?>" disabled="" />
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Jumlah Anggota</label>
	        <div class="col-md-10">
	        	<input type="text" class="form-control" value="<?= $rsc->anggota ?>" disabled="" />
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Durasi/Level</label>
	        <div class="col-md-10">
	        	<?php $duration = strlen($rsc->durasi_progres) < 2 ? 
				        			$rsc->durasi_progres.' Semester' :
				        			$this->rsc->duration_detail($rsc->durasi_progres)->jenis ?>
	        	<input type="text" class="form-control" value="<?= $duration ?>" disabled="" />
	        </div>			
		</div>
		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Beban SKS</label>
	        <div class="col-md-10">
	        	<input type="text" class="form-control" value="<?= $rsc->sks ?>" disabled="" />
	        </div>			
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>