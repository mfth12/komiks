<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3"><?= $judultab; ?></h2>
            <?php //echo $validation->listErrors();d
            ?>
            <form action="<?= base_url('/komik/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <!-- form this -->
                <div class="form-group row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                        <div id="invalid_judul" class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="penulis" name="penulis" value="<?= old('penulis'); ?>">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= old('penerbit'); ?>">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="sampul" name="sampul" value="<?= old('sampul'); ?>">
                    </div>
                </div>

                <!-- button -->
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-8">  
                        <a href="/komik" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </div>
            </form>
            <!-- end -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>