$(document).ready(function () {
    let table = $("#table-absensi-pelatih").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        serverSide: true,
        ajax: "/datatablesAbsensiPelatih",
        columns: [
            {
                data: null,
                orderable: false,
                render: function (data, type, row, meta) {
                    var pageInfo = $("#table-absensi-pelatih")
                        .DataTable()
                        .page.info();
                    var index = meta.row + pageInfo.start + 1;
                    return index;
                },
            },
            {
                data: "kode_absensi",
            },
            {
                data: "tanggal_absensi",
            },
            {
                data: "nama",
            },
            {
                data: "status",
            },
            {
                data: "action",
                orderable: true,
                searchable: true,
            },
        ],
        columnDefs: [
            {
                targets: [5], // index kolom atau sel yang ingin diatur
                className: "text-center", // kelas CSS untuk memposisikan isi ke tengah
            },
            {
                searchable: false,
                orderable: false,
                targets: 0, // Kolom nomor, dimulai dari 0
            },
        ],
    });
    $(".btn-close").on("click", function () {
        $("#method").val("");
        $("#unique").val("");
        $("#kode_absensi").val("");
        $("#tanggal_absensi").val("");
        $("#kegiatan").val("");
        $("#status").val("");
    });
    $("#btn-add-data").on("click", function () {
        $("#modal-absensi-pelatih #btn-action").html(
            '<button class="btn btn-primary" id="save-data">Tambah Absensi</button>'
        );
        $("#title-modal").html("Tambah Data Absensi");
    });

    //Action Simpan Data
    $("#modal-absensi-pelatih").on("click", "#save-data", function () {
        let formdata = $("#modal-absensi-pelatih form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-absensi-pelatih form").serialize(),
            url: "/absensi_pelatih",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#method").val("");
                    $("#unique").val("");
                    $("#kode_absensi").val("");
                    $("#tanggal_absensi").val("");
                    $("#kegiatan").val("");
                    $("#status").val("");
                    table.ajax.reload();
                    $("#modal-absensi-pelatih").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });

    //Lihat Kegiatan
    $("#table-absensi-pelatih").on("click", ".view-button", function () {
        let kegitan = $(this).attr("data-kegitan");
        $("#isi-kegiatan").html(kegitan);
        $("#modal-kegiatan").modal("show");
    });

    $("#btn-close-kegitan").on("click", function () {
        $("#isi-kegiatan").html("");
    });

    //Ambil data yang akan diedit
    $("#table-absensi-pelatih").on("click", ".edit-button", function () {
        let unique = $(this).attr("data-unique");
        $.ajax({
            url: "/absensi_pelatih/" + unique + "/edit",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#method").val("PUT");
                $("#unique").val(unique);
                $("#kode_absensi").val(response.data.kode_absensi);
                $("#pelatih_unique").val(response.data.pelatih_unique);
                $("#tanggal_absensi").val(response.data.tanggal_absensi);
                $("#kegiatan").val(response.data.kegiatan);
                $("#status").val(response.data.status);
                $("#modal-absensi-pelatih #btn-action").html(
                    '<button class="btn btn-primary" id="update-data">Update Absensi</button>'
                );
                $("#title-modal").html("Edit Data Absensi");
                $("#modal-absensi-pelatih").modal("show");
            },
        });
    });

    //Action Update Data
    $("#modal-absensi-pelatih").on("click", "#update-data", function () {
        let formdata = $("#modal-absensi-pelatih form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-absensi-pelatih form").serialize(),
            url: "/absensi_pelatih/" + $("#unique").val(),
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#method").val("");
                    $("#unique").val("");
                    $("#kode_absensi").val("");
                    $("#tanggal_absensi").val("");
                    $("#kegiatan").val("");
                    $("#status").val("");
                    table.ajax.reload();
                    $("#modal-absensi-pelatih").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });

    //HAPUS DATA
    $("#table-absensi-pelatih").on("click", ".delete-button", function () {
        let unique = $(this).attr("data-unique");
        let token = $(this).attr("data-token");
        Swal.fire({
            title: "Apakah Kamu Yakin?",
            text: "Kamu akan menghapus data guru!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    data: {
                        _method: "DELETE",
                        _token: token,
                    },
                    url: "/absensi_pelatih/" + unique,
                    type: "POST",
                    dataType: "json",
                    success: function (response) {
                        table.ajax.reload();
                        Swal.fire("Deleted!", response.success, "success");
                    },
                });
            }
        });
    });

    //Hendler Error
    function displayErrors(errors) {
        // menghapus class 'is-invalid' dan pesan error sebelumnya
        $("input.form-control").removeClass("is-invalid");
        $("select.form-control").removeClass("is-invalid");
        $("div.invalid-feedback").remove();

        // menampilkan pesan error baru
        $.each(errors, function (field, messages) {
            let inputElement = $("input[name=" + field + "]");
            let selectElement = $("select[name=" + field + "]");
            let textAreaElement = $("textarea[name=" + field + "]");
            let feedbackElement = $(
                '<div class="invalid-feedback ml-2"></div>'
            );

            $(".btn-close").on("click", function () {
                inputElement.each(function () {
                    $(this).removeClass("is-invalid");
                });
                textAreaElement.each(function () {
                    $(this).removeClass("is-invalid");
                });
                selectElement.each(function () {
                    $(this).removeClass("is-invalid");
                });
            });

            $.each(messages, function (index, message) {
                feedbackElement.append(
                    $('<p class="p-0 m-0 text-center">' + message + "</p>")
                );
            });

            if (inputElement.length > 0) {
                inputElement.addClass("is-invalid");
                inputElement.after(feedbackElement);
            }

            if (selectElement.length > 0) {
                selectElement.addClass("is-invalid");
                selectElement.after(feedbackElement);
            }
            if (textAreaElement.length > 0) {
                textAreaElement.addClass("is-invalid");
                textAreaElement.after(feedbackElement);
            }
            inputElement.each(function () {
                if (
                    inputElement.attr("type") == "text" ||
                    inputElement.attr("type") == "number"
                ) {
                    inputElement.on("click", function () {
                        $(this).removeClass("is-invalid");
                    });
                    inputElement.on("change", function () {
                        $(this).removeClass("is-invalid");
                    });
                } else if (inputElement.attr("type") == "date") {
                    inputElement.on("change", function () {
                        $(this).removeClass("is-invalid");
                    });
                }
            });
            textAreaElement.each(function () {
                textAreaElement.on("click", function () {
                    $(this).removeClass("is-invalid");
                });
            });
            selectElement.each(function () {
                selectElement.on("click", function () {
                    $(this).removeClass("is-invalid");
                });
            });
        });
    }
});
