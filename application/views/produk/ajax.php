<script>
    var saveData;
    var table = $('#table');
    var modal_tambah = $('#modal_tambah');
    var modal_tambah_gambar = $('#modal_tambah_gambar');
    $(document).ready(function() {
        table.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('master_zahir/get_table_produk') ?>",
                "type": "POST"
            },
            "oLanguage": {
                "sSearch": "Pencarian : ",
                "sEmptyTable": "Data Tidak Tersedia",
                "sLoadingRecords": "Silahkan Tunggu - loading...",
                "sLengthMenu": "Menampilkan &nbsp;  _MENU_  &nbsp;   Data",
                "sZeroRecords": "Tidak Ada Data Di Cari",
                "sProcessing": "Memuat Data...."
            }
        });
    });

    function relodTable() {
        table.DataTable().ajax.reload();
    }

    function messageSwal(icon, text) {
        swal({
            title: "Success!!!",
            text: text,
            icon: icon
        })
    }

    function by_id(id, type) {
        if (type == 'edit') {
            saveData = 'edit';
        }
        if (type == 'detail') {
            saveData = 'detail';
        }
        if (type == 'hapus') {
            saveData = 'hapus';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('master_zahir/by_id_produk/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (type == 'hapus') {
                    delete_question(response['get_produk'].id_produk, response['get_produk'].nama_produk)
                } else if (type == 'edit') {
                    location.replace('<?= base_url('master_zahir/edit_produk_page/') ?>' + id)
                } else {
                    modal_tambah_gambar.modal('show');
                    $('[name="id_produk"]').val(response['get_produk'].id_produk)
                    var table_gambar = $('#table_gambar');
                    $(document).ready(function() {
                        table_gambar.DataTable({
                            "responsive": true,
                            "autoWidth": false,
                            "processing": true,
                            "serverSide": true,
                            "bDestroy":true,
                            "order": [],
                            "ajax": {
                                "url": "<?= base_url('master_zahir/get_table_produk_gambar/') ?>" + response['get_produk'].id_produk,
                                "type": "POST"
                            },
                            "oLanguage": {
                                "sSearch": "Pencarian : ",
                                "sEmptyTable": "Data Tidak Tersedia",
                                "sLoadingRecords": "Silahkan Tunggu - loading...",
                                "sLengthMenu": "Menampilkan &nbsp;  _MENU_  &nbsp;   Data",
                                "sZeroRecords": "Tidak Ada Data Di Cari",
                                "sProcessing": "Memuat Data...."
                            }
                        });
                    });
                }
            }
        })
    }


    function by_id_produk_gambar(id, type) {
        if (type == 'hapus') {
            saveData = 'hapus';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('master_zahir/by_id_produk_gambar/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                delete_question_gambar(response['get_produk_gambar'].id_detail_gambar_produk, response['get_produk_gambar'].id_produk)
            }
        })
    }

    function delete_question_gambar(id_detail_gambar_produk, id_produk) {
        swal({
                title: "Apakah Anda Yakin!?",
                text: "Ingin Menghapus Data Foto Produk Ini ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    delete_data_gambar(id_detail_gambar_produk, id_produk);
                } else {
                    messageSwal('success', 'Data Tidak Jadi Di Hapus, Data Kamu Aman!!')
                }
            })
    }

    function delete_data_gambar(id_detail_gambar_produk, id_produk) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('master_zahir/hapus_produk_gambar/') ?>" + id_detail_gambar_produk,
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    messageSwal('success', 'Data Berhasil Di Hapus')
                    var table_gambar = $('#table_gambar');
                    $(document).ready(function() {
                        table_gambar.DataTable({
                            "responsive": true,
                            "autoWidth": false,
                            "processing": true,
                            "serverSide": true,
                            "bDestroy":true,
                            "order": [],
                            "ajax": {
                                "url": "<?= base_url('master_zahir/get_table_produk_gambar/') ?>" + id_produk,
                                "type": "POST"
                            },
                            "oLanguage": {
                                "sSearch": "Pencarian : ",
                                "sEmptyTable": "Data Tidak Tersedia",
                                "sLoadingRecords": "Silahkan Tunggu - loading...",
                                "sLengthMenu": "Menampilkan &nbsp;  _MENU_  &nbsp;   Data",
                                "sZeroRecords": "Tidak Ada Data Di Cari",
                                "sProcessing": "Memuat Data...."
                            }
                        });
                    });
                }
            }
        })
    }

    function delete_question(id_produk, nama_produk) {
        swal({
                title: "Apakah Anda Yakin!?",
                text: "Ingin Menghapus Data " + nama_produk + " ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    delete_data(id_produk);
                } else {
                    messageSwal('success', 'Data Tidak Jadi Di Hapus, Data Kamu Aman!!')
                }
            })
    }

    function delete_data(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('master_zahir/hapus_produk/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    relodTable();
                    messageSwal('success', 'Data Berhasil Di Hapus')
                }
            }
        })
    }

    // tambah
    var form_tambah = $('#form_tambah');
    form_tambah.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>master_zahir/tambah_produk",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.button_simpan').attr('disabled', 'disabled');
            },
            success: function(response) {
                messageSwal('success', 'Data Berhasil Di Tambah!!');
                relodTable();
                form_tambah[0].reset();
                $('.button_simpan').attr('disabled', false);
                modal_tambah.modal('hide');
            }
        });
    });

    var form_tambah_gambar = $('#form_tambah_gambar');
    form_tambah_gambar.on('submit', function(e) {
        var id_produk = $('[name="id_produk"]').val()
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>master_zahir/tambah_produk_gambar",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.button_simpan').attr('disabled', 'disabled');
            },
            success: function(response) {
                messageSwal('success', 'Data Berhasil Di Tambah!!');
                form_tambah_gambar[0].reset();
                $('.button_simpan').attr('disabled', false);
                var table_gambar = $('#table_gambar');
                $(document).ready(function() {
                    table_gambar.DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "processing": true,
                        "serverSide": true,
                        "bDestroy":true,
                        "order": [],
                        "ajax": {
                            "url": "<?= base_url('master_zahir/get_table_produk_gambar/') ?>" + id_produk,
                            "type": "POST"
                        },
                        "oLanguage": {
                            "sSearch": "Pencarian : ",
                            "sEmptyTable": "Data Tidak Tersedia",
                            "sLoadingRecords": "Silahkan Tunggu - loading...",
                            "sLengthMenu": "Menampilkan &nbsp;  _MENU_  &nbsp;   Data",
                            "sZeroRecords": "Tidak Ada Data Di Cari",
                            "sProcessing": "Memuat Data...."
                        }
                    });
                });

            }
        });
    });

    // edit
    var form_edit = $('#form_edit');
    form_edit.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>master_zahir/edit_produk",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.button_simpan').attr('disabled', 'disabled');
            },
            success: function(response) {
                messageSwal('success', 'Data Berhasil Di edit!!');
            }
        });
    });
