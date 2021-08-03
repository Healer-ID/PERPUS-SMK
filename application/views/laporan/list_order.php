<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .row {
            padding: 20px;
        }
    </style>
</head>

<body>
   <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <br />
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table" width="100%">

                            <a href="<?= base_url('index.php/order/export') ?>" class="btn btn-primary" target="_blank">Export</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>pinjam_id</th>
                                    <th>anggota_id</th>
                                    <th>buku_id</th>
                                    <th>tgl_kembali</th>
                                    <th>tgl_balik</th>
                                    <th>lama_pinjam</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($orders->result_array() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['pinjam_id'] ?></td>
                                        <td><?= $data['anggota_id'] ?></td>
                                        <td><?= $data['buku_id'] ?></td>
                                        <td><?= $data['tgl_kembali'] ?></td>
                                        <td><?= $data['tgl_balik'] ?></td>
                                        <td><?= $data['lama_pinjam'] ?></td>
                                        <td><?= $data['status'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Script -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>