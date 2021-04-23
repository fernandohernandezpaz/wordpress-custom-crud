<?php
//namespace App\Modulos\causas_muerte;

use App\Models\GeneroModel;

require_once(ROOTDIR . 'vendor/autoload.php');
require_once(ROOTDIR . 'assetsConfig.php');
//list
function list_generos()
{
    renderCSS();
    ?>
    <?php
    $generoModel = new GeneroModel();
    $data = $generoModel->get();
    $columnas = $generoModel->getColumns();
    ?>
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                    <h4>Lista de causas de muerte</h4>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                    <a href="<?php echo admin_url('admin.php?page=crear_genero'); ?>"
                       role="button" class="btn btn-outline-primary">
                        Agregar nuevo género
                    </a>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <table class="table table-sm table-bordered w-100">
                        <thead>
                        <tr>
                            <?php
                            foreach ($columnas as $columna) { ?>
                                <th class="text-center text-uppercase">
                                    <?php echo str_replace('_id', '', $columna) ?>
                                </th>
                            <?php } ?>
                            <th class="text-center text-uppercase">Acciones</th>
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
                                    <th><?php echo $row->nombre ?></th>
                                    <th class="text-center <?php echo $row->activo ? 'text-success' : 'text-muted' ?>">
                                        <?php echo $row->activo ? 'Activo' : 'Inactivo'; ?>
                                    </th>
                                    <th class="text-center">
                                        <a href="<?php echo admin_url('admin.php?page=actualizar_genero&id=' . $row->id); ?>"
                                           style="text-decoration: none" class="text-primary">
                                            Actualizar
                                        </a>
                                        <a href="<?php echo admin_url('admin.php?page=eliminar_genero&id=' . $row->id); ?>"
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
    <?php
    renderJS();
}

//create
function formulario_registro_genero()
{
    //insert
    if (isset($_POST['insert'])) {
        $activo = false;
        if (isset($_POST['activo'])) {
            $activo = filter_var($_POST['activo'], FILTER_VALIDATE_BOOLEAN);
        }
        $datos = [
            'nombre' => $_POST['nombre'],
            'activo' => $activo,
        ];
        GeneroModel::create($datos);
        $message = "Género creada exitosamente";
    }
    renderCSS();
    ?>

    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4>Formulario de registro de género</h4>
                </div>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div><?php endif; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="nombre" class="form-label">Nombre*</label>
                                <input type="text" class="form-control" id="nombre" maxlength="20" name="nombre"
                                          required>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12 mt-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="activo" id="activo"
                                           value="true">
                                    <label class="form-check-label" for="activo">Estado</label>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=lista_generos'); ?>"
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
    renderJS();
}

//update
function formulario_actualizar_genero()
{
    $id = $_GET['id'];
    //UPDATE
    if (isset($_POST['update'])) {
        $activo = false;
        if (isset($_POST['activo'])) {
            $activo = filter_var($_POST['activo'], FILTER_VALIDATE_BOOLEAN);
        }
        $datos = [
            'nombre' => $_POST['nombre'],
            'activo' => $activo
        ];
        GeneroModel::updateOrCreate([
            'id' => $id
        ], $datos);
        $message = "Género actualizada exitosamente";
    }
    $registro = GeneroModel::find($id);
    renderCSS();
    ?>
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
                        <input type="hidden" name="id" value="<?php echo $registro->id; ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="nombre" class="form-label">Nombre*</label>
                                <input type="text" class="form-control" id="nombre"
                                          maxlength="20" name="nombre" value="<?php echo $registro->nombre; ?>"
                                          required>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12 mt-2">
                                <div class="form-check">
                                    <input type="checkbox"
                                           <?php if (filter_var($registro->activo, FILTER_VALIDATE_BOOLEAN)) { ?>checked<?php } ?>
                                           class="form-check-input" name="activo" value="true" id="activo">
                                    <label class="form-check-label" for="activo">Estado</label>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=lista_generos'); ?>"
                           role="button" class="btn btn-link"
                        >
                            Regresar a listado
                        </a>
                        <input type="submit" name="update" value="actualizar" class="btn btn-outline-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    renderJS();
}

//delete
function formulario_eliminar_genero()
{
    $id = $_GET['id'];
    $registro = GeneroModel::find($id);
    // DELETE
    if (isset($_POST['delete'])) {
        $registro->delete();
        $registro = null;
        $message = "Género eliminada exitosamente";
    }
    renderCSS();
    ?>
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4>Formulario de registro de causas de muerte</h4>
                </div>
                <?php if (isset($message)) { ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
                <?php } else if ($registro) { ?>
                    <div class="alert alert-info" role="alert">¿Seguro que desea eliminar este registro?</div>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">Ya eliminaste este registro ya no puedes eliminarlo
                        nuevamente
                    </div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <?php if ($registro) { ?>
                            <input type="hidden" name="id" value="<?php echo $registro->id; ?>">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                    <label for="nombre" class="form-label">Nombre*</label>
                                    <input type="text" class="form-control" id="nombre" readonly="readonly"
                                              value="<?php echo $registro->nombre; ?>" maxlength="255" name="nombre"
                                              required>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12 mt-2">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               <?php if (filter_var($registro->activo, FILTER_VALIDATE_BOOLEAN)) { ?>checked<?php } ?>
                                               style="pointer-events: none"
                                               class="form-check-input" name="activo" id="activo">
                                        <label class="form-check-label" style="pointer-events: none"
                                               for="activo">Estado</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <a href="<?php echo admin_url('admin.php?page=lista_generos'); ?>"
                           role="button" class="btn btn-link"
                        >
                            Regresar a listado
                        </a>
                        <?php if ($registro) { ?>
                            <input type="submit" name="delete" value="eliminar" class="btn btn-danger">
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    renderJS();
}