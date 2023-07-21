$(document).ready(function () {
    let table = $("#table-ranting").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        serverSide: true,
        ajax: "/datatablesRanting",
        columns: [
            {
                data: null,
                orderable: false,
                render: function (data, type, row, meta) {
                    var pageInfo = $("#table-ranting").DataTable().page.info();
                    var index = meta.row + pageInfo.start + 1;
                    return index;
                },
            },
            {
                data: "kode_ranting",
            },
            {
                data: "nama_ranting",
            },
            {
                data: "jenjang",
            },
            {
                data: "action",
                orderable: true,
                searchable: true,
            },
        ],
        columnDefs: [
            {
                targets: [4], // index kolom atau sel yang ingin diatur
                className: "text-center", // kelas CSS untuk memposisikan isi ke tengah
            },
            {
                searchable: false,
                orderable: false,
                targets: 0, // Kolom nomor, dimulai dari 0
            },
        ],
    });

    //Ketika Tombol Tambah Pelaith Di tekan
    $("#btn-add-data").on("click", function () {
        $("#title-modal").html("Tambah Data Ranting");
        $("#modal-ranting #btn-action").html(
            '<button class="btn btn-primary" id="save-data">Tambah Data</button>'
        );
    });
    //Ketika tombol tutup di tekan
    $(".btn-close").on("click", function () {
        $("#kode_ranting").val("");
        $("#nama_ranting").val("");
        $("#jenjang").val("");
        $("#unique").val("");
        $("#method").val("");
        $("#title-modal").html("");
        $("#modal-ranting #btn-action").html();
    });

    //Action Simpan
    $("#modal-ranting").on("click", "#save-data", function () {
        let formdata = $("#modal-ranting form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-ranting form").serialize(),
            url: "/ranting",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#kode_ranting").val("");
                    $("#nama_ranting").val("");
                    $("#jenjang").val("");
                    $("#unique").val("");
                    $("#method").val("");
                    $("#title-modal").html("");
                    $("#modal-ranting #btn-action").html();
                    table.ajax.reload();
                    $("#modal-ranting").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });
    //Ambil Data yang akan diedit
    $("#table-ranting").on("click", ".edit-button", function () {
        let unique = $(this).attr("data-unique");
        $.ajax({
            url: "/ranting/" + unique + "/edit",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#kode_ranting").val(response.data.kode_ranting);
                $("#nama_ranting").val(response.data.nama_ranting);
                $("#jenjang").val(response.data.jenjang);
                $("#unique").val(response.data.unique);
                $("#method").val("PUT");
                $("#title-modal").html("Edit Dat Ranting");
                $("#modal-ranting #btn-action").html(
                    '<button class="btn btn-warning text-white" id="update-data">Update Data</button>'
                );
                $("#modal-ranting").modal("show");
            },
        });
    });
    //Action Update
    $("#modal-ranting").on("click", "#update-data", function () {
        let formdata = $("#modal-ranting form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-ranting form").serialize(),
            url: "/ranting/" + $("#unique").val(),
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#kode_ranting").val("");
                    $("#nama_ranting").val("");
                    $("#jenjang").val("");
                    $("#unique").val("");
                    $("#method").val("");
                    $("#title-modal").html("");
                    $("#modal-ranting #btn-action").html();
                    table.ajax.reload();
                    $("#modal-ranting").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });
    //Action Hapus
    $("#table-ranting").on("click", ".delete-button", function () {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus data ranting?",
            text: "Anda akan menghapus data ranting",
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
                        _token: $(this).attr("data-token"),
                    },
                    url: "/ranting/" + $(this).attr("data-unique"),
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
