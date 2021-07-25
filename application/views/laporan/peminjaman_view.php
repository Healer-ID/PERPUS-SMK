<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                
				<!-- /.box-header -->
				<div class="box-body">
                    <br/>
					<div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                       
						<?php if($this->session->userdata('level') == 'Petugas'){ ?>
						<tbody>
                       
<div class="container">
    <br>
    <h4>Pencarian Data Berdasarkan Tanggal</h4>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">

        <div class="form-group">
            <label>Tanggal Awal</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
                <input id="tgl_mulai" placeholder="masukkan tanggal Awal" type="text" class="form-control datepicker" name="tgl_awal"  value="<?php if (isset($_POST['tgl_awal'])) echo $_POST['tgl_awal'];?>" >
            </div>
        </div>
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
                <input id="tgl_akhir" placeholder="masukkan tanggal Akhir" type="text" class="form-control datepicker" name="tgl_akhir" value="<?php if (isset($_POST['tgl_akhir'])) echo $_POST['tgl_akhir'];?>">
            </div>
        </div>

        <script type="text/javascript">
            $(function(){
                $(".datepicker").datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: false,
                });
                $("#tgl_mulai").on('changeDate', function(selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $("#tgl_akhir").datepicker('setStartDate', startDate);
                    if($("#tgl_mulai").val() > $("#tgl_akhir").val()){
                        $("#tgl_akhir").val($("#tgl_mulai").val());
                    }
                });
            });
        </script>
    <div class="form-group">
        <input type="submit" class="btn btn-info" value="Cari">
         <input type="submit" class="btn btn-info" value="Print">
    </div>
    </form>

    <table class="table table-bordered table-hover">
        <br>
        <thead>
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
        </thead>
        <?php if($this->session->userdata('level') == 'Petugas'){ ?>
                        <tbody>
                        <?php 
                            $no=1;
                            foreach($pinjam->result_array() as $isi){
                                    $anggota_id = $isi['anggota_id'];
                                    $ang = $this->db->query("SELECT * FROM tbl_login WHERE anggota_id = '$anggota_id'")->row();

                                    $pinjam_id = $isi['pinjam_id'];
                                    $denda = $this->db->query("SELECT * FROM tbl_denda WHERE pinjam_id = '$pinjam_id'");
                                    $total_denda = $denda->row();
                        ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $isi['pinjam_id'];?></td>
                                <td><?= $isi['anggota_id'];?></td>
                                <td><?= $ang->nama;?></td>
                                <td><?= $isi['tgl_pinjam'];?></td>
                                <td><?= $isi['tgl_balik'];?></td>
                                <td><center><?= $isi['status'];?></center></td>
                                <td>
                                    <?php 
                                        if($isi['tgl_kembali'] == '0')
                                        {
                                            echo '<p style="color:red;text-align:center;">belum dikembalikan</p>';
                                        }else{
                                            echo $isi['tgl_kembali'];
                                        }
                                    
                                    ?>
                                </td>
                                <td>
                                    <center>
                                    <?php 
                                        if($isi['status'] == 'Di Kembalikan')
                                        {
                                            echo $this->M_Admin->rp($total_denda->denda);
                                        }else{
                                            $jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();         
                                            $date1 = date('Ymd');
                                            $date2 = preg_replace('/[^0-9]/','',$isi['tgl_balik']);
                                            $diff = $date1 - $date2;
                                            /*  $datetime1 = new DateTime($date1);
                                                $datetime2 = new DateTime($date2);
                                                $difference = $datetime1->diff($datetime2); */
                                            // echo $difference->days;
                                            if($diff > 0 )
                                            {
                                                echo $diff.' hari';
                                                $dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda','stat','Aktif'); 
                                                echo '<p style="color:red;font-size:18px;">
                                                '.$this->M_Admin->rp($jml*($dd->harga_denda*abs($diff))).'
                                                </p><small style="color:#333;">* Untuk '.$jml.' Buku</small>';
                                            }else{
                                                echo '<p style="color:green;text-align:center;">
                                                Tidak Ada Denda</p>';
                                            }
                                                
                                        }
                                    ?>
                                    </center>
                                </td>
                                   
                            </tr>
                        <?php $no++;}?>
                        </tbody>
                    <?php }elseif($this->session->userdata('level') == 'Anggota'){?>
                        <tbody>
                        <?php $no=1;
                            foreach($pinjam->result_array() as $isi){
                                    $anggota_id = $isi['anggota_id'];
                                    $ang = $this->db->query("SELECT * FROM tbl_login WHERE anggota_id = '$anggota_id'")->row();

                                    $pinjam_id = $isi['pinjam_id'];
                                    $denda = $this->db->query("SELECT * FROM tbl_denda WHERE pinjam_id = '$pinjam_id'");            
                                
                                    if($this->session->userdata('ses_id') == $ang->id_login){
                        ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $isi['pinjam_id'];?></td>
                                <td><?= $isi['anggota_id'];?></td>
                                <td><?= $ang->nama;?></td>
                                <td><?= $isi['tgl_pinjam'];?></td>
                                <td><?= $isi['tgl_balik'];?></td>
                                <td><center><?= $isi['status'];?></center></td>
                                <td>
                                    <?php 
                                        if($isi['tgl_kembali'] == '0')
                                        {
                                            echo '<p style="color:red;text-align:center;">belum dikembalikan</p>';
                                        }else{
                                            echo $isi['tgl_kembali'];
                                        }
                                    
                                    ?>
                                </td>
                                <td>
                                    <center>
                                    <?php 

                                        $jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();         
                                        if($denda->num_rows() > 0){
                                            $s = $denda->row();
                                            echo $this->M_Admin->rp($s->denda);
                                        }else{
                                            $date1 = date('Ymd');
                                            $date2 = preg_replace('/[^0-9]/','',$isi['tgl_balik']);
                                            $diff = $date2 - $date1;

                                            if($diff >= 0 )
                                            {
                                                echo '<p style="color:green;text-align:center;">
                                                Tidak Ada Denda</p>';
                                            }else{
                                                $dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda','stat','Aktif'); 
                                                echo '<p style="color:red;font-size:18px;">'.$this->M_Admin->rp($jml*($dd->harga_denda*abs($diff))).' 
                                                </p><small style="color:#333;">* Untuk '.$jml.' Buku</small>';
                                            }
                                        }
                                    ?>
                                    </center>
                                </td>
                                   
                            </tr>
                        <?php $no++;}}?>
                        </tbody>
                    <?php }?>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    
        <br><br>
						</tbody>
				
					<?php }?>
					</table>
			    </div>
			    </div>
	        </div>
    	</div>
    </div>
</section>
</div>