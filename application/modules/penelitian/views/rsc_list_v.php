<h4 class="page-header"><i class="fa fa-file-text"></i> Daftar Penelitian Tahun Akademik <?= active_year()->nama_tahun ?></h4>
<table id="example2" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Program</th>
      <th>Kegiatan</th>
      <th width="160" style="text-align: center;">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($rsc_list as $rsc) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $rsc->judul ?></td>
        <td><?= $rsc->program ?></td>
        <td><?= $rsc->kegiatan ?></td>
        <td>
          <span data-toggle="tooltip" title="Detail">
            <button 
              class="btn btn-sm bg-olive" 
              data-toggle="modal" 
              data-target="#myModal" 
              onclick="load_detail(<?= $rsc->id ?>)">
              <i class="fa fa-list"></i>
            </button>
          </span>
          <span data-toggle="tooltip" title="Edit">
            <button 
              class="btn btn-sm bg-purple" 
              data-toggle="modal" 
              data-target="#myModal"
              onclick="edit(<?= $rsc->id ?>)">
              <i class="fa fa-pencil"></i>
            </button>
          </span>
          <a 
            href="<?= base_url('remove-rsc/'.$rsc->key) ?>" 
            onclick="return confirm('Anda yakin ingin menghapus data ini?')" 
            class="btn btn-sm bg-navy" 
            data-toggle="tooltip" 
            title="Delete">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" id="content">
      
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
  });

  function load_detail(id) {
    $('#content').load('<?= base_url('rsc-detail/') ?>' + id)
  }

  function edit(id) {
    $('#content').load('<?= base_url('edit/') ?>' + id)
  }
</script>