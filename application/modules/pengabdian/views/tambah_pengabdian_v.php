<?php $this->load->view('template/message_alert'); ?>
<br>
<form class="form-horizontal" onsubmit="submitForm(event)" id="temporaryform2">
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Jenis Pengabdian</label>
		<div class="col-md-10">
			<select class="form-control" name="devotion" id="devotion" required="">
				<option disabled selected value="">-- Pilih Jenis --</option>
				<?php foreach ($devotionType as $devotion) {
					echo '<option value="'.$devotion->kode.'">'.$devotion->nama.'</option>  ';
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Program Pengabdian</label>
		<div class="col-md-10">
			<select class="form-control" name="devProgram" id="devProgram" required="">
				<option disabled selected value="">-- Pilih Program --</option>
				
			</select>
		</div>
	</div>

	<div class="form-group" id="param-types">
		<label class="col-sm-2 control-label">Peran</label>
		<div class="col-md-10">
			<select class="form-control" name="devParam" id="devParam" required="">
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
				id="devCredit" 
				readonly="" 
				name="devCredit" 
				class="form-control" />
		</div>
	</div>
	
	<center>
		<button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Tambah Pengabdian</button>
	</center>
</form>

<hr>

<form class="form-horizontal" action="<?= base_url('add-dev') ?>" method="post">
	<h3><i class="icon icon-list"></i> Daftar Pengabdian</h3>
	<br>
	<table id="example99" class="table table-bordered table-striped">
		<thead>
	      	<tr> 
		        <th>No</th>
		        <th>Jenis Pengabdian</th>
		        <th>Program Pengabdian</th>
		        <th>Tahun Akademik</th>
		        <th>Peran / Kategori</th>
		        <th>Beban SKS</th>
		        <th width="80">Aksi</th>
	      	</tr>
	  	</thead>
	  	<tbody id="appearHeres">
	      	<tr id="toRemoves">
	        	<td colspan="7"><i>No data available</i></td>
	      	</tr>
	  	</tbody>
	</table>
	<div class="form-actions">
		<input class="btn btn-primary" type="submit" id="submitBtn" value="Submit" disabled="">
	</div>
</form>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		// get kegiatn program
		$('#devotion').change(function(){
			$.post('<?= base_url('dev-program/') ?>'+$(this).val(),{},function(get){
				$('#devProgram').html(get);
			});

			// reset credit column every devotion type changed
			$('#devCredit').val('');
			$('#devParam').val('');
		});

		$('#devProgram').change(function() {
			$.post('<?= base_url('dev-param/') ?>'+$(this).val(),{},function(res){
				if (res < 7) {
					$('#param-types').hide('fast');
					$('#devCredit').val(res);
					$('#devParam').removeAttr("required","required");
				} else {
					$('#param-types').show('fast');
					$('#devParam').html(res);
					$('#devParam').attr("required","true");
				}
			});
		})

		$('#devParam').change(function() {
			$.post('<?= base_url('dev-credit/') ?>' + $('#devProgram').val() + '/' + $(this).val(), {}, function(res) {
				$('#devCredit').val(res);
			})
		})

	})

	function getTable() {
		$.post('<?= base_url('load-dev-temp'); ?>', function(data) {
		  	$('#appearHeres').html(data);
		});
	}

	function submitForm(e) {
		if ($('#devProgram,#devotion').val() === '') {
			alert('Tidak boleh ada kolom yang dikosongkan!');
			return;
		}

		$('#submitBtn').removeAttr('disabled')
		if ($('.additionalRows').length === 3) {
        	$('#submitBtn').attr("disabled","");
        }

		$.ajax({
			type: 'POST',
			url: '<?= base_url('dev-temp-data'); ?>',
			data: $('#temporaryform2').serialize(),
			error: function (xhr, ajaxOption, thrownError) {
				return false;
			},
			success: function () {
				getTable();
				$('#toRemoves').hide();
				$('#devotion,#devProgram,#devParam,#devCredit').val('');
			}
		});
		e.preventDefault();
	};

	function rmData(id) {
	    $.ajax({
	        type: 'POST',
	        url: '<?= base_url('remove-temp-dev/');?>'+id,
	        error: function (xhr, ajaxOptions, thrownError) {
	            return false;           
	        },
	        success: function () {
	            getTable();
	            if ($('.additionalRows').length === 1) {
	            	$('#submitBtn').attr("disabled","");
	            } else {
	            	$('#submitBtn').removeAttr("disabled");
	            }
	        }
	    });
	}
</script>