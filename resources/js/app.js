window._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.notifySwal = (isSuccess, message) => {
    Swal.fire({
        icon: isSuccess ? "success" : "error",
        title: isSuccess ? "Berhasil" : "Gagal",
        text: message,
        timer: isSuccess ? 4000 : 6200,
    });
};

window.showLoading = (isLoading) => {
    if (isLoading) {
        Swal.fire({
            title: "Mohon tunggu",
            text: "Data sedang diproses",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    } else {
        Swal.close();
    }
};

window.deleteData = (id, url) => {
    Swal.fire({
        title: "Yakin hapus data ?",
        text: "Data yang telah dihapus tidak dapat dipulihkan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Konfirmasi",
        cancelButtonText: "Batal",
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                url,
                { id: id, _method: "DELETE", _token: window._token },
                function (result) {
                    if (result.status == true) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Terjadi kesalahan",
                        });
                    }
                }
            );
        }
    });
};

window.changeYear = (element) => {
    $.post(
        `${window.location.origin}/dashboard/change-year`,
        { _token: window._token, year_id: element.value },
        function (response) {
            if (response.status == true) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Pergantian tahun berhasil",
                });
                setTimeout(() => {
                    window.location.reload(true);
                }, 1100);
            } else {
                alert("Terjadi kesalahan");
            }
        }
    );
};
