// Datatables AJAX
$(document).ready(function() {
    var url = $('#data-url').data('url');  // Ambil URL dari data-url div

    $('#mytable').DataTable({
        "autoFill": true,
        "pagingType": 'numbers',
        "searching": true,
        "paging": true,
        "stateSave": true,
        "processing": true,
        "serverside": true,
        "ajax": {
            "url": url,  // Gunakan URL yang sudah diambil
        },
    });
});

// Edit Data Sweetalert2
function Edit_Data(parameter_id) {
    // Ambil URL dari elemen data-url
    var editUrl = document.getElementById('edit-url').getAttribute('data-url');
    
    Swal.fire({
        title: 'Yakin Melakukan Edit Data ?',
        text: "Data yang diedit tidak akan kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Edit Data!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gabungkan URL dan parameter_id
            window.location.href = editUrl + '/' + parameter_id;
        }
    });
}

// Delete Data Sweetalert2
function Delete_Data(parameter_id) {
    // Ambil URL dari elemen data-url
    var deleteUrl = document.getElementById('delete-url').getAttribute('data-url');
    
    Swal.fire({
        title: 'Yakin Melakukan Hapus Data ?',
        text: "Data yang di hapus tidak akan kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gabungkan URL dan parameter_id
            window.location.href = deleteUrl + '/' + parameter_id;
        }
    });
}

// Terminated Data Sweetalert2
function Terminated_Data(parameter_id) {
    // Ambil URL dari elemen data-url
    var deleteUrl = document.getElementById('terminated-url').getAttribute('data-url');
    
    Swal.fire({
        title: 'Yakin Melakukan Terminated Pelanggan ?',
        text: "Data yang di terminated tidak akan kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Terminated Data!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gabungkan URL dan parameter_id
            window.location.href = deleteUrl + '/' + parameter_id;
        }
    });
}

// WA Data kirim 
function WA_Data(parameter_id) {
    // Ambil URL dari elemen data-url
    var waUrl = document.getElementById('wa-url').getAttribute('data-url');

    window.open(waUrl + '/' + parameter_id, '_blank');
}

// Pembayaran Pelanggan
function Pembayaran(parameter_id) {
    // Ambil URL dari elemen data-url
    var pembayaranUrl = document.getElementById('pembayaran-url').getAttribute('data-url');

    window.location.href = pembayaranUrl + '/' + parameter_id;
}

// Aktifkan pelanggan terminasi
function Aktif_Pelanggan(parameter_id) {
    // Ambil URL dari elemen data-url
    var aktifUrl = document.getElementById('aktif-url').getAttribute('data-url');

    window.location.href = aktifUrl + '/' + parameter_id;
}
// Initialize Select2 for nama_paket
$('#nama_paket').each(function() {
    $(this).select2({
        placeholder: 'Pilih Paket :',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for nama_sales
$('#nama_sales').each(function() {
    $(this).select2({
        placeholder: 'Pilih Sales / Penagih :',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for nama_area
$('#nama_area').each(function() {
    $(this).select2({
        placeholder: 'Pilih ODP / Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for nama_divisi
$('#id_jabatan').each(function() {
    $(this).select2({
        placeholder: 'Pilih Divisi:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for data rekening
$('#daerah_rekening').each(function() {
    $(this).select2({
        placeholder: 'Pilih Rekening:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for biaya_admin
$('#biaya_admin').each(function() {
    $(this).select2({
        placeholder: 'Pilih Biaya Admin:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for bulan
$('#bulan').each(function() {
    $(this).select2({
        placeholder: 'Pilih Nama Bulan:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for tahun
$('#tahun').each(function() {
    $(this).select2({
        placeholder: 'Pilih Tahun:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for nama_akses
$('#id_akses').each(function() {
    $(this).select2({
        placeholder: 'Pilih Akses:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for cluster
$('#cluster').each(function() {
    $(this).select2({
        placeholder: 'Pilih CLuster:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for email akun penagihan
$('#email_login_akun').each(function() {
    $(this).select2({
        placeholder: 'Pilih Email:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for area_1
$('#area_1').each(function() {
    $(this).select2({
        placeholder: 'Pilih Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for area_2
$('#area_2').each(function() {
    $(this).select2({
        placeholder: 'Pilih Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for area_3
$('#area_3').each(function() {
    $(this).select2({
        placeholder: 'Pilih Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for area_4
$('#area_4').each(function() {
    $(this).select2({
        placeholder: 'Pilih Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

// Initialize Select2 for area_5
$('#area_5').each(function() {
    $(this).select2({
        placeholder: 'Pilih Area:',
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});