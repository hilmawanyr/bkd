<h4 class="page-header"><i class="fa fa-file-text"></i> Daftar Mengajar Tahun Akademik <?= active_year()->nama_tahun ?></h4>
<table id="example2" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Mata Kuliah</th>
      <th>Mata Kuliah</th>
      <th>SKS</th>
      <th>Hari Mengajar</th>
      <th>Jam Mulai</th>
      <th>Jam Selesai</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach ($teaching as $teach) : ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $teach->kode_mk ?></td>
        <td><?= $teach->nama_mk ?></td>
        <td><?= $teach->sks ?></td>
        <td><?= $teach->hari ?></td>
        <td><?= $teach->jam_mulai ?></td>
        <td><?= $teach->jam_selesai ?></td>
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>