<?php
function formulario_registro_causas_muerte()
{
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "causas_muerte";
        $datos = [
            'user_id' => get_current_user_id(),
            'descripcion' => $_POST['descripcion'],
            'abreviatura' => $_POST['abreviatura'],
            'activo' => $_POST['activo'],
            'fecha_registro' => date('Y-m-d H:m:s')
        ];

        $wpdb->insert(
            $table_name, //table
            $datos, //data
            array_fill(0, count($datos), '%s') //data format
        );
        $message = "School inserted";
    }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4>Formulario de registro de causas de muerte</h4>
                </div>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div><?php endif; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="descripcion" class="form-label">Descripción*</label>
                                <textarea class="form-control" id="descripcion"
                                          rows="3" cols="5" maxlength="255" name="descripcion"
                                          required></textarea>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="abreviatura" class="form-label">Abreviación*</label>
                                <textarea class="form-control" id="abreviatura"
                                          rows="3" cols="5" maxlength="255" name="abreviatura"></textarea>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12 mt-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="activo" id="activo">
                                    <label class="form-check-label" for="activo">Estado</label>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=lista_estadisticas'); ?>"
                           role="button" class="btn btn-link"
                        >
                            Regresar a listado
                        </a>
                        <input type="submit" name="insert" value="Guardar" class="btn btn-outline-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}