<table class="table table-bordered" id="dt-wo-hd-1">
  <thead>
    <tr>
      <th>No</th>
      <th>Komponen</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($teaches as $teach) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $teach->komponen ?></td>

        <td id="column-flag-<?= $teach->kode_transaksi ?>" style="vertical-align: middle;">
          <?php if (is_null($teach->tsc_rep) && is_null($teach->tsc_url)) {
            echo '<a class="btn btn-xs btn-default" style="cursor: text">Unclaimed</a>';
          } elseif (!is_null($teach->tsc_rep) && is_null($teach->tsc_url)) {
            echo '<a class="btn btn-xs bg-orange" style="cursor: text">Claimed</a>';
          } elseif (!is_null($teach->tsc_rep) && !is_null($teach->tsc_url)) {
            echo '<a class="btn btn-xs bg-green" target="_blank" href="'.$teach->tsc_url.'">Document attached <i class="fa fa-external-link"></i></a>';
          } ?>
        </td>

        <td id="column-action-<?= $teach->kode_transaksi ?>" width="60">
          <?php if (is_null($teach->tsc_rep) && is_null($teach->tsc_url)) : ?>
            <button 
              type="button" 
              class="btn btn-sm bg-olive"
              onclick="claim('<?= $teach->kode_transaksi ?>')">
              <i class="fa fa-plus"></i> Claim
            </button>
          <?php elseif (!is_null($teach->tsc_rep) && is_null($teach->tsc_url)) : ?>
            <button 
              type="button" 
              class="btn btn-sm bg-green"
              data-target="#myModal"
              data-toggle="modal"
              onclick="attach('<?= $teach->kode_transaksi ?>')">
              <i class="fa fa-paperclip"></i> Attach Document
            </button>
          <?php elseif (!is_null($teach->tsc_rep) && !is_null($teach->tsc_url)) : ?>
            <button 
              style="cursor: text"
              type="button" 
              class="btn btn-sm bg-blue">
              <i class="fa fa-hourglass-2"></i> Waiting validation
            </button>
          <?php endif; ?>
        </td>

      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>

<script>
  $(document).ready(function () {
    $('#dt-wo-hd-1').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>