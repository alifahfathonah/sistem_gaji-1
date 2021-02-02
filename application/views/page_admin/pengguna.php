<script>
    /** 
     * @Author: fitra 
     * @Date: 2021-01-23 23:25:18 
     * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
     * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
     */
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#datatable1').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            "ajax": {
                "url": "<?php echo site_url('administrator/pengguna/getAllData') ?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "order": [
                [0, "asc"]
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


    function ubah(id) {
        save_method = 'update';
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $('#pwd').hide();
        $.ajax({
            url: "<?php echo site_url('administrator/pengguna/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="id"]').val(data.id);
                $('[name="first_name"]').val(data.first_name);
                $('[name="last_name"]').val(data.last_name);
                $('[name="username"]').val(data.username);
                $('[name="password"]').val(data.password);
                $('[name="address"]').val(data.address);
                $('[name="phone_number"]').val(data.phone_number);
                $('[name="role"]').val(data.role);
                $('[name="id_unit"]').val(data.id_unit);
                $('.reset').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });

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
                    url: "<?php echo site_url('administrator/pengguna/delete'); ?>/" + id,
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
        if (save_method == 'update') {
            url = '<?php echo base_url() ?>administrator/pengguna/update';
        } else {
            url = '<?php echo base_url() ?>administrator/pengguna/addData';
        }

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
                    data: $('#form_regis').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result
                        csrf_hash = resp.csrf['token'];
                        $('#form_regis input[name=' + token_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateAllTable();
                            $('.form-group').removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error').remove();
                            $('#modal').modal('hide');
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



<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-8 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>List Pengguna </h2>
                <!-- <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="window.location.reload()"><i class="fa fa-plus"></i> New Registration</button>
                </ul> -->
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable1" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tools</th>
                                        <th>Nama Karyawan</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Manajemen Pengguna</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="tambah()"><i class="fa fa-plus"></i> Tambah Data Unit</button> -->
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php echo form_open('', array('id' => 'form_regis', 'method' => 'POST')); ?>
                    <?php echo form_input(array('id' => 'id', 'name' => 'id', 'type' => 'hidden')); ?>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-4 col-sm-3">Nama Karyawan<span class="required">*</span></label>
                        <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                            <select name="first_name" id="first_name" class="form-control">
                                <option value="">Pilih Karyawan</option>
                                <?php foreach ($getKaryawan as $row) { ?>
                                    <option value="<?php echo $row->nama_karyawan ?>"><?php echo $row->nama_karyawan; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-4 col-sm-3">Username<span class="required">*</span></label>
                        <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                            <input type="text" name="username" id="username" class="form-control ">
                        </div>
                    </div>
                    <div class="field item form-group" id="pwd">
                        <label class="col-form-label col-md-4 col-sm-3">Password<span class="required">*</span></label>
                        <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                            <input type="password" name="password" id="password" class="form-control ">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-4 col-sm-3">User Role<span class="required">*</span></label>
                        <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                            <select name="role" id="role" class="form-control">
                                <option value="">--Role--</option>
                                <option value="administrator">Administrator</option>
                                <option value="yayasan">Yayasan</option>
                                <option value="keuangan">Keuangan</option>
                                <option value="pegawai">Pegawai</option>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                        <button type="button" class="btn btn-info btn-sm" onclick="simpan()">Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>