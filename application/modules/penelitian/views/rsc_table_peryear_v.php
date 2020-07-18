<table class="table table-bordered" id="dt-wo-hd-2">
  <thead>
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Program</th>
      <th>Kegiatan</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($rscs as $rsc) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $rsc->judul ?></td>
        <td><?= $rsc->program ?></td>
        <td><?= $rsc->kegiatan ?></td>
        <td>
          <?= $rsc->attachment > 0 
              ? ($rsc->requirement != $rsc->attachment 
                  ? '<span class="badge bg-orange">Dokumen belum lengkap</span>' 
                  : '<span class="badge bg-green">Dokumen sudah lengkap</span>') 
              : '<span class="badge bg-default">Dokumen belum dilampirkan</span>'; ?>
        </td>
        <td width="60">
          <?php if ($rsc->attachment === $rsc->requirement) : ?>
            <button 
              style="cursor: text"
              type="button" 
              class="btn btn-sm bg-blue">
              <i class="fa fa-hourglass-2"></i> Waiting validation
            </button>
          <?php else : ?>
            <span data-toggle="tooltip" title="Lampirkan dokumen">
              <button 
                class="btn btn-sm bg-orange" 
                data-toggle="modal" 
                data-target="#myModal" 
                onclick="doc_uploads('<?= $rsc->key ?>','<?= $rsc->requirement.'-'.$rsc->attachment ?>')">
                <i class="fa fa-upload"></i> Unggah Bukti
              </button>
            </span>
          <?php endif; ?>
        </td>
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>

<script>
  $(document).ready(function () {
    $('#dt-wo-hd-2').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

  function doc_uploads(id, is_equal) {
    $('#content').load('<?= base_url('attach-doc/') ?>' + id + '/' + is_equal)
  }
</script>