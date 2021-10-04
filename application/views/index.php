<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.css">
    <title>File Upload</title>
</head>

<body>
    <div class="container mt-3">
        <h1>File Upload</h1>
        <a href="<?= base_url() ?>home/tambah" class="btn btn-primary my-4">Tambah Data</a>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <!-- TABEL -->
                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-12 mt-3">
                                <table class="table table-hover" id="mytable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>File</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalLihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit ID <span class="text-primary" id="id_file1"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_file" name="id" class="form-control" required>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" id="nama" name="nama" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10">
                            <input type="text" id="file" name="file" class="form-control" readonly>
                        </div>
                    </div>
                    <div id="viewpdf" style="width: 100%; height: 320px;"></div>
                    <img src="" alt="" id="viewimg" style="margin-top: -320px; width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <form id="hapus" method="post">
        <div class="modal fade" id="ModalHapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit ID <span class="text-primary" id="id_hapus"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_hapus2" name="id_hapus2" class="form-control" required>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" id="nama2" name="nama2" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="text" id="file2" name="file2" class="form-control" readonly>
                            </div>
                        </div>
                        <div id="viewpdf2" style="width: 100%; height: 320px;"></div>
                        <img src="" alt="" id="viewimg2" style="margin-top: -320px; width: 100%; height: auto;">
                        <strong>Anda yakin mau menghapus record ini ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" href="javascript:void(0);" onclick="reload_table()" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="konfirmasi" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <strong>Data Berhasil Dihapus</strong>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pdfobject.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            let today = new Date();

            $('#mytable').DataTable({
                "serverSide": true,
                "processing": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "<?php echo base_url('home/json') ?>",
                    type: 'post',
                    dataType: 'json'
                },
                "oLanguage": {
                    sSearch: "Cari :",
                    sLengthMenu: "Menampilkan _MENU_ data",
                    sInfo: "Menampilkan _START_ - _END_ dari total _TOTAL_ data",
                    sInfoEmpty: "Tidak ada data",
                    sProcessing: "Tungguin ya...",
                    oPaginate: {
                        sPrevious: "<<",
                        sNext: ">>"
                    }
                },
                "language": {
                    emptyTable: "-- TIDAK ADA DATA --"
                },
                "initComplete": function() {
                    var api = this.api();
                    $('#mytable_filter input')
                        .off('.DT')
                        .on('keyup.DT', function(e) {
                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                "createdRow": function(row, data, index) {
                    // menandai baris data yang baru di input selama 1 menit
                    let created_at = new Date(data['created_at']);
                    if ((today - created_at) <= 60000) {
                        $(row).css('background-color', '#D5F5E3');
                        $(row).css('color', 'black');
                    }
                },
                "columns": [{
                        data: "id",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nama",
                        class: "text-center",
                    },
                    {
                        data: "file",
                        class: "text-center",
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        orderable: false,
                    }
                ]
            });
        });

        function reload_table() {
            $('#mytable').DataTable().ajax.reload(null, false);
        }

        function clearError() {
            $('#id_file1').html('');
            $('#id_file').html('');
            $('#nama').html('');
            $('#file').html('');
            $('#viewpdf').html('');
            $('#viewimg').attr('src', '');
        }

        $('#mytable').on('click', '.lihat', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url("home/getDataById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "id": id
                },
                success: function(result) {
                    $("#id_file1").html(result.id);
                    $("#id_file").val(result.id);
                    $("#nama").val(result.nama);
                    $("#file").val(result.file);
                    let file = result.file;
                    if (file.substring(file.length - 3) == "pdf") {
                        PDFObject.embed('<?= base_url() ?>assets/file/' + result.file, $("#viewpdf"));
                    } else {
                        $("#viewimg").attr('src', '<?= base_url() ?>assets/file/' + result.file);
                    }
                },
                complete: function() {
                    $('#ModalLihat').modal('show');
                }
            });


        });

        $("#ModalLihat").on('hidden.bs.modal', function() {
            clearError();
        });

        $('#mytable').on('click', '.hapus', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url("home/getDataById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "id": id
                },
                success: function(result) {
                    $("#id_hapus").html(result.id);
                    $("#id_hapus2").val(result.id);
                    $("#nama2").val(result.nama);
                    $("#file2").val(result.file);
                    let file = result.file;
                    if (file.substring(file.length - 3) == "pdf") {
                        PDFObject.embed('<?= base_url() ?>assets/file/' + result.file, $("#viewpdf2"));
                    } else {
                        $("#viewimg2").attr('src', '<?= base_url() ?>assets/file/' + result.file);
                    }
                },
                complete: function() {
                    $('#ModalHapus').modal('show');
                }
            });
        });

        $("#hapus").submit(function(e) {
            e.preventDefault();
            // tangkap id dari input hidden
            let id = $('#id_hapus2').val();
            // delete data
            $.ajax({
                url: "<?php echo base_url("home/delete") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "id_hapus3": id
                },
                success: function(result) {
                    reload_table();
                    $('#ModalHapus').modal('hide');
                    $('#konfirmasi').modal('show');
                    setTimeout(function() {
                        $("#konfirmasi").modal('hide');
                    }, 1500);
                }
            });
        });
    </script>
</body>

</html>