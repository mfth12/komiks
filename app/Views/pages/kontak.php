<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-3">Hubungi Kami</h1>
            <p style="text-align: justify">Layanan pelanggan buka 7x24 jam</p>
            <?php foreach ($alamat as $man): ?>
                <ul>
                    <li><?= $man['tipe']; ?></li>
                    <li><?= $man['alamat']; ?></li>
                    <li><?= $man['kota']; ?></li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>