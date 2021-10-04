<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>File Upload</title>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Form Edit</h1>
        <a href="<?= base_url('/'); ?>" class="btn btn-secondary my-3">Kembali</a>

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('home/update'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" autofocus required value="<?= $data['nama']; ?>">
                </div>
                <div class="mb-3">
                    <label for="file">File</label>
                    <div class="custom-file">
                        <input class="form-control" name="file_berkas" type="file" value="<?= $data['file']; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <label for="file"><?= $data['file']; ?></label>
                    </div>
                    <?php
                    if (substr($data['file'], -3) == "pdf") {
                    ?>
                        <div id="viewpdf" style="height: 500px;"></div>
                    <?php
                    } else {
                    ?>
                        <img src="<?= base_url() ?>assets/file/<?= $data['file'] ?>" style="width: 50%; height: auto;">
                    <?php
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary form-control">Edit Data</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pdfobject.min.js"></script>
    <script>
        let file = "<?= $data['file'] ?>";
        if (file.substring(file.length - 3) == "pdf") {
            PDFObject.embed('<?= base_url() ?>assets/file/' + file, $("#viewpdf"));
        }
    </script>
</body>

</html>