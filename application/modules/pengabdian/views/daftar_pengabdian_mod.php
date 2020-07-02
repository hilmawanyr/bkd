<table id="example2" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Jenis</th>
      <th>Program</th>
      <th>Peran/Ketegori</th>
      <th>SKS</th>
      <th width="90" style="text-align: center;">Aksi</th>
    </tr>
  </thead>
  <tbody>

    <?php if (count($dev) > 0) : ?>
      <?php $no=1; foreach ($dev as $devs) : ?>
        <tr>
          <td><?= $no ?></td>
          <td><?= $devs->abdimas ?></td>
          <td><?= $devs->program ?></td>
          <td><?= empty($devs->nama) ? '-' : $devs->nama ?></td>
          <td><?= $devs->sks ?></td>
          <td>
            <span data-toggle="tooltip" title="Edit">
              <button 
                class="btn btn-sm bg-purple" 
                data-toggle="modal" 
                data-target="#myModal"
                onclick="edit(<?= $devs->id ?>)">
                <i class="fa fa-pencil"></i>
              </button>
            </span>
            <a 
              href="<?= base_url('remove-dev/'.$devs->id) ?>" 
              onclick="return confirm('Anda yakin ingin menghapus data ini?')" 
              class="btn btn-sm bg-navy" 
              data-toggle="tooltip" 
              title="Delete">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        </tr>
      <?php $no++; endforeach; ?>

    <?php else : ?>
      <td colspan="6"><i>No data available</i></td>
    <?php endif; ?>
    
  </tbody>
</table>

<script>
  $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
</script>