<table id="example3" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Komponen Penugasan</th>
      <th>SKS</th>
      <th style="width: 60px">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach ($data as $teach) : ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $teach->komponen ?></td>
        <td><?= number_format($teach->sks, 2) ?></td>
        <td>
          <span data-toggle="tooltip" title="ubah komponen">
            <button 
              type="button" 
              class="btn btn-warning" 
              data-toggle="modal" 
              data-target="#modal-edit"
              onclick="edit(<?= $teach->id ?>)">
              <i class="fa fa-pencil"></i>
            </button>
          </span>
          <a 
            onclick="return confirm('Yakin ingin menghapus data ini?')" 
            href="<?=  base_url('hapus-pengajaran/'.$teach->id) ?>" 
            class="btn btn-danger" 
            data-toggle="tooltip" 
            title="hapus">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>

<script>
  $(function () {
    $('#example3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  });
  
  function edit(id) {
    $('#content').load('<?= base_url('ubah-pengajaran/') ?>' + id)
  }

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
  });
</script>