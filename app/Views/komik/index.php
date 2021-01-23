<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <h1 class="mt-3"><?= $judultab; ?><a href="/komik/create" class="btn btn-primary btn-sm mb-1 mx-2">Tambah Komik</a></h1>
            </div>
            <?php if (session()->getFlashdata('pesan_tambah')) : ?>
                <div class="alert alert-success">
                    <strong>Berhasil, </strong>
                    <?= session()->getFlashdata('pesan_tambah'); ?>
                    <!-- <button class="close" data-dismiss="alert">&times;</button> -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- saparate -->
            <?php if (session()->getFlashdata('pesan_hapus')) : ?>
            <div class="alert alert-danger">
                <strong>Terhapus, </strong>
                <?= session()->getFlashdata('pesan_hapus'); ?>
                <!-- <button class="close" data-dismiss="alert">&times;</button> -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($komik as $kom) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $kom['sampul']; ?>" class="sampul" alt=""></td>
                            <td><?= $kom['judul']; ?></td>
                            <td><?= $kom['penulis']; ?></td>
                            <td><a href="<?= base_url('/komik/' . $kom['slug']); ?>" class="btn btn-success btn-sm">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>