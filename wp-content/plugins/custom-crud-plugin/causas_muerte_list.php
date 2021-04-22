<?php

function list_causas_muerte()
{
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . "causas_muerte";
    $data = $wpdb->get_results("SELECT id, user_id, descripcion, abreviatura, activo from $table_name");
    $columnas = $wpdb->get_col("DESC {$table_name}", 0);
    $columnasOcultas = ['fecha_registro'];
    ?>
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                    <h4>Lista de causas de muerte</h4>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                    <a href="<?php echo admin_url('admin.php?page=crear_causa_muerte'); ?>"
                       role="button" class="btn btn-outline-primary">
                        Agregar nueva causa muerte
                    </a>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <table class="table table-sm table-bordered w-100">
                        <thead>
                        <tr>
                            <?php
                            foreach ($columnas as $columna) {
                                if (!in_array($columna, $columnasOcultas)) {
                                    ?>
                                    <th class="text-center text-uppercase">
                                        <?php echo str_replace('_id', '', $columna) ?>
                                    </th>
                                <?php }
                            } ?>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($data)) { ?>
                            <tr>
                                <td colspan="<?php echo count($columnas) ?>" class="text-center font-weight-bold">
                                    No se encontraron datos registrados
                                </td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data as $row) {
                                ?>
                                <tr>
                                    <th><?php echo $row->id ?></th>
                                    <th><?php echo $row->user_id ?></th>
                                    <th><?php echo $row->descripcion ?></th>
                                    <th><?php echo $row->abreviatura ?></th>
                                    <th class="text-center <?php echo $row->activo ? 'text-success' : 'text-muted' ?>">
                                        <?php echo $row->activo ? 'Activo' : 'Inactivo'; ?>
                                    </th>
                                    <th>
                                        <a href="<?php echo admin_url('admin.php?page=actualizar_causa_muerte&id=' . $row->id); ?>"
                                           style="text-decoration: none" class="text-primary">
                                            Actualizar
                                        </a>
                                        <a href="<?php echo admin_url('admin.php?page=eliminar_causa_muerte&id=' . $row->id); ?>"
                                           style="text-decoration: none" class="text-danger">
                                            Eliminar
                                        </a>
                                    </th>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous"></script>
    <?php
}