<section class="content-header">
  <h1>
    Laporan Penelitian
    <small>Buat laporan penelitian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);">Laporan Penelitian</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <?php $this->load->view('template/message_alert'); ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-file-text-o"></i>
          <h3 class="box-title">Daftar Penelitian</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-horizontal">
            
            <div class="form-group">
              <label for="tahunakademik" class="control-label col-sm-2">Tahun Akademik</label>
              <div class="col-sm-8">
                <select name="" id="tahunakademik" class="form-control">
                  <option value="" selected="" disabled=""></option>
                  <?php foreach ($years as $year) : ?>
                    <option 
                      <?= active_year()->kode_tahun == $year->kode ? 'selected=""' : '' ?>
                      value="<?= $year->kode ?>">
                      <?= $year->tahun_akademik ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default" data-target="#myInfo" data-toggle="modal">
                  <i class="fa fa-lightbulb-o"></i> Petunjuk</button>
              </div>
            </div>
            
            <span id="content-table">
              <table class="table table-bordered" id="dt-wo-hd">
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
                      <td style="vertical-align: middle;">
                        <?= $rsc->attachment > 0 
                            ? ($rsc->requirement != $rsc->attachment 
                                ? '<span style="cursor: text" class="btn btn-xs bg-orange">Dokumen belum lengkap</span>' 
                                : '<span style="cursor: text" class="btn btn-xs bg-green">Dokumen sudah lengkap</span>') 
                            : '<span style="cursor: text" class="btn btn-xs btn-default">Dokumen belum dilampirkan</span>'; ?>
                      </td>
                      <td style="vertical-align: middle;">
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
            </span>

          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" id="content">
      
    </div>
  </div>
</div>

<div id="myInfo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Petujuk penggunaan</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
  $('#tahunakademik').change(function () {
    $.get('<?= base_url('penelitian-claim-pertahun/') ?>' + $(this).val(), {}, function(res) {
      $('#content-table').html(res);
    })
  })

  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' })
  })

  function doc_uploads(id, is_equal) {
    $('#content').load('<?= base_url('attach-doc/') ?>' + id + '/' + is_equal)
  }

  function attach(code) {
    $('#code').val(code);
  }
</script>