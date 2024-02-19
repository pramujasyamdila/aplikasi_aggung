<!-- iklan -->
<script>
    var saveData;
    var modal_tambah = $('#modal_tambah');
    var table_bulanan = $('#table_bulanan');
    $(document).ready(function() {
        table_bulanan.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('customer/get_table_bulanan') ?>",
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

    function _bulanan_detail() {
        table_bulanan.DataTable().ajax.reload();
    }

    function messageSwal(icon, text) {
        swal({
            title: "Success!!!",
            text: text,
            icon: icon
        })
    }
    var modal_informasi_signal = $('#modal_informasi_signal');

    function by_id(id, type) {
        var modal_cek_riwayat = $('#modal_cek_riwayat');
        if (type == 'edit') {
            saveData = 'edit';
        }
        if (type == 'hapus') {
            saveData = 'hapus';
        }
        if (type == 'view_formulir') {
            saveData = 'view_formulir';
        }
        if (type == 'view_dok_penaggihan') {
            saveData = 'view_dok_penaggihan';
        }
        if (type == 'riwayat_pembayaran') {
            saveData = 'riwayat_pembayaran';
        }
        if (type == 'cek_pembayaran') {
            saveData = 'cek_pembayaran';
        }
        if (type == 'informasi_signal') {
            saveData = 'informasi_signal';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('customer/by_id_user/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (type == 'hapus') {
                    delete_question(response['get_user'].id_user, response['get_user'].nama_user)
                } else if (type == 'edit') {
                    location.replace('<?= base_url('customer/edit_umum_page/') ?>' + id)
                } else if (type == 'view_formulir') {
                    location.replace('<?= base_url('customer/view_vormulir_pendaftaran_bulanan/') ?>' + id)
                } else if (type == 'view_dok_penaggihan') {
                    location.replace('<?= base_url('customer/view_dok_penaggihan/') ?>' + id)
                } else if (type == 'riwayat_pembayaran') {
                    generate_taggihan_pelanggan_bulanan(id)
                } else if (type == 'informasi_signal') {
                    $('[name="id_user"]').val(id);
                    modal_informasi_signal.modal('show');
                } else if (type == 'cek_pembayaran') {
                    $('#token_notif').val(response['get_user'].token_notif)
                    lihat_pembayaran()
                }
            }
        })
    }





    function by_id_riwayat_taggihan_bulanan(id, type) {
        var modal_cek_riwayat = $('#modal_cek_riwayat');
        if (type == 'cek_pembayaran') {
            saveData = 'cek_pembayaran';
        }
        if (type == 'kirim_taggihan') {
            saveData = 'kirim_taggihan';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('customer/by_id_riwayat_taggihan_bulanan/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (type == 'cek_pembayaran') {
                    $('#token_notif').val(response['get_riwayat_taggihan_bulanan'].token_notif)
                    $('#id_riwayat_pemabayaran').val(id)
                    $('[name="id_user"]').val(response['get_riwayat_taggihan_bulanan'].id_user);
                    $('[name="informasi_signal"]').val('Informasi Pembayaran !! ' + response['get_riwayat_taggihan_bulanan'].ket_pembayaran + ' Yang Anda Miliki Rp. ' + response['get_riwayat_taggihan_bulanan'].total_pembayaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',00' + ' Sudah Terbayarkan');
                    var html = '';
                    html += '<img src="<?= base_url('foto_user_pembayaran/') ?>' + response['get_riwayat_taggihan_bulanan'].file + '" width="200px" alt="">'
                    $('.result_image').html(html);
                    lihat_pembayaran()
                } else if (type == 'kirim_taggihan') {
                    $('[name="id_user"]').val(response['get_riwayat_taggihan_bulanan'].id_user);
                    $('[name="informasi_signal"]').val('Informasi Taggihan !! ' + response['get_riwayat_taggihan_bulanan'].ket_pembayaran + ' Yang Anda Miliki Rp. ' + response['get_riwayat_taggihan_bulanan'].total_pembayaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',00');
                    modal_informasi_signal.modal('show');
                } else {

                }
            }
        })
    }


    function generate_taggihan_pelanggan_bulanan(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('customer/generate_taggihan_pelanggan_bulanan/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    location.replace('<?= base_url('customer/riwayat_pembayaran/') ?>' + id)
                }
            }
        })
    }

    function lihat_pembayaran() {
        var modal_lihat_pembayaran = $('#lihat_pembayaran');
        modal_lihat_pembayaran.modal('show');
    }

    function kirim_notif() {
        var modal_lihat_pembayaran = $('#lihat_pembayaran');
        modal_lihat_pembayaran.modal('hide');
        var token_notif = $('#token_notif').val();
        var id_riwayat_pemabayaran = $('#id_riwayat_pemabayaran').val();
        var form_informasi_signal2 = $('#form_informasi_signal2');
        $.ajax({
            type: "POST",
            url: "<?= base_url('customer/update_pemabayaran_bulanan/') ?>" + id_riwayat_pemabayaran,
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url('customer/kirim_informasi'); ?>',
                        data: form_informasi_signal2.serialize(),
                        dataType: "JSON",
                        success: function(response) {
                            messageSwal('success', 'Pembayaran Berhasil Di Setujui')
                            relodTable_riwayat_bulanan_detail();
                            modal_informasi_signal.modal('hide');
                            var id_user = response['id_user'];
                            var message = response['message'];
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('api/notification/kirim_notif') ?>",
                                data: {
                                    id_user: id_user,
                                    message: message
                                },
                                dataType: "JSON",
                                success: function(response) {

                                }
                            })
                            form_informasi_signal2[0].reset();
                        }
                    })
                }
            }
        })
    }

    function delete_question(id_user, nama_user) {
        swal({
                title: "Apakah Anda Yakin!?",
                text: "Ingin Menghapus Data " + nama_user + " ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    delete_data(id_user);
                } else {
                    messageSwal('success', 'Data Tidak Jadi Di Hapus, Data Kamu Aman!!')
                }
            })
    }

    function delete_data(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('customer/hapus_user/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (response == 'success') {
                    _bulanan_detail();
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
            url: "<?php echo base_url(); ?>customer/tambah_pelanggan_bulanan",
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
                _bulanan_detail();
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
            url: "<?php echo base_url(); ?>customer/edit_pelanggan_bulanan",
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
    var table_riwayat_pembayaran_bulanan = $('#table_riwayat_pembayaran_bulanan');
    var id_user = $('.id_user').val();
    $(document).ready(function() {
        table_riwayat_pembayaran_bulanan.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('customer/get_table_riwayat_pembayaran_bulanan/') ?>" + id_user,
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

    function relodTable_riwayat_bulanan_detail() {
        table_riwayat_pembayaran_bulanan.DataTable().ajax.reload();
    }
</script>

<script>
    var table_bulanan_langganan = $('#table_bulanan_langganan');
    $(document).ready(function() {
        table_bulanan_langganan.DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('customer/get_table_bulanan_langganan') ?>",
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

    function _bulanan_detailLangganan() {
        table_bulanan_langganan.DataTable().ajax.reload();
    }

    function kirim_iformasi_signal() {
        var form_informasi_signal = $('#form_informasi_signal');
        $.ajax({
            method: "POST",
            url: '<?= base_url('customer/kirim_informasi_signal'); ?>',
            data: form_informasi_signal.serialize(),
            dataType: "JSON",
            success: function(response) {
                messageSwal('success', 'Informasai Berhasil Di Kirim')
                _bulanan_detailLangganan();
                modal_informasi_signal.modal('hide');
                var id_user = response['id_user'];
                var message = response['message'];
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('api/notification/kirim_notif') ?>",
                    data: {
                        id_user: id_user,
                        message: message
                    },
                    dataType: "JSON",
                    success: function(response) {

                    }
                })
                form_informasi_signal[0].reset();
            }
        })
    }
</script>