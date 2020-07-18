<section class="content-header">
  <h1>
    Laporan Pengajaran
    <small>Buat laporan pengajaran</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);">Laporan Pengajaran</a></li>
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
          <h3 class="box-title">Daftar Pengajaran</h3>
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
                          echo '<a class="btn btn-xs bg-green" href="'.$teach->tsc_url.'">Document attached <i class="fa fa-external-link"></i></a>';
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
                            data-target="#myModal"
                            data-toggle="modal"
                            class="btn btn-sm bg-green"
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

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lampirkan Link Dokumen Bukti</h4>
      </div>
      <form action="<?= base_url('attach-teach-evidence') ?>" method="post" onsubmit="return confirm('Link yang telah diunggah tidak dapat diubah, pastikan link tersebut telah benar! Lanjutkan pengunggahan?')" class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <label for="" class="control-label col-sm-2">URL</label>
            <div class="col-sm-10">
              <input type="text" name="link" class="form-control" required="">
              <input type="hidden" id="code" value="" name="code">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
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
        <p>Fitur Laporan Pengajaran merupakan fitur yang digunakan untuk membuat laporan dari data <b>rencana pengajaran tambahan</b> yang telah dibuat sebelumnya. Maka untuk menggunakan fitur ini Anda <u>diharuskan</u> untuk mengisi rencana pengajaran tambahan terlebih dahulu.</p>
        <p>Pada dasarnya setiap data pengajaran tambahan memiliki <b><i>flag (status)</i> Unclaimed</b>. Yang kemudian Anda harus <b>Claim</b> terlebih dahulu untuk menyatakan bahwa Anda sebagai pelaksana komponen pengajaran tersebut. Jika Anda telah melakukan <b>Claim</b> kemudian Anda diharuskan untuk melampirkan berkas bukti dalam bentuk <i>link</i> yang menyatakan Anda sebagai pelaksana komponen pengajaran tambahan tersebut.</p>
        <p>Setiap komponen pengajaran tambahan memiliki <b><i>flag (status)</i></b> tersendiri yang masing-masingnya memiliki informasi yang berbeda-beda. Terdapat tiga jenis <b><i>flag</i></b> yang tersedia:</p>
        <ul>
          <li><b>Unclaim</b>, yang berarti pengajaran hanya baru dibuat perencanaanya</li>
          <li><b>Claimed</b>, yang berarti pengajaran diakui keabsahannya oleh anda</li>
          <li><b>Document Attached</b>, yang berarti Anda telah melampirkan bukti bahwa pengajaran yang Anda <i>claim</i> memang sah.</li>
        </ul>
        <p>Jika ketiga proses tersebut telah dilaksanakan maka Anda hanya tinggal menunggu validasi yang dilakukan oleh GPM dan SPM hingga BKD Anda dinyatakan sah oleh Wakil Rektor I.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
  $('#tahunakademik').change(function () {
    $.get('<?= base_url('pengajaran-claim-pertahun/') ?>' + $(this).val(), {}, function(res) {
      $('#content-table').html(res);
    })
  })

  function claim(arg) {
    $.ajax({
      url: '<?= base_url('claim-pengajaran/') ?>' + arg,
      method: 'POST',
      beforeSend: function() {
        $('#column-action-'+arg).html(`<img src="<?= base_url('assets/img/spiner2.gif') ?>" width="20%" />`)
      },
      success: function(res) {
        if (res === '1') {
          $.get('<?= base_url('claim-flag/') ?>' + arg, function(resp) {
            $('#column-flag-'+arg).html(resp)
          });

          $('#column-action-'+arg).html(`
              <button 
                type="button" 
                class="btn btn-sm bg-green"
                data-target="#myModal"
                data-toggle="modal"
                onclick="attach('${arg}')">
                <i class="fa fa-paperclip"></i> Attach Document
              </button> 
            `)
        } else {
          $('#column-action-'+arg).html(`
            <button 
              type="button" 
              class="btn btn-sm bg-olive"
              onclick="claim('${arg}')">
              <i class="fa fa-plus"></i> Claim
            </button>
            `)
        }
      }
    })
  }

  function attach(code) {
    $('#code').val(code);
  }
</script>