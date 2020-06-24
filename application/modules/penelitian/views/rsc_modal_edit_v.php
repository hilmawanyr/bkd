<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Perbarui Penelitian</h4>
</div>
<form class="form-horizontal" action="<?= base_url('update-rsc') ?>" method="post">
	<div class="modal-body">

			<div class="form-group">
		        <label class="col-sm-2 control-label" for="judul">Judul</label>
		        <div class="col-md-10">
		        	<textarea class="form-control" name="judul"><?= $rsc->judul ?></textarea>
		        	<input type="hidden" name="keys" value="<?= $rsc->key ?>">
		        </div>			
			</div>

			<div class="form-group">
		        <label class="col-sm-2 control-label" for="judul">Program</label>
		        <div class="col-md-10">
		        	<input type="text" class="form-control" value="<?= $rsc->program ?>" disabled="" />
		        	<input type="hidden" value="<?= $rsc->kode_program ?>" name="program" id="rscProgramEdit" >
		        </div>			
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Kegiatan</label>
				<div class="col-md-10">
					<select class="form-control" name="kegiatan" id="rscActivityEdit" required="">
						<option disabled="" selected="" value="">-- Pilih Kegiatan --</option>
						
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" id="param-type-edit">Peran</label>
				<div class="col-md-10">
					<select class="form-control" name="param" id="rscParamEdit" required="">
						<option disabled="" selected="" value="">-- Pilih Peran --</option>
						
					</select>
				</div>
			</div>

			<div class="form-group" id="member-column-edit">
		        <label class="col-sm-2 control-label" for="memberEdit">Jumlah Anggota</label>
		        <div class="col-md-10">
		        	<input 
		        		onkeypress="return isNumber(event)" 
		        		maxlength="2" 
						type="text" 
						name="member" 
						id="memberEdit" 
						placeholder="Masukan jumlah anggota"  
						class="form-control" />	
		        </div>			
			</div>
			
			<span id="member-area-edit"></span>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Beban SKS</label>
				<div class="col-md-10">
					<input 
						type="text" 
						value="<?= $rsc->sks ?>" 
						id="rscCreditEdit" 
						readonly="" 
						name="sks" 
						class="form-control" />
				</div>
			</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn bg-olive">Update</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</form>

<script>
	$(document).ready(function(){
		$('#member-column-edit').hide();
		
		// get activity program
		$.post('<?= base_url('program-penelitian/') ?>'+$('#rscProgramEdit').val(),{},function(get){
			$('#rscActivityEdit').html(get);
			$('#member-area-edit').empty();
		});

		// get param activity
		$('#rscActivityEdit').change(function() {
			$.post('<?= base_url('parameter-penelitian/') ?>' + $(this).val(), {}, function(get) {
				var parseData = JSON.parse(get);
				$('#param-type-edit').html(parseData.param);
				$('#rscParamEdit').html(parseData.options);
			})

			$.post('<?= base_url('set-duration-category/') ?>' + $(this).val(), {}, function (arg) {
				$('#member-area-edit').html(arg);
			})
		})

		// set SKS by param and activity program
		$('#rscProgramEdit,#rscActivityEdit,#rscParamEdit').change(function(){
			$.post('<?= base_url('sks-penelitian/') ?>'+$('#rscActivityEdit').val()+'/'+$('#rscParamEdit').val(),{},function(get){
				$('#rscCreditEdit').val(get);

				if ($('#param-type-edit').text() === 'Peran' && 
					(
						$('#rscParamEdit :selected').text() !== 'Anggota' && 
						$('#rscParamEdit :selected').text().includes('Tambahan') === false)
					) 
				{ 
					$('#member-column-edit').show('fast');
					$('#memberEdit').attr('required','required');
				} else {
					$('#member-column-edit').hide('fast');
					$('#memberEdit').removeAttr('required');
					$('#memberEdit').val('')
				} 
			});
		});
	})
</script>