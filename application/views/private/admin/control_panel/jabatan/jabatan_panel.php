<!-- Start header -->
<?php $this->load->view('_templates/private/admin/head'); ?>
<!-- End header -->


<!-- Start Sections -->

<?php echo form_open('administrator/jabatan/insert', "class='form-horizontal'"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label"> Nama Jabatan </label>
    <input name="nama_jabatan" type="text" class="col-sm-10 form-control" placeholder="Nama Jabatan" style="width: 200px;"> 
    <input type="submit" class="btn btn-sm btn-primary" value="Tambah" style="margin-left: 25px;">
  </div>

<?php echo form_close(); ?>


<table class="table table-striped">
  <thead>
    <td>No</td>
    <td>Nama Jabatan</td>
    <td>&nbsp;</td>
  </thead>
  <tbody>

    <?php $no = 1; ?>
    <?php foreach ($jabatan as $n): ?>

    <tr>
      <td> <?php echo $no; ?> </td>
      <td> <?php echo $n['nama_jabatan']; ?> </td>
      <td>
        <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit-<?php echo $n['id_jabatan']; ?>" > <span> <i class="fa fa-pencil"></i></span>  Edit </button>
        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-<?php echo $n['id_jabatan']; ?>" > <span> <i class="fa fa-trash-o"></i></span>  Delete </button>
      </td>
    </tr>

    <?php $no++; ?>

    <!-- modal -->
    <?php require 'modals/modal_update.php'; ?>
    <?php require 'modals/modal_delete.php'; ?>

    <?php endforeach; ?>

  </tbody>
</table>
  
    
    







<!-- End Sections -->
<!-- Start Footer -->
<?php $this->load->view('_templates/private/admin/footer'); ?>
<!-- End Footer