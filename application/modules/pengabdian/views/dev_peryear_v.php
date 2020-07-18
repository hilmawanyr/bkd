<table class="table table-bordered" id="dt-wo-hd-3">
  <thead>
    <tr>
      <th>No</th>
      <th>Jenis</th>
      <th>Program</th>
      <th>Peran</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($devs as $dev) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $dev->nama ?></td>
        <td><?= $dev->program ?></td>
        <td><?= $dev->peran ?></td>
        <td style="vertical-align: middle;">
          <?= !is_null($dev->url) 
              ? '<a class="btn btn-xs bg-green" href="'.$dev->url.'" target="_blank">Dokumen telah dilampirkan <i class="fa fa-external-link"></i></a>'
              : '<a style="cursor: text" class="btn btn-xs btn-default">Dokumen belum dilampirkan</a>'; ?>
        </td>
        <td style="vertical-align: middle;">
          <?php if (!is_null($dev->url)) : ?>
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
                onclick="doc_uploads('<?= $dev->_key ?>')">
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
    $('#dt-wo-hd-3').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  });

  function doc_uploads(id, is_equal) {
    $('#content').load('<?= base_url('attach-dev-doc/') ?>' + id)
  }
</script>