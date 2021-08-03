<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan</title>
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    .line-title{
      border: 0;
      border-style: inset;
      border-top: 1px solid #000;
    }
  </style>
</head>
<body>
  <img src="assets/img/logo.jpg" style="position: absolute; width: 60px; height: auto;">
  <table style="width: 100%;">
    <tr>
      <td align="center">
        <span style="line-height: 1.6; font-weight: bold;">
          SEKOLAH TINGGI ILMU KOMPUTER DAN INFORMATIKA
          <br>MAKASSAR INDONESIA
        </span>
      </td>
    </tr>
  </table>

  <hr class="line-title"> 
  <p align="center">
    LAPORAN DATA MAHASISWA <br>
    <b>Angkatan 2018</b>
  </p>
  <table class="table table-bordered">
    <tr>
      <th>No</th>
                                                                        <th>No Pinjam</th>
                                                                        <th>ID Anggota</th>
                                                                        <th>Nama</th>
                                                                        <th>Tanggal Pinjam</th>
                                                                        <th>Tanggal Balik</th>
                                                                        <th style="width:10%">Status</th>
                                                                        <th>Tanggal Kembali</th>
                                                                        <th>Denda</th>
    </tr>
   <?php if ($this->session->userdata('level') == 'Petugas') { ?>
                                                                    <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($pinjam->result_array() as $isi) {
                                                                            $anggota_id = $isi['anggota_id'];
                                                                            $ang = $this->db->query("SELECT * FROM tbl_login WHERE anggota_id = '$anggota_id'")->row();

                                                                            $pinjam_id = $isi['pinjam_id'];
                                                                            $denda = $this->db->query("SELECT * FROM tbl_denda WHERE pinjam_id = '$pinjam_id'");
                                                                            $total_denda = $denda->row();
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= $no; ?></td>
                                                                                <td><?= $isi['pinjam_id']; ?></td>
                                                                                <td><?= $isi['anggota_id']; ?></td>
                                                                                <td><?= $ang->nama; ?></td>
                                                                                <td><?= $isi['tgl_pinjam']; ?></td>
                                                                                <td><?= $isi['tgl_balik']; ?></td>
                                                                                <td>
                                                                                    <center><?= $isi['status']; ?></center>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($isi['tgl_kembali'] == '0') {
                                                                                        echo '<p style="color:red;text-align:center;">belum dikembalikan</p>';
                                                                                    } else {
                                                                                        echo $isi['tgl_kembali'];
                                                                                    }

                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <center>
                                                                                        <?php
                                                                                        if ($isi['status'] == 'Di Kembalikan') {
                                                                                            echo $this->M_Admin->rp($total_denda->denda);
                                                                                        } else {
                                                                                            $jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();
                                                                                            $date1 = date('Ymd');
                                                                                            $date2 = preg_replace('/[^0-9]/', '', $isi['tgl_balik']);
                                                                                            $diff = $date1 - $date2;
                                                                                            /*  $datetime1 = new DateTime($date1);
                                                $datetime2 = new DateTime($date2);
                                                $difference = $datetime1->diff($datetime2); */
                                                                                            // echo $difference->days;
                                                                                            if ($diff > 0) {
                                                                                                echo $diff . ' hari';
                                                                                                $dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda', 'stat', 'Aktif');
                                                                                                echo '<p style="color:red;font-size:18px;">
                                                ' . $this->M_Admin->rp($jml * ($dd->harga_denda * abs($diff))) . '
                                                </p><small style="color:#333;">* Untuk ' . $jml . ' Buku</small>';
                                                                                            } else {
                                                                                                echo '<p style="color:green;text-align:center;">
                                                Tidak Ada Denda</p>';
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </center>
                                                                                </td>

                                                                            </tr>
                                                                        <?php $no++;
                                                                        } ?>
                                                                    </tbody>
                                                                <?php } elseif ($this->session->userdata('level') == 'Anggota') { ?>
                                                                    <tbody>
                                                                        <?php $no = 1;
                                                                        foreach ($pinjam->result_array() as $isi) {
                                                                            $anggota_id = $isi['anggota_id'];
                                                                            $ang = $this->db->query("SELECT * FROM tbl_login WHERE anggota_id = '$anggota_id'")->row();

                                                                            $pinjam_id = $isi['pinjam_id'];
                                                                            $denda = $this->db->query("SELECT * FROM tbl_denda WHERE pinjam_id = '$pinjam_id'");

                                                                            if ($this->session->userdata('ses_id') == $ang->id_login) {
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?= $no; ?></td>
                                                                                    <td><?= $isi['pinjam_id']; ?></td>
                                                                                    <td><?= $isi['anggota_id']; ?></td>
                                                                                    <td><?= $ang->nama; ?></td>
                                                                                    <td><?= $isi['tgl_pinjam']; ?></td>
                                                                                    <td><?= $isi['tgl_balik']; ?></td>
                                                                                    <td>
                                                                                        <center><?= $isi['status']; ?></center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        if ($isi['tgl_kembali'] == '0') {
                                                                                            echo '<p style="color:red;text-align:center;">belum dikembalikan</p>';
                                                                                        } else {
                                                                                            echo $isi['tgl_kembali'];
                                                                                        }

                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <center>
                                                                                            <?php

                                                                                            $jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();
                                                                                            if ($denda->num_rows() > 0) {
                                                                                                $s = $denda->row();
                                                                                                echo $this->M_Admin->rp($s->denda);
                                                                                            } else {
                                                                                                $date1 = date('Ymd');
                                                                                                $date2 = preg_replace('/[^0-9]/', '', $isi['tgl_balik']);
                                                                                                $diff = $date2 - $date1;

                                                                                                if ($diff >= 0) {
                                                                                                    echo '<p style="color:green;text-align:center;">
                                                Tidak Ada Denda</p>';
                                                                                                } else {
                                                                                                    $dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda', 'stat', 'Aktif');
                                                                                                    echo '<p style="color:red;font-size:18px;">' . $this->M_Admin->rp($jml * ($dd->harga_denda * abs($diff))) . ' 
                                                </p><small style="color:#333;">* Untuk ' . $jml . ' Buku</small>';
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </center>
                                                                                    </td>

                                                                                </tr>
                                                                        <?php $no++;
                                                                            }
                                                                        } ?>
                                                                    </tbody>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br><br>
                                    </tbody>

                                <?php } ?>
                            </table>
                        </div>
                    </div>
  </table>

</body>
</html>