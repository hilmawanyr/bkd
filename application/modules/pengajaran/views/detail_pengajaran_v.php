<section class="content-header">
  <h1>
    Daftar Pengajaran Tambahan
    <small>Kelola data pengajaran.</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li>
      <a href="<?=  base_url('pengajaran') ?>" data-toggle="tooltip" title="Kembali ke pengajaran">
        Pengajaran
      </a>
    </li>
    <li>
      <a href="javascript:void(0);">
        Daftar Pengajaran
      </a>
    </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <?php $this->load->view('template/message_alert'); ?>
          <div class="row">
            <div class="col-md-4 col-xs-12">
              <select class="form-control" id="year-choice">
                <option disabled="" selected="" value="">-- Pilih Tahun Ajaran --</option>
                <?php foreach ($year_list as $year) : ?>
                  <option 
                    value="<?= $year->kode ?>"
                    <?= active_year()->kode_tahun == $year->kode ? 'selected=""' : ''; ?>>
                    <?= $year->tahun_akademik ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <span id="table-show-here">
            <table id="example2" class="table table-bordered table-hover">
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
                    <td><?= $teach->sks ?></td>
                    <td>
                      <span data-toggle="tooltip" title="ubah">
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
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="modal-edit" class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content" id="content">
      
    </div>
  </div>
</div>

<script>
  function edit(id) {
    $('#content').load('<?= base_url('ubah-pengajaran/') ?>' + id)
  }

  $('#year-choice').change(function() {
    $('#table-show-here').load('<?= base_url('pengajaran-pertahun/') ?>' + $(this).val());
  });

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
  });
</script>