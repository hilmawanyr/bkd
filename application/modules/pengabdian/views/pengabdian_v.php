<section class="content-header">
  <h1>
    Pengabdian
    <small>Kelola data pengabdian</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);" onclick="load_page">Pengabdian</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#add-component" data-toggle="tab">Tambah data</a></li>
          <li><a href="#review-component" data-toggle="tab" onclick="load_page()">Daftar Pengabdian</a></li>
        </ul>
        <div class="tab-content">

          <div class="tab-pane active" id="add-component">
            <section id="new">
              <?php $this->load->view('tambah_pengabdian_v'); ?>
            </section>
          </div>

          <div class="tab-pane" id="review-component">
            <section id="review-content">
              <center>
                <img src="<?= base_url('assets/img/loading.gif') ?>" style="width: 30%" />
              </center>
            </section>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
  function load_page () {
    $('#review-content').load('<?= base_url('load-dev-list') ?>')
  }
</script>