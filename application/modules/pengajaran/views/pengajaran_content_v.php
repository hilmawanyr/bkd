<?php $this->load->view('template/message_alert'); ?>
<h3>
	<i class="fa fa-plus-square"></i> Buat Pengajaran Tambahan Dosen <?= active_year()->nama_tahun ?>
	<a class="btn btn-default pull-right" href="<?= base_url('daftar-pengajaran') ?>">
		<i class="fa fa-eye"></i> Daftar Pengajaran Tambahan
	</a>
	<a class="btn btn-default pull-right" data-toggle="modal" href="#myInfo" style="margin-right: 5px"><i class="fa fa-info"></i> Informasi</a>
</h3>
<br>
<div class="form-horizontal">
	<div class="row">
		<div class="col-xs-4">
			<select name="component" id="component" class="form-control">
				<option disabled="" selected="" value="">-- Pilih Komponen Kegiatan --</option>
				<?php foreach ($teaching as $teach) { ?>
					<option value="<?= $teach->id.'-'.$teach->kode_pengajaran ?>"><?= $teach->komponen ?></option>
				<?php } ?>
			</select>
		</div>

		<span id="param-show-here"></span>
		
		<div class="col-lg-2 col-xs-2" style="margin-left:-16px">
			<div class="input-group">
				<input 
					type="text" 
					name="" 
					readonly="" 
					value="" 
					id="credit" 
					class="form-control" 
					placeholder="SKS">
				<span class="input-group-addon add-on">SKS</span>
			</div>
		</div>

		<button 
			class="btn btn-success" 
			onclick="addTask()" 
			style="margin-bottom: 1px; margin-left:-4px">
			<i class="fa fa-plus"></i>
		</button>
	</div>

	<form action="<?= base_url('pengajaran/add_additional_teaching'); ?>" method="post">
		<div id="appendHere">
			
		</div>
		<br>
		<center>
			<button disabled="" type="submit" id="btnComp" class="btn btn-primary">
				Submit
			</button>
		</center>
	</form>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Penugasan tahun akademik <?= active_year()->nama_tahun ?></h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped" id="tableTeaching">
                    <thead>
                        <tr> 
                        	<th>No</th>
                            <th>Komponen penugasan</th>
                            <th>Beban SKS</th>
                        </tr>
                    </thead>
                    <tbody id="contentTable">
                    </tbody>
				</table>
			</div>
			<div class="modal-footer">
				<!-- <a class="btn btn-primary" href="<?= base_url('akademik/beban_kinerja_dosen/teaching_detail') ?>">Detail</a> -->
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="myInfo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Informasi Pengajaran Tambahan Dosen</h4>
			</div>
			<div class="modal-body">
				<ul>
					<li>Rumus penghitungan untuk pengajaran tambahan berupa <b>Pembimbing utama skripsi/tesis (maks. 10 lulusan per semester)</b> dihitung dengan rumus <b class="label label-info">(n / 10) x beban SKS</b>, dimana <b>n</b> adalah jumlah mahasiswa.</li>
					<li>Rumus penghitungan untuk pengajaran tambahan berupa <b>Ketua penguji skripsi/tesis (4 lulusan per semester)</b> dihitung dengan rumus <b class="label label-info">(n / 4) x beban SKS</b>, dimana <b>n</b> adalah sidang.</li>
					<li>Rumus penghitungan untuk pengajaran tambahan berupa <b>Pembimbing akademik</b> dihitung dengan rumus <b class="label label-info">(n / 30) x beban SKS</b>, dimana <b>n</b> adalah jumlah mahasiswa dan <b>30</b> merupakan jumlah ideal mahasiswa bimbingan.</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// set SKS by component
		$('#component').change(function(){
			$.get('<?= base_url() ?>pengajaran/set_sks_teaching/'+$(this).val().split("-")[0],{},function(get){
				$('#credit').val(get);
			});
		});

		// set teaching params
		$('#component').change(function(){
			$('#param-show-here').empty();
			$.get('<?= base_url() ?>pengajaran/set_teaching_param/'+$(this).val().split("-")[0],{},function(res){
				var response = JSON.parse(res);
				response.forEach(function (arg) {
					$('#param-show-here').append(arg);
				});
			});
		});
	})

	var counter = 1;
	// fungsi tambah row
	function addTask()
	{
		if ($('#component').val() === null) {
			alert('Pilih salah satu komponen terlebih dahulu!'); 
			return;
		}

		// var param        = parseInt($('#param').val());
		var componentVal = $('#component').val().split("-")[1];
		var paramCode    = document.querySelectorAll('.paramCode');
		var paramName    = document.querySelectorAll('.add-on');
		var paramVal     = document.querySelectorAll('.params');
		var credit       = parseFloat($('#credit').val());

		console.log(paramVal);
		counter++;
		var cols = "";
		// init div
		cols += '<div id="component_'+counter+'" class="comps row" style="margin-top:5px">';

		// judul
		cols += '<div class="col-xs-4">'
		cols += `<input 
					type="text" 
					name="" 
					style="margin-right:3px" 
					class="form-control" 
					value="`+$('#component option:selected').text()+`" 
					readonly=""/>`;
		cols += '<input type="hidden" name="components[]" style="margin-right:3px" value="'+componentVal+'" readonly=""/>';
		cols += '</div>';

		// param
		for(var i = 0; i < paramVal.length; i++){
			cols += '<span class=" col-xs-3" style="margin-left:-16px">'
			cols += '<div class="input-group">';
			cols += '<span class="input-group-addon add-on">'+paramName[i].innerHTML+'</span>';
			cols += '<input type="hidden" name="paramCode['+componentVal+']['+i+'][]" value="'+paramCode[i].value+'">'
			cols += `<input 
						type="text" 
						name="paramValue[`+componentVal+`][`+i+`][]" 
						class="form-control" 
						value="`+paramVal[i].value+`" 
						readonly=""/>`;
			cols += '</div></span>';
		}


		// formula to count final credit
		if (componentVal === 'COM1' || componentVal === 'COM2') {
			var finalcredit = parseFloat((paramVal[0].value / 10) * credit);
		} else if (componentVal === 'COM5') {
			var finalcredit = parseFloat((paramVal[0].value / 4) * credit);
		} else if (componentVal === 'COM7') {
			var finalcredit = parseFloat((paramVal[0].value / 30) * credit);
		} else {
			var finalcredit = credit;
		}

		// sks
		cols += '<span class=" col-xs-2" style="margin-left:-16px">'
		cols += '<div class="input-group">';
		cols += '<input type="text" name="sks[]" class="form-control" value="'+(Math.round(finalcredit*100)/100)+'" readonly=""/>';
		cols += '<span class="input-group-addon add-on">SKS</span>';
		cols += '</div></span>';

		// button
		cols += '<button class="btn btn-danger" onclick="delResearch(\'component_'+counter+'\',\'comps\',\'btnComp\')" style="margin-bottom: 1px; margin-left:-4px"><i class="fa fa-trash"></i></button>';
		cols += '</div>';
	
		$('#appendHere').append(cols);
		$('#credit,.params').val('');
		$('#component option:first').prop('selected',true);

		// delete prop disabled in #btnRsc if form != null
		if ($('.comps').length !== 0) {
			$("#btnComp").removeAttr("disabled");
		}
	}

	// fungsi delete row
	function delResearch(skidrow,skiddy,btnSbm)
	{
		$("#"+skidrow).remove();

		// disable the button if input == 0
		if ($("."+skiddy).length === 0) {
			$("#"+btnSbm).attr("disabled","");
		}
	}

	$('#myModal').on('hidden', function () {
		$('.teachList').remove();
	});

	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>