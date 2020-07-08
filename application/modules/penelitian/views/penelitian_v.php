<section class="content-header">
  <h1>
    Penelitian
    <small>Kelola data penelitian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);">Penelitian</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#add-component" data-toggle="tab">Tambah data</a></li>
          <li><a href="#review-component" data-toggle="tab" onclick="load_page()">Daftar Penelitian</a></li>
        </ul>
        <div class="tab-content">
          <!-- <button class="btn btn-default pull-right">Daftar Pengajaran Tambahan</button> -->
          <!-- Font Awesome Icons -->
          <div class="tab-pane active" id="add-component">
            <section id="new">
              <?php $this->load->view('tambah_penelitian_v'); ?>
            </section>
          </div>

          <div class="tab-pane" id="review-component">
            <section id="review-content">
              
            </section>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
  function load_page () {
    $('#review-content').load('<?= base_url('penelitian/daftar_penelitian') ?>')
  }
</script>