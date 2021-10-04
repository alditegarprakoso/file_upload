<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>File Upload</title>
</head>

<body>
    <div class="container mt-3">
        <h1>Form Upload</h1>
        <a href="<?= base_url() ?>" class="btn btn-secondary my-4">Kembali</a>
        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('home/add'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="formFile" class="form-label">File</label>
                        <input class="form-control" type="file" id="formFile" name="file_berkas">
                    </div>
                    <button class="btn btn-primary mt-5">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>