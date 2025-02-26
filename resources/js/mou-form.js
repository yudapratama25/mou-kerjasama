const isOldData = (document.getElementById('is-old-data').value == '1') ? true : false;
const isFormCreate = (document.getElementById('is-form-create').value == '1') ? true : false;
const nilaiKontrak = document.getElementById('nilai-kontrak');
const tfBank = document.getElementById('hasil-transfer-bank');
const selisih = document.getElementById('selisih');

if (isOldData && isFormCreate == false) {
    Dropzone.autoDiscover = false;
}

$(function() {
    ['letter_receipt_date','mou_start','mou_end','pks_start','pks_end','document_start','document_end'].forEach(value => {
        $(`input[name=${value}_display]`).datepicker({
            dateFormat: "d MM yy",
            altFormat: "yy-mm-dd",
            altField: `input[name=${value}_value]`,
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ],
            monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
        });
    });


    $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
        if (event.target.getAttribute('data-target') === '#tab-document') {
            $('#btn-submit').show();
        } else {
            $('#btn-submit').hide();
        }
    });

    $('#btn-submit').on('click', submitForm);

    if (!isFormCreate) {
        ketikNominal(nilaiKontrak);
        ketikNominal(tfBank);
    }
});

if (isOldData && isFormCreate == false) {
    var myDropZone = new Dropzone('.dropzone', {
        url: `${window.location.origin}/dashboard/mou/upload-mou-file`, // Set the url for your upload script location
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx",
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 10,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        autoQueue: false,
        headers: {
            'X-CSRF-TOKEN': window._token
        },
        success: function(file, response){
            if (response.status == true) {
                $("#form-mou").append(`<input type="hidden" name="files['${response.data.uniq}']" value="${response.data.name}" required>`);
                $("#form-mou").append(`<input type="hidden" name="files_size['${response.data.uniq}']" value="${response.data.size}" required>`);
            }
        },
        error: function(file, response) {
            console.log(file);
            console.log(response);
            if (typeof response === 'string') {
                notifySwal(false, `Error File ${file.name} - ${response}`);
                this.options.removedfile(file);
            } else {
                notifySwal(false, 'Terjadi Kesalahan Server : Gagal Upload File ' + file.name);
                throw new Error('Terjadi Kesalahan Server');
            }
        },
        removedfile: function (file) {
            // if (this.options.dictRemoveFile) {
            //     return Dropzone.confirm("Are You Sure to "+this.options.dictRemoveFile, function() {
            //         if (file.previewElement.id != "") {
            //             var name = file.previewElement.id;
            //         } else {
            //             var name = file.name;
            //         }

            //         $('#form-mou').find('input[value="' + file.name + '"]').remove();

            //         var fileRef;
            //         return (fileRef = file.previewElement) != null ?
            //         fileRef.parentNode.removeChild(file.previewElement) : void 0;
            //     });
            // }

            // var name = (file.previewElement.id != "") ? file.previewElement.id : file.name;

            if (file.previewElement != null && file.previewElement.parentNode != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }

            $('#form-mou').find('input[value="' + file.name + '"]').remove();
        },
        addedfiles() {
            console.log('event addedfiles');
            console.log(this.files);

        },
        init: function() {
            let oldFiles = document.getElementById('old-files').value;

            if (oldFiles !== '') {
                oldFiles = JSON.parse(oldFiles);

                console.log(oldFiles);

                oldFiles.forEach((file, index) => {
                    let dataFile = {
                        name: file.filename,
                        size: file.size
                    };

                    this.options.addedfile.call(this, dataFile);

                    // this.options.thumbnail.call(this, dataFile, `${window.location.origin}/upload/mou/${file.filename}`);

                    dataFile.previewElement.classList.add('dz-complete');

                    $("#form-mou").append(`<input type="hidden" name="files[${index}]" value="${file.filename}" required>`);

                    if (index == oldFiles.length - 1) {
                        this.emit("complete", dataFile);
                    }
                });
            }
        },
    });

}

function uploadFile(file) {
    return new Promise((resolve, reject) => {
        if (typeof myDropZone === 'undefined') {
            return reject('Dropzone not found');
        }

        // Tambahkan event listener untuk menangani sukses atau error
        function onUploadSuccess(uploadedFile) {
            if (uploadedFile === file) {
                myDropZone.off("success", onUploadSuccess);
                myDropZone.off("error", onUploadError);
                resolve(); // File berhasil diunggah
            }
        }

        function onUploadError(uploadedFile, errorMessage) {
            if (uploadedFile === file) {
                myDropZone.off("success", onUploadSuccess);
                myDropZone.off("error", onUploadError);
                reject(errorMessage); // File gagal diunggah
            }
        }

        myDropZone.on("success", onUploadSuccess);
        myDropZone.on("error", onUploadError);

        // Mulai proses upload
        myDropZone.processFile(file);
    });
}

async function submitForm() {
    var Form = document.getElementById('form-mou');
    if (Form.checkValidity() == false) {
        var list = Form.querySelectorAll(':invalid');
        for (var item of list) {
            console.error(item);
            item.focus();
            return false;
        }
    }

    showLoading(true);

    if (isOldData && isFormCreate == false) {
        const acceptedFiles = myDropZone.getAcceptedFiles();

        if (acceptedFiles.length > 0) {
            try {
                // Tunggu semua file selesai diunggah sebelum lanjut
                await Promise.all(acceptedFiles.map(file => uploadFile(file)));
                console.log('Proses Upload File Selesai');

            } catch (error) {
                console.error("Gagal mengunggah file:", error);
                showLoading(false);
                return false;
            }
        }
    }

    console.log('Submit');

    Form.submit();
}

window.ketikNominal = async (e) => {
    if (nilaiKontrak.value != "" && tfBank.value != "") {
        let nk = parseInt(nilaiKontrak.value.split('.').join(""));
        let tf = parseInt(tfBank.value.split('.').join(""));

        let sel =  nk - tf;
        let minus = (sel < 0) ? true : false;
        selisih.value = formatRupiah(sel.toString(), minus);
    } else {
        selisih.value = "";
    }

    e.value = await formatRupiah(e.value);
}

function formatRupiah(angka, minus = false) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return rupiah ? (minus) ? '-' + rupiah : rupiah : "";
}
