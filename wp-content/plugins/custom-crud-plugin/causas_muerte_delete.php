<?php
function formulario_eliminar_causas_muerte()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "causas_muerte";
    $id = $_GET['id'];
    $registro = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%s", $id));
    $registro = $registro[0];
    // DELETE
    if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $_POST['id']));
        $message = "Causa de muerte eliminada exitosamente";
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
                <?php if (isset($message)) { ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">¿Seguro que desea eliminar este registro?</div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <?php if (!isset($message)) { ?>
                            <input type="hidden" name="id" value="<?php echo $registro->id; ?>">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                    <label for="descripcion" class="form-label">Descripción*</label>
                                    <textarea class="form-control" id="descripcion" readonly="readonly"
                                              rows="3" cols="5" maxlength="255" name="descripcion"
                                              required><?php echo $registro->descripcion; ?></textarea>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                    <label for="abreviatura" class="form-label">Abreviación*</label>
                                    <textarea class="form-control" id="abreviatura"
                                              rows="3" cols="5" maxlength="255" readonly="readonly"
                                              name="abreviatura"><?php echo $registro->abreviatura; ?></textarea>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12 mt-2">
                                    <div class="form-check">
                                        <input type="checkbox" <?php echo $registro->activo ? 'checked' : ''; ?>
                                               style="pointer-events: none"
                                               class="form-check-input" name="activo" id="activo">
                                        <label class="form-check-label" style="pointer-events: none" for="activo">Estado</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <a href="<?php echo admin_url('admin.php?page=lista_estadisticas'); ?>"
                           role="button" class="btn btn-link"
                        >
                            Regresar a listado
                        </a>
                        <?php if (!isset($message)) { ?>
                            <input type="submit" name="delete" value="eliminar" class="btn btn-danger">
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}