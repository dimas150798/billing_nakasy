// Kwitansi
function Kwitansi(parameter_id) {
    // Ambil URL dari elemen data-url
    var kwitansiUrl = document.getElementById('kwitansi-url').getAttribute('data-url');

    window.location.href = kwitansiUrl + '/' + parameter_id;
}