<script>
    function handleErrorAjax(error) {
        if (error.status === 422) {
            let errors = error.responseJSON.errors;
            let errorMessages = '';

            // Iterasi semua error dan gabungkan menjadi satu pesan
            $.each(errors, function(key, value) {
                errorMessages += value.join('<br>') + '<br>';
            });

            Swal.fire({
                title: 'Gagal!',
                icon: 'error',
                html: errorMessages
            });
        } else {
            // Penanganan error lainnya
            Swal.fire({
                title: 'Oops...',
                text: 'Something went wrong!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }
</script>
