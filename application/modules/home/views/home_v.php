<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Report of all activities</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-md-12 col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Rekap Rencana</h3>
        </div>
        <div class="box-body">
          
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-briefcase"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Pengajaran Tambahan: <strong id="total-ajar"></strong></span>
                <span class="info-box-text">Total SKS Pengajaran Tambahan: <strong id="sks-ajar"></strong></span>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-navy"><i class="glyphicon glyphicon-book"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Penelitian: <strong id="total-rsc"></strong></span>
                <span class="info-box-text">Total SKS Penelitian: <strong id="sks-rsc"></strong></span>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-heart-empty"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Pengabdian: <strong id="total-dev"></strong></span>
                <span class="info-box-text">Total SKS Pengabdian: <strong id="sks-dev"></strong></span>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-purple"><i class="glyphicon glyphicon-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jabatan Struktural</span>
                <span id="position" class="info-box-number"></span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

<script>
  $(document).ready(function () {

    // data pengajaran tambahan
    $.get('<?= base_url('home/data-ajar') ?>', function(res) {
      $('#total-ajar').html(res)
    });
    // sks pengajaran tambahan
    $.get('<?= base_url('home/sks-ajar') ?>', function(res) {
      $('#sks-ajar').html(res)
    });

    // data penelitian
    $.get('<?= base_url('home/data-penelitian') ?>', function(res) {
      $('#total-rsc').html(res)
    });
    // sks penelitian
    $.get('<?= base_url('home/sks-penelitian') ?>', function(res) {
      $('#sks-rsc').html(res)
    });

    // data abdimas
    $.get('<?= base_url('home/data-abdimas') ?>', function(res) {
      $('#total-dev').html(res)
    });
    // sks abdimas
    $.get('<?= base_url('home/sks-abdimas') ?>', function(res) {
      $('#sks-dev').html(res)
    });

    // data jabatan
    $.get('<?= base_url('home/data-jabatan') ?>', function(res) {
      $('#position').html(res)
    });

  });
</script>