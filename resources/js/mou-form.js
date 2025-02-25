 // Dropzone.autoDiscover = false;

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
});

// var myDropZone = new Dropzone('.dropzone', {
//     url: `{{ route('mou.uploadFile') }}`, // Set the url for your upload script location
//     acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx",
//     paramName: "file", // The name that will be used to transfer the file
//     maxFiles: 10,
//     maxFilesize: 20, // MB
//     addRemoveLinks: true,
//     autoQueue: false,
//     success: function(file, response){
//         if (response.status == true) {
//             $("#form-mou").append(`<input type="hidden" name="files[]" value="${response.data.name}" required>`);
//             $("#form-mou").append(`<input type="hidden" name="files_size[]" value="${response.data.size}" required>`);
//         }
//     },
//     headers: {
//         'X-CSRF-TOKEN': window._token
//     }
// });

// function uploadFile(file, index) {
//     return new Promise((resolve, reject) => {
//         setTimeout(() => {
//             myDropZone.processFile(file);
//             resolve();
//         }, 500);
//     });
// }


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

    // const acceptedFiles = myDropZone.getAcceptedFiles();
    // if (acceptedFiles.length > 0) {
    //     for (let i = 0; i < acceptedFiles.length; i++) {
    //         await uploadFile(acceptedFiles[i], i);
    //     }
    // }

    $('#form-mou').submit();
}

const nilaiKontrak = document.getElementById('nilai-kontrak');
const tfBank = document.getElementById('hasil-transfer-bank');
const selisih = document.getElementById('selisih');

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
