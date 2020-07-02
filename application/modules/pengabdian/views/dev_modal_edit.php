<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Perbarui Pengabdian</h4>
</div>
<form class="form-horizontal" action="<?= base_url('update-dev') ?>" method="post">
	<div class="modal-body">

		<div class="form-group">
	        <label class="col-sm-2 control-label" for="judul">Jenis</label>
	        <div class="col-md-10">
	        	<input type="text" class="form-control" value="<?= $dev->abdimas ?>" disabled="" />
	        	<input type="hidden" value="<?= $dev->type ?>" name="program" id="devTypeEdit" >
	        	<input type="hidden" value="<?= $dev->id ?>" name="id">
	        </div>			
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Program</label>
			<div class="col-md-10">
				<select class="form-control" name="devProgramEdit" id="devProgramEdit" required="">
					<option disabled selected value="">-- Pilih Program --</option>
					
				</select>
			</div>
		</div>

		<div class="form-group" id="param-types-edit">
			<label class="col-sm-2 control-label">Peran</label>
			<div class="col-md-10">
				<select class="form-control" name="devParamEdit" id="devParamEdit" required="">
					<option disabled="" selected="" value="">-- Pilih Peran --</option>
					
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Beban SKS</label>
			<div class="col-md-10">
				<input 
					type="text" 
					value="" 
					id="devCreditEdit" 
					readonly="" 
					name="devCreditEdit" 
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
		$('[data-toggle="tooltip"]').tooltip();
		
		$.post('<?= base_url('dev-program/') ?>'+$('#devTypeEdit').val(),{},function(get){
			$('#devProgramEdit').html(get);
		});

		$('#devProgramEdit').change(function() {
			$.post('<?= base_url('dev-param/') ?>'+$(this).val(),{},function(res){
				if (res < 7) {
					$('#param-types-edit').hide('fast');
					$('#devCreditEdit').val(res);
					$('#devParamEdit').removeAttr("required","required");
				} else {
					$('#param-types-edit').show('fast');
					$('#devParamEdit').html(res);
					$('#devParamEdit').attr("required","true");
				}
			});
		})

		$('#devParamEdit').change(function() {
			$.post('<?= base_url('dev-credit/') ?>' + $('#devProgramEdit').val() + '/' + $(this).val(), {}, function(res) {
				$('#devCreditEdit').val(res);
			})
		})

	});
</script>