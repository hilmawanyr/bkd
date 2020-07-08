<section class="content-header">
  <h1>
    Formulir BKD
    <small>Cetak Formulir BKD</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=  base_url('/') ?>" data-toggle="tooltip" title="Kembali ke beranda">Dashboard</a></li>
    <li><a href="javascript:void(0);">Formulir BKD</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
        </div>
        <form action="<?= base_url('set-form-year') ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Tahun Akademik</label>
              <div class="col-sm-10">
                <select class="form-control" name="tahunakademik" required="">
                  <option value="" selected disabled></option>
                  <?php foreach ($years as $year) : ?>
                    <option value="<?= $year->kode ?>"><?= $year->tahun_akademik ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="container">
              <button type="submit" class="btn btn-primary">Preview</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  function load_page () {
    $('#review-content').load('<?= base_url('penelitian/daftar_penelitian') ?>')
  }
</script>
