$(document).ready(function () {
    let table = $("#table-pelatih").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        serverSide: true,
        ajax: "/datatablesPelatih",
        columns: [
            {
                data: null,
                orderable: false,
                render: function (data, type, row, meta) {
                    var pageInfo = $("#table-pelatih").DataTable().page.info();
                    var index = meta.row + pageInfo.start + 1;
                    return index;
                },
            },
            {
                data: "nra",
            },
            {
                data: "nama",
            },
            {
                data: "tingkatan",
            },
            {
                data: "jabatan",
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
    //Ketika Tombol Tambah Pelaith Di tekan
    $("#btn-add-data").on("click", function () {
        $("#title-modal").html("Tambah Data Pelatih");
        $("#modal-pelatih #btn-action").html(
            '<button class="btn btn-primary" id="save-data">Tambah Data</button>'
        );
    });
    //Ketika tombol tutup di tekan
    $(".btn-close").on("click", function () {
        $("#nra").val("");
        $("#nama").val("");
        $("#tingkatan").val("");
        $("#jabatan").val("");
        $("#unique").val("");
        $("#method").val("");
        $("#title-modal").html("");
        $("#modal-pelatih #btn-action").html();
    });
    //Action Save Data
    $("#modal-pelatih").on("click", "#save-data", function () {
        let formdata = $("#modal-pelatih form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-pelatih form").serialize(),
            url: "/pelatih",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#nra").val("");
                    $("#nama").val("");
                    $("#tingkatan").val("");
                    $("#jabatan").val("");
                    $("#unique").val("");
                    $("#method").val("");
                    $("#title-modal").html("");
                    $("#modal-pelatih #btn-action").html();
                    table.ajax.reload();
                    $("#modal-pelatih").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });
    //Ambil Data Yang Akan Di Edit
    $("#table-pelatih").on("click", ".edit-button", function () {
        let unique = $(this).attr("data-unique");
        $.ajax({
            url: "/pelatih/" + unique + "/edit",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#nra").val(response.data.nra);
                $("#nama").val(response.data.nama);
                $("#tingkatan").val(response.data.tingkatan);
                $("#jabatan").val(response.data.jabatan);
                $("#unique").val(response.data.unique);
                $("#method").val("PUT");
                $("#title-modal").html("Edit Data Pelatih");
                $("#modal-pelatih #btn-action").html(
                    '<button class="btn btn-warning text-white" id="update-data">Update Data</button>'
                );
                $("#modal-pelatih").modal("show");
            },
        });
    });
    //Action Update
    $("#modal-pelatih").on("click", "#update-data", function () {
        let formdata = $("#modal-pelatih form").serializeArray();
        let data = {};
        $(formdata).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        $.ajax({
            data: $("#modal-pelatih form").serialize(),
            url: "/pelatih/" + $("#unique").val(),
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors);
                } else {
                    $("#nra").val("");
                    $("#nama").val("");
                    $("#tingkatan").val("");
                    $("#jabatan").val("");
                    $("#unique").val("");
                    $("#method").val("");
                    $("#title-modal").html("");
                    $("#modal-pelatih #btn-action").html();
                    table.ajax.reload();
                    $("#modal-pelatih").modal("hide");
                    Swal.fire("Good job!", response.success, "success");
                }
            },
        });
    });
    //Action Hapus Data
    $("#table-pelatih").on("click", ".delete-button", function () {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus data pelatih?",
            text: "Anda akan menghapus data pelatih",
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
                    url: "/pelatih/" + $(this).attr("data-unique"),
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