</script>

<script>
    var table_detail_produk = $('#table_detail_produk');
    var id_produk = $('#id_produk').val()
    $(document).ready(function() {
        table_detail_produk.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('master_zahir/get_table_detail_produk/') ?>" + id_produk,
                "type": "POST"
            },
            "oLanguage": {
                "sSearch": "Pencarian : ",
                "sEmptyTable": "Data Tidak Tersedia",
                "sLoadingRecords": "Silahkan Tunggu - loading...",
                "sLengthMenu": "Menampilkan &nbsp;  _MENU_  &nbsp;   Data",
                "sZeroRecords": "Tidak Ada Data Di Cari",
                "sProcessing": "Memuat Data...."
            }
        });
    });

    function relodTableDetailproduk() {
        table_detail_produk.DataTable().ajax.reload();
    }

    // tambah_detail
    var form_tambah_detail_produk = $('#form_tambah_detail_produk');
    var modal_tambah_detail_produk = $('#modal_tambah_detail_produk');
    form_tambah_detail_produk.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>master_zahir/tambah_detail_produk",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.button_simpan').attr('disabled', 'disabled');
            },
            success: function(response) {
                messageSwal('success', 'Data Berhasil Di Tambah!!');
                relodTableDetailproduk();
                form_tambah_detail_produk[0].reset();
                $('.button_simpan').attr('disabled', false);
                modal_tambah_detail_produk.modal('hide');
            }
        });
    });

    function by_id_detail_produk(id, type) {
        if (type == 'hapus') {
            saveData = 'hapus';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('master_zahir/by_id_detail_produk/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                delete_question_detail_produk(response['get_detail_produk'].id_detail_produk, response['get_detail_produk'].nama_produk_detail)
            }
        })
    }



    function delete_question_detail_produk(id_detail_produk, nama_produk_detail) {
        swal({
                title: "Apakah Anda Yakin!?",
                text: "Ingin Menghapus Data " + nama_produk_detail + " ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    delete_data_detail_produk(id_detail_produk);
                } else {
                    messageSwal('success', 'Data Tidak Jadi Di Hapus, Data Kamu Aman!!')
                }
            })
    }

    function delete_data_detail_produk(id_detail_produk) {
        var id_produk = $('#id_produk').val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('master_zahir/hapus_detail_produk/') ?>" + id_detail_produk,
            data: {
                id_produk: id_produk
            },
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    relodTableDetailproduk();
                    messageSwal('success', 'Data Berhasil Di Hapus')
                }
            }
        })
    }
</script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image_view').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>