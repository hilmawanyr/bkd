<table class="table table-bordered" id="dt-wo-hd-4">
  <thead>
    <tr>
      <th>No</th>
      <th>Jabatan</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($poss as $pos) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $pos->jabatan ?></td>
        <td style="vertical-align: middle;">
          <?= !is_null($pos->url) 
              ? '<a class="btn btn-xs bg-green" href="'.$pos->url.'" target="_blank">Dokumen telah dilampirkan <i class="fa fa-external-link"></i></a>'
              : '<a style="cursor: text" class="btn btn-xs btn-default">Dokumen belum dilampirkan</a>'; ?>
        </td>
        <td style="vertical-align: middle;">
          <?php if (!is_null($pos->url)) : ?>
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
                onclick="doc_uploads('<?= $pos->_key ?>')">
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
    $('#dt-wo-hd-4').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });
</script>