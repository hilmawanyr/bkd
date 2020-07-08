<form role="form" action="<?= base_url('update-pengajaran/'.$id) ?>" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Ubah Data Pengajaran</h4>
  </div>
  <div class="modal-body">
      <div class="box-body">
        <?php foreach ($teachs as $value) : ?>
          <div class="form-group">
            <label for="komponen">Komponen</label>
            <input type="text" class="form-control" id="komponen" value="<?= $value->komponen ?>" readonly="">
            <input type="hidden" class="form-control" id="kode-komponen" value="<?= $value->kode_pengajaran ?>" name="kodekomponen">
          </div>
          <div class="form-group">
            <label for="param1"><?= $this->ajar->get_param_penelitian($value->param1_type)->nama ?></label>
            <input 
              name="param[]"
              type="text" 
              class="form-control params" 
              id="param1" 
              value="<?= $value->param1_value ?>"
              <?= get_teaching_param($value->param1_type)->tipe_nilai == 'NUMBER' ? "onkeypress=\"return isNumber(event)\"" : ''; ?>>
          </div>

          <?php if ($value->param2_type != '') : ?>
            <div class="form-group">
              <label for="param2"><?= $this->ajar->get_param_penelitian($value->param2_type)->nama ?></label>
              <input 
                name="param[]"
                type="text" 
                class="form-control params" 
                id="param2" 
                value="<?= $value->param2_value ?>"
                <?= get_teaching_param($value->param2_type)->tipe_nilai == 'NUMBER' ? "onkeypress=\"return isNumber(event)\"" : ''; ?>>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="sks">SKS</label>
            <input type="text" class="form-control" id="sks" name="sks" value="<?= $value->sks ?>" readonly="">
          </div>

        <?php endforeach; ?>
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
  </div>
</form>

<script>
  function edit(id) {
    $('#content').load('<?= base_url('ubah-pengajaran/') ?>' + id)
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }
  
</script>