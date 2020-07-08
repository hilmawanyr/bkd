<?php 
	$team = $this->session->userdata('research');
	$c    = $this->session->userdata('jml_array');
	$no   = 1;
	for ($i=0; $i < $c; $i++) { 
		if (isset($team[$i])) { ?>
			
			<tr class="additionalRow">
				<input type="hidden" name="tahunakademik[]" value="<?= active_year()->kode_tahun; ?>">
				<input type="hidden" name="judul[]" value="<?= $team[$i]['judul']; ?>">
				<input type="hidden" name="program[]" value="<?= $team[$i]['program']; ?>">
				<input type="hidden" name="kegiatan[]" value="<?= $team[$i]['kegiatan']; ?>">
				<input type="hidden" name="param[]" value="<?= $team[$i]['param']; ?>">
				<input type="hidden" name="member[]" value="<?= $team[$i]['member']; ?>">
				<input type="hidden" name="duration[]" value="<?= $team[$i]['duration']; ?>">
				<input type="hidden" name="sks[]" value="<?= $team[$i]['sks']; ?>">

				<td><?= $no; ?></td>
				<td><?= $team[$i]['judul']; ?></td>
				<td><?= active_year()->nama_tahun; ?></td>
				<td><?= $this->rsc->research_program($team[$i]['program']); ?></td>
				<td><?= $this->rsc->activity_research($team[$i]['kegiatan']); ?></td>
				<td><?= $this->rsc->param_research($team[$i]['param']); ?></td>
				<td><?= $team[$i]['member']; ?></td>
				<td>
					<?= strlen($team[$i]['duration']) > 1
						? $this->rsc->duration_detail($team[$i]['duration'])->jenis
						: $team[$i]['duration'].' smtr'; ?>
				</td>
				<td><?= $team[$i]['sks']; ?></td>
				<td><a class="btn btn-danger" onclick="rmData(<?= $i ?>)"><i class="fa fa-trash"></i></a></td>	
			</tr>

		<?php }
		$no++;
	}
?>