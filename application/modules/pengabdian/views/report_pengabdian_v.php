<section class="content-header">
  <h1>
    Laporan Pengabdian
    <small>Buat laporan pengabdian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);">Laporan Pengabdian</a></li>
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
          <h3 class="box-title">Daftar Pengabdian</h3>
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
        <h4 class="modal-title">Petujuk Fitur</h4>
      </div>
      <div class="modal-body">
        <p>Daftar pengabdian yang muncul pada halaman ini merupakan data pengabdian yang Anda telah <i>input</i> sebelumnya di menu <code>Rencana > pengabdian</code>. Pada menu ini Anda diharuskan untuk melampirkan bukti pengabdian berupa <b>link</b> atau <b>URL</b> dimana lokasi berkas bukti pengabdian Anda diunggah. Aplikasi akan memberikan keterangan berupa:</p>
        <ul>
          <li>Dokumen belum dilampirkan, dan</li>
          <li>Dokumen sudah lengkap</li>
        </ul>
        <p>Yang mana jika dokumen sudah lengkap maka tombol pada kolom <b>aksi</b> akan berubah menjadi berwarna biru dan bertuliskan <b>Waiting validation</b> yang artinya dokumen bukti pengabdian Anda sedang dalam proses verifikasi oleh jajaran LPM (GPM dan SPM).</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
  $('#tahunakademik').change(function () {
    $.get('<?= base_url('pengabdian-pertahun/') ?>' + $(this).val(), {}, function(res) {
      $('#content-table').html(res);
    })
  })

  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' })
  })

  function doc_uploads(id, is_equal) {
    $('#content').load('<?= base_url('attach-dev-doc/') ?>' + id)
  }
</script>