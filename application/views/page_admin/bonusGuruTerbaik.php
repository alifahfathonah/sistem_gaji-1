<script>
    /** 
     * @Author: fitra 
     * @Date: 2021-01-23 23:25:18 
     * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
     * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
     */
    console.log('test')
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#data').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "dom": 'Bfrtip',
            "buttons": [
                'excel', 'print'
            ],
            "ajax": {
                "url": "<?php echo site_url('administrator/bonusGuruTerbaik/getAllData') ?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });

    var save_method;

    function updateAllTable() {
        table.ajax.reload();
    }

    function pesan() {
        alert('Sorry, you can not use this feature, You are not allowed to access it !');
    }

    function print(id) {
        window.open("<?php echo base_url('administrator/slipBonusGuruTerbaik') ?>/" + id, '_blank');
    }

    function tambah() {
        save_method = 'add';
        $('#form_inputan_add')[0].reset();
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $('#modal_add').modal('show');
        $('.reset').show();
    }

    function ubah(id) {
        save_method = 'update';
        $('#form_inputan_update')[0].reset();
        $('#modal_update').modal('show');
        // $('#upload_porto').hide();
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $.ajax({
            url: "<?php echo site_url('administrator/bonusGuruTerbaik/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="id"]').val(data.id);
                $('[name="id_karyawan"]').val(data.id_karyawan);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="keterangan"]').val(data.keterangan);
                $('[name="jumlah_bonus"]').val(data.jumlah_bonus);
                $('.reset').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
        // alert('Sedang dalam pengerjaan');

    }

    function ubahGbr(id) {
        save_method = 'update';
        $('#form_inputan1')[0].reset();
        $('#modal1').modal('show');
        $('#upload_porto').hide();
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $.ajax({
            url: "<?php echo site_url('administrator/bonusGuruTerbaik/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="id"]').val(data.id);
                $('[name="upload_portofolio"]').val(data.upload_portofolio);
                $('.reset').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
        // alert('Sedang dalam pengerjaan');

    }

    function hapus(id) {
        swal({
                title: "Apakah Yakin Akan Dihapus?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: "<?php echo site_url('administrator/bonusGuruTerbaik/delete'); ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(resp) {
                        data = resp.result;
                        updateAllTable();
                        return swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error Deleting Data');
                    }
                });
            });
    }


    function simpan() {
        var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
        var csrf_hash = ''
        var url;
        url = '<?php echo base_url() ?>administrator/bonusGuruTerbaik/tambahData';
        swal({
                title: "Apakah anda sudah yakin ?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                cancelButtonText: "Kembali",
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#form_inputan_add').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result
                        csrf_hash = resp.csrf['token'];
                        $('#form_inputan_add input[name=' + token_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateAllTable();
                            $('.form-group').removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error').remove();
                            $("#form_inputan_add")[0].reset();
                            $('#modal_add').modal('hide');
                        } else {
                            $.each(data['messages'], function(key, value) {
                                var element = $('#' + key);
                                element.closest('div.form-group')
                                    .removeClass('has-error')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                                    .find('#text-error')
                                    .remove();
                                element.after(value);
                            });
                        }
                        swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    }

                });
            });
    }

    function simpan_update() {
        var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
        var csrf_hash = ''
        var url;

        url = '<?php echo base_url() ?>administrator/bonusGuruTerbaik/update';
        swal({
                title: "Apakah anda sudah yakin ?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                cancelButtonText: "Kembali",
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#form_inputan_update').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result
                        csrf_hash = resp.csrf['token'];
                        $('#form_inputan_update input[name=' + token_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateAllTable();
                            $('.form-group').removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error').remove();
                            $("#form_inputan_update")[0].reset();
                            $('#modal_update').modal('hide');
                        } else {
                            $.each(data['messages'], function(key, value) {
                                var element = $('#' + key);
                                element.closest('div.form-group')
                                    .removeClass('has-error')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                                    .find('#text-error')
                                    .remove();
                                element.after(value);
                            });
                        }
                        swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    }

                });
            });
    }
</script>
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Bonus Guru Terbaik</h2>

                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-primary btn-sm" type="button" onclick="tambah()">
                    <li class="fa fa-plus"></li> Tambah Data</button>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                </ul>
                <div class="text-right">

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <div class="text-right">
                                <?php if ($this->session->flashdata('alert')) {
                                    echo '<div class="badge bg-blue" >' . $this->session->flashdata('alert') . '</div>';
                                } else if ($this->session->flashdata('error')) {
                                    echo '<div class="badge bg-red" >' . $this->session->flashdata('error') . '</div>';
                                } ?>
                            </div>
                            <table id="data" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="font-size: 10px;">No</th>
                                        <th style="font-size: 10px;">Tools</th>
                                        <th style="font-size: 10px;">Nama Karyawan</th>
                                        <th style="font-size: 10px;">Tanggal Bonus</th>
                                        <th style="font-size: 10px;">Portofolio</th>
                                        <th style="font-size: 10px;">Keterangan</th>
                                        <th style="font-size: 10px;">Jumlah Bonus</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modal_add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <li class="fa fa-list"></li> Form Input Bonus Guru Terbaik
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" id="form_inputan_add" method="post" class="form-horizontal">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <?php echo form_input(array('id' => 'id', 'name' => 'id', 'type' => 'hidden')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Nama Karyawan<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <select name="id_karyawan" id="id_karyawan" class="form-control has-feedback-left" required>
                                        <option value="">Pilih Karyawan</option>
                                        <?php foreach ($getKaryawan as $r) : ?>
                                            <option value="<?php echo $r->id_karyawan; ?>"><?php echo $r->nama_karyawan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Tanggal Bonus<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <input type="date" id="tanggal" value="0" name="tanggal" class="form-control has-feedback-left">
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Keterangan<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Jumlah Bonus<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <input type="number" id="jumlah_bonus" value="0" name="jumlah_bonus" class="form-control has-feedback-left" required>
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" onclick="simpan()" class="btn btn-success btn-sm">Simpan</button>
                </div>
                <?php echo form_close() ?>
        </div>

    </div>
</div>




<!-- Modal update -->
<div id="modal_update" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <li class="fa fa-list"></li> Form Update Bonus Guru Terbaik
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" id="form_inputan_update" method="post" class="form-horizontal">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <?php echo form_input(array('id' => 'id', 'name' => 'id', 'type' => 'hidden')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Nama Karyawan<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <select name="id_karyawan" id="id_karyawan" class="form-control has-feedback-left" required>
                                        <option value="">Pilih Karyawan</option>
                                        <?php foreach ($getKaryawan as $r) : ?>
                                            <option value="<?php echo $r->id_karyawan; ?>"><?php echo $r->nama_karyawan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Tanggal Bonus<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <input type="date" id="tanggal" value="0" name="tanggal" class="form-control has-feedback-left">
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Keterangan<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Jumlah Bonus<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <input type="number" id="jumlah_bonus" value="0" name="jumlah_bonus" class="form-control has-feedback-left" required>
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" onclick="simpan_update()" class="btn btn-success btn-sm">Simpan</button>
                </div>
                <?php echo form_close() ?>
        </div>

    </div>
</div>

<!-- Modal Update -->
<div id="modal1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <li class="fa fa-list"></li> Update Portofolio
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo base_url('administrator/bonusGuruTerbaik/updateGbr') ?>" id="form_inputan1" method="post" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="modal-body">
                    <?php echo form_input(array('id' => 'id', 'name' => 'id', 'type' => 'hidden')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field item form-group">
                                <label class="col-form-label col-md-4 col-sm-3">Upload Portofolio<span class="required">*</span></label>
                                <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                    <input type="file" id="upload_portofolio" value="0" name="upload_portofolio" class="form-control has-feedback-left" required>
                                    <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="alert('Apakah anda yakin ?')" class="btn btn-success btn-sm">Simpan</button>

                </div>
                <?php echo form_close() ?>
        </div>

    </div>
</div>