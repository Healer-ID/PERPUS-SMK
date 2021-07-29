<html>

<head>
    <title>Cetak PDF</title>
    <style>
        .table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 630px;
        }

        .table th {
            padding: 5px;
        }

        .table td {
            word-wrap: break-word;
            width: 20%;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h4 style="margin-bottom: 5px;">Data Transaksi</h4>
    <?php echo $label ?>
    <table class="table" border="1" width="100%" style="margin-top: 10px;">
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
        <?php
        if (empty($transaksi)) { // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        } else { // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            foreach ($transaksi as $data) { // Looping hasil data transaksi
                $tgl = date('d-m-Y', strtotime($data->tgl)); // Ubah format tanggal jadi dd-mm-yyyy
                echo "<tr>";
                echo "<td style='width: 80px;'>" . $tgl_masuk . "</td>";
                echo "<td style='width: 80px;'>" . $buku_id . "</td>";
                echo "<td style='width: 100px;'>" . $data->isbn . "</td>";
                echo "<td style='width: 300px;'>" . $data->title . "</td>";
                echo "<td style='width: 100px;'>" . $data->penerbit . "</td>";
                echo "<td style='width: 100px;'>" . $data->pengarang . "</td>";
                echo "<td style='width: 60px;'>" . $data->thn_buku . "</td>";
                echo "<td style='width: 40px;'>" . $data->jml . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>

</html>