<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Laporan PDF Plus Filter Periode Tanggal</title>
    <!-- Include file CSS Bootstrap -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Include library Bootstrap Datepicker -->
    <link href="<?php echo base_url('assets/libraries/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
    <!-- Include File jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div style="padding: 15px;">
        <h3 style="margin-top: 0;"><b>Laporan PDF Plus Filter Periode Tanggal</b></h3>
        <hr />
        <form method="get" action="<?php echo base_url('index.php/Laporanbuku/index') ?>">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Filter Tanggal</label>
                        <div class="input-group">
                            <input type="text" name="tgl_awal" value="<?= @$_GET['tgl_awal'] ?>" class="form-control tgl_awal" placeholder="Tanggal Awal" autocomplete="off">
                            <span class="input-group-addon">s/d</span>
                            <input type="text" name="tgl_akhir" value="<?= @$_GET['tgl_akhir'] ?>" class="form-control tgl_akhir" placeholder="Tanggal Akhir" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="filter" value="true" class="btn btn-primary">TAMPILKAN</button>
            <?php
            if(isset($_GET['filter'])) // Jika user mengisi filter tanggal, maka munculkan tombol untuk reset filter
                echo '<a href="'.base_url('index.php/Laporanbuku/index').'" class="btn btn-default">RESET</a>';
            ?>
        </form>
        <hr />
        <h4 style="margin-bottom: 5px;"><b>Data Buku</b></h4>
        <?php echo $label ?><br />
        <div style="margin-top: 5px;">
            <a href="<?php echo $url_cetak ?>">CETAK PDF</a>
        </div>
        <div class="table-responsive" style="margin-top: 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <th>ID Buku</th>
                        <th>ISBN</th>
                        <th>Judul Buku</th>
                        <th>Penerbit</th>
                        <th>Pengarang</th>
                        <th>Tahun Buku</th>
                        <th>Stok Buku</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(empty($transaksi)){ // Jika data tidak ada
                        echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
                    }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
                        foreach($transaksi as $data){ // Looping hasil data transaksi
                            $tgl_masuk = date('d-m-Y', strtotime($data->tgl_masuk)); // Ubah format tanggal jadi dd-mm-yyyy
                            echo "<tr>";
                            echo "<td>".$tgl_masuk."</td>";
                            echo "<td>".$data->buku_id."</td>";
                            echo "<td>".$data->isbn."</td>";
                            echo "<td>".$data->title."</td>";
                            echo "<td>".$data->penerbit."</td>";
                            echo "<td>".$data->pengarang."</td>";
                            echo "<td>".$data->thn_buku."</td>";
                            echo "<td>".$data->jml."</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Include File JS Bootstrap -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <!-- Include library Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Include File JS Custom (untuk fungsi Datepicker) -->
    <script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
    <script>
    $(document).ready(function(){
        setDateRangePicker(".tgl_awal", ".tgl_akhir")
    })
    </script>
</body>
</html>