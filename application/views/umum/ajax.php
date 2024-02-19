<!-- iklan -->
<script>
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
                "url": "<?= base_url('customer/get_table_umum') ?>",
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

    function by_id(id, type) {
        if (type == 'edit') {
            saveData = 'edit';
        }
        $.ajax({
            type: "GET",
            url: "<?= base_url('customer/by_id_user/') ?>" + id,
            dataType: "JSON",
            success: function(response) {
                if (type == 'hapus') {

                } else if (type == 'edit') {
                    location.replace('<?= base_url('customer/edit_umum_page/') ?>' + id)
                }
            }
        })
    }


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

</script>