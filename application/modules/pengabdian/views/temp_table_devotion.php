<?php 
	$team = $this->session->userdata('devotions');
	$c    = $this->session->userdata('numberof_array');
	$no   = 1;
	for ($i=0; $i < $c; $i++) { 
		if (isset($team[$i])) { ?>
			
			<tr class="additionalRows">
				<input type="hidden" name="tahunakademik[]" value="<?= active_year()->kode_tahun; ?>">
				<input type="hidden" name="program[]" value="<?= explode('x',$team[$i]['program'])[0]; ?>">
				<input type="hidden" name="param[]" value="<?= $team[$i]['param']; ?>">
				<input type="hidden" name="sks[]" value="<?= $team[$i]['sks']; ?>">

				<td><?= $no; ?></td>
				<td><?= $this->dev->devotion_type( explode('-',$team[$i]['type'])[0] ); ?></td>
				<td><?= $this->dev->devotion_program( explode('x',$team[$i]['program'])[0] ); ?></td>
				<td><?= active_year()->nama_tahun; ?></td>
				<td><?= param_research($team[$i]['param']); ?></td>
				<td><?= $team[$i]['sks']; ?></td>
				<td><a class="btn btn-danger btn-sm" onclick="rmData(<?= $i ?>)"><i class="icon icon-remove"></i></a></td>	
			</tr>

		<?php }
		$no++;
	}
?>