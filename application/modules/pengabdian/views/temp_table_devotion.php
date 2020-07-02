<?php 
	$team = $this->session->userdata('devotions');
	$c    = $this->session->userdata('numberof_array');
	$no   = 1;
	for ($i=0; $i < $c; $i++) { 
		if (isset($team[$i])) { ?>
			
			<tr class="additionalRows">
				<input type="hidden" name="type[]" value="<?= $team[$i]['type']; ?>">
				<input type="hidden" name="tahunakademik[]" value="<?= $team[$i]['tahunakademik']; ?>">
				<input type="hidden" name="program[]" value="<?= $team[$i]['program']; ?>">
				<input type="hidden" name="param[]" value="<?= $team[$i]['param']; ?>">
				<input type="hidden" name="sks[]" value="<?= $team[$i]['sks']; ?>">

				<td><?= $no; ?></td>
				<td><?= $this->dev->devotion_type( $team[$i]['type'] ); ?></td>
				<td><?= $this->dev->devotion_program( $team[$i]['program'] )->program; ?></td>
				<td><?= active_year()->nama_tahun; ?></td>
				<td><?= $this->dev->get_dev_param($team[$i]['param']); ?></td>
				<td><?= $team[$i]['sks']; ?></td>
				<td>
					<a class="btn btn-danger btn-sm" onclick="rmData(<?= $i ?>)"data-toogle="tooltip" title="Hapus">
						<i class="fa fa-trash"></i>
					</a>
				</td>	
			</tr>

		<?php }
		$no++;
	}
?>

<script>
	$('[data-toggle="tooltip"]').tooltip();
</script>