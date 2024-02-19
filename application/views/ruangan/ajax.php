<script>
    // ruangan
    var saveData;
    var table = $('#table');
    var modal_tambah = $('#modal_tambah');
    $(document).ready(function() {
        table.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('genetika/get_table_ruangan') ?>",
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
        if (type == 'hapus') {
            saveData = 'hapus';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('genetika/by_id_ruangan/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (type == 'hapus') {
                    delete_question(response['get_ruangan'].id_ruangan, response['get_ruangan'].nama_ruangan)
                } else if (type == 'edit') {
                    location.replace('<?= base_url('genetika/edit_ruangan/') ?>' + id)
                }
            }
        })
    }

    function delete_question(id_ruangan, nama_ruangan) {
        swal({
                title: "Apakah Anda Yakin!?",
                text: "Ingin Menghapus Data " + nama_ruangan + " ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    delete_data(id_ruangan);
                } else {
                    messageSwal('success', 'Data Tidak Jadi Di Hapus, Data Kamu Aman!!')
                }
            })
    }

    function delete_data(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('genetika/hapus_ruangan/') ?>" + id,
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
            url: "<?php echo base_url(); ?>genetika/tambah_ruangan",
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

    // edit
    var form_edit = $('#form_edit');
    form_edit.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>genetika/edit_ruangan_post",
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