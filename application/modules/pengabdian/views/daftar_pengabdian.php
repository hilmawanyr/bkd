<h4 class="page-header">
  <i class="fa fa-file-text"></i> Daftar Pengabdian Tahun Akademik <?= active_year()->nama_tahun ?>
</h4>

<div class="row" style="margin-bottom: 20px">
  <div class="col-md-12 col-xs-12">
    <select name="" class="form-control" id="year-change">
      <option value="" disabled="">Pilih tahun akademik</option>
      <?php foreach ($years as $year) : ?>
        <option 
          value="<?= $year->kode ?>"
          <?= $year->kode == active_year()->kode_tahun ? 'selected=""' : '' ?> >
          <?= $year->tahun_akademik ?>
        </option>
      <?php endforeach; ?>
    </select>  
  </div>
</div>

<span id="table-content">
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
    </tbody>
  </table>
</span>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" id="content">
      
    </div>
  </div>
</div>

<script>
  function edit(id) {
    $('#content').load('<?= base_url('dev-edit/') ?>' + id);
  }

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });

    $('#year-change').change(function() {
      $.post('<?= base_url('dev-by-year/') ?>' + $(this).val(), function(res) {
        $('#table-content').html(res);
      })
    })
  })
</script>