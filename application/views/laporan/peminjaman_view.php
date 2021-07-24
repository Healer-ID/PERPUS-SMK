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