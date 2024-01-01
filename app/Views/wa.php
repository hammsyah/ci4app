<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php if ($ulang == 1) { ?>

    <script>
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "http://localhost:8080/wa/blast", true);
        xhttp.send();

        window.setTimeout(function() {
            window.location.reload();
        }, 2000);
    </script>

<?php } ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h5> Tambah NOMOR WA BARU
                <a href="" class="btn btn-warning ml-3" data-toggle="modal" data-target="#uploadexcel">Upload Excel</a>
                <a href="<?= base_url('dokumen/uploadnomor.xlsx'); ?>" class="btn btn-primary ml-3">Download Template</a>
            </h5>
            <br>

            <form action="<?= base_url('wa/simpan'); ?>" method="post">
                <td class="col-lg-3 col-md-3 col-xs-3">WA Blast
                    <br>
                    <button type="submit" class="btn btn-primary "><i class="fa fa-envelope" aria-hidden="true"> SIMPAN </i></button>
                </td>
                <td>:</td>
                <!-- <td class="col-lg-7 col-md-7 col-xs-7"> -->
                <td class="col-lg-7 col-xs-7">
                    <textarea name="pesan" id="" cols="50" rows="3"> <?= $pesan['pesan']; ?> </textarea>
                </td>
            </form>

            <a href="<?= base_url('wa/blast'); ?>" class="btn btn-danger"> KIRIM BLAST </a>
            <a href="<?= base_url('wa/nolkan'); ?>" class="btn btn-warning"> NOLKAN </a>
            <a href="<?= base_url('wa/hapusall'); ?>" class="btn btn-danger"> HAPUS SEMUA DATA </a>

            <h1 class="mt-2">Daftar Nomor WA</h1>
            <?php if (session('sukses')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('sukses') ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nama</th>
                        <th scope="col">nomer WA</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1; ?>
                    <?php foreach ($datawa as $k) : ?>
                        <tr>
                            <th scope="row"><?= $n++; ?></th>
                            <td><?= $k['nama']; ?></td>
                            <td><?= $k['nomer']; ?></td>
                            <td><?= $k['alamat']; ?></td>
                            <td><?= $k['status']; ?></td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- Modal upload excel -->
<div class="modal fade" id="uploadexcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload NOMOR WA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('wa/importxcel'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Upload File Excel</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fileexcel">
                    </div>


                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>