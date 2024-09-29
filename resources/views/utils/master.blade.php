<script>
    function formatRupiah(angka, prefix) {
        // Convert angka ke string dan hapus tanda negatif
        let numberString = angka.toString().replace(/[^,\d]/g, ''),
            split = numberString.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // Tambahkan titik jika ada ribuan
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
