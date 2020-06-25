<?php $this->load->view('template/message_alert'); ?>
<br>
<form class="form-horizontal" id="temporaryform" method="post">
	
	<div class="form-group">
        <label class="col-sm-2 control-label" for="judul">Judul Penelitian</label>
        <div class="col-md-10">
        	<input 
				type="text" 
				name="rscTitle" 
				id="rscTitle" 
				placeholder="Masukan judul penelitian" 
				required="" 
				class="form-control" />	
        </div>			
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Program Penelitian</label>
		<div class="col-md-10">
			<select class="form-control" name="rscProgram" id="rscProgram" required="">
				<option disabled selected value="">-- Pilih Program --</option>
				<?php foreach ($programs as $program) {
					echo '<option value="'.$program->kode_program.'">'.$program->program.'</option>  ';
				} ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Kegiatan</label>
		<div class="col-md-10">
			<select class="form-control" name="rscActivity" id="rscActivity" required="">
				<option disabled="" selected="" value="">-- Pilih Kegiatan --</option>
				
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" id="param-type">Peran</label>
		<div class="col-md-10">
			<select class="form-control" name="rscParam" id="rscParam" required="">
				<option disabled="" selected="" value="">-- Pilih Peran --</option>
				
			</select>
		</div>
	</div>

	<div class="form-group" id="member-column">
        <label class="col-sm-2 control-label" for="member">Jumlah Anggota</label>
        <div class="col-md-10">
        	<input 
        		onkeypress="return isNumber(event)" 
        		maxlength="2" 
				type="text" 
				name="member" 
				id="member" 
				placeholder="Masukan jumlah anggota"  
				class="form-control" />	
        </div>			
	</div>
	
	<span id="member-area"></span>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Beban SKS</label>
		<div class="col-md-10">
			<input 
				type="text" 
				value="" 
				id="rscCredit" 
				readonly="" 
				name="rscCredit" 
				class="form-control" />
		</div>
	</div>
	
	<center>
		<button class="btn btn-success" id="addRsc"><i class="fa fa-plus"></i> Tambah Penelitian</button>
	</center>
</form>

<hr>

<form class="form-horizontal" action="<?= base_url('tambah-penelitian'); ?>" method="post">
	<h3><i class="icon icon-list"></i> Daftar Penelitian</h3>
	<br>
	<table id="example99" class="table table-bordered table-striped">
		<thead>
			<tr> 
				<th>No</th>
				<th>Judul Penelitian</th>
				<th>Tahun Akademik</th>
				<th>Program</th>
				<th>Kegiatan</th>
				<th>Peran/Progress</th>
				<th>Jumlah Anggota</th>
				<th>Durasi/Level</th>
				<th>Beban SKS</th>
				<th width="60">Hapus</th>
			</tr>
		</thead>
		<tbody id="appearHere">
			<tr id="toRemove">
				<td colspan="8"><i>No data available</i></td>
			</tr>
		</tbody>
	</table>
	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="Submit" id="submitBtn" disabled="">
	</div>
</form>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('#member-column').hide();
		
		// get activity program
		$('#rscProgram').change(function(){
			$.post('<?= base_url('program-penelitian/') ?>'+$(this).val(),{},function(get){
				$('#rscActivity').html(get);
				$('#member-area').empty();
			});
		});

		// get param activity
		$('#rscActivity').change(function() {
			$.post('<?= base_url('parameter-penelitian/') ?>' + $(this).val(), {}, function(get) {
				var parseData = JSON.parse(get);
				$('#param-type').html(parseData.param);
				$('#rscParam').html(parseData.options);
			})

			$.post('<?= base_url('set-duration-category/') ?>' + $(this).val(), {}, function (arg) {
				$('#member-area').html(arg);
			})
		})

		// set SKS by param and activity program
		$('#rscProgram,#rscActivity,#rscParam').change(function(){
			$.post('<?= base_url('sks-penelitian/') ?>'+$('#rscActivity').val()+'/'+$('#rscParam').val(),{},function(get){
				$('#rscCredit').val(get);

				if ($('#param-type').text() === 'Peran' && 
					(
						$('#rscParam :selected').text() !== 'Anggota' && 
						$('#rscParam :selected').text().includes('Tambahan') === false)
					) 
				{ 
					$('#member-column').show('fast');
					$('#member').attr('required','required');
				} else {
					$('#member-column').hide('fast');
					$('#member').removeAttr('required');
				} 
			});
		});
	})

	function getTable() {
		$.post('<?= base_url('temp-rsc-table'); ?>', function(data) {
		  	$('#appearHere').html(data);
		});
	}

	$(function () {
		$('#addRsc').click(function (e) {

			var title = document.getElementById('rscTitle').value;
			var program = document.getElementById('rscProgram').value;
			var activity = document.getElementById('rscActivity').value;
			var param = document.getElementById('rscParam').value;
			var member = document.getElementById('member').value;
			var duration = document.getElementById('duration').value;
			var credit = document.getElementById('rscCredit').value;

			if (program === null || activity === null || param === null || title === '' || duration === '' || credit === '') {
				alert('Tidak boleh ada kolom yang dikosongkan!');
				return;
			}

			if (param === 'P-RSC1' || param === 'P-WRT1') {
				if (member === '') {
					alert('Tidak boleh ada kolom yang dikosongkan!');
					return;
				}
			}

			$('#submitBtn').removeAttr('disabled')

			$.ajax({
				type: 'POST',
				url: '<?= base_url('temp-research'); ?>',
				data: $('#temporaryform').serialize(),
				error: function (xhr, ajaxOption, thrownError) {
					return false;
				},
				success: function () {
					getTable();
					$('#toRemove').hide();
					$('#rscTitle,#rscProgram,#rscActivity,#rscParam,#rscCredit,#member,#duration').val('');
				}
			});
			e.preventDefault();
		});
	});

	function rmData(id) {
	    $.ajax({
	        type: 'POST',
	        url: '<?= base_url('rm-temp-row/');?>'+id,
	        error: function (xhr, ajaxOptions, thrownError) {
	            return false;           
	        },
	        success: function () {
	            getTable();
	            if ($('.additionalRow').length === 1) {
	            	$('#submitBtn').attr("disabled","");
	            }
	        }
	    });
	}

	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>