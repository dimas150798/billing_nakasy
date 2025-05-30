<?php
if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">

                    <div class="card-body">

                        <!-- Header -->
                        <div class="row">
                            <div class="col-12">

                                <!-- Form Upload -->
                                <div class="p-3 mb-3 bg-white border rounded shadow-sm">
                                    <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/Data_Pelanggan/C_Import_Pelanggan/ImportExcel') ?>">

                                        <div class="row mt-2 justify-content-center">
                                            <div class="col-sm-5">
                                                <label for="nama_customer" class="form-label" style="font-weight: bold;"> Import File : <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="upload_excel" id="nama_customer" value="" required>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" name="submit" value="Submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>

                        <!-- Tabel -->

                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Riwayat Import Excel
                        </div>
                        <div class="card-body">
                            <table id="datatablesdekstop" class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Nama</th>
                                        <th width="30%">Tanggal Import</th>
                                        <th width="5%" class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($DataExcel as $data) :
                                    ?>

                                        <tr>
                                            <td>
                                                <?php echo $no++ ?>
                                            </td>

                                            <td>
                                                <?php echo $data['file_name'] ?>
                                            </td>


                                            <td>
                                                <?php echo changeDateFormat('d-m-Y / H:i:s', $data['created_at']) ?>
                                            </td>


                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                                                        Opsi
                                                    </button>
                                                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                                                        <a class="dropdown-item text-black" href="<?php echo base_url() ?>assets/uploads/imports/<?php echo $data['file_name'] ?>"><i class=" bi bi-pencil-square"></i> Download</a>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>