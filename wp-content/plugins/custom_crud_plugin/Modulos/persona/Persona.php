<?php
//namespace App\Modulos\causas_muerte;

use App\Models\PersonalModel;
use App\Models\GeneroModel;
use App\Models\CausasMuerteModel;

require_once(ROOTDIR . 'vendor/autoload.php');
require_once(ROOTDIR . 'assetsConfig.php');
//list
function list_personas()
{
    renderCSS();
    ?>
    <?php
    $personalModel = new PersonalModel();
    $data = $personalModel->with(['genero', 'causasMuerte'])->get();
    $columnas = $personalModel->getColumns();
    ?>
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                    <h4>Lista de causas de muerte</h4>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                    <a href="<?php echo admin_url('admin.php?page=crear_persona'); ?>"
                       role="button" class="btn btn-outline-primary">
                        Agregar nuevo persona
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
                            <th class="text-center text-uppercase">Causas muerte</th>
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
                                    <th><?php echo $row->genero->nombre ?></th>
                                    <th><?php echo $row->nombre_completo ?></th>
                                    <th><?php echo $row->edad ?></th>
                                    <th><?php echo $row->causasMuerte->pluck('descripcion')->join('<br>') ?></th>
                                    <th class="text-center">
                                        <a href="<?php echo admin_url('admin.php?page=actualizar_persona&id=' . $row->id); ?>"
                                           style="text-decoration: none" class="text-primary">
                                            Actualizar
                                        </a>
                                        <a href="<?php echo admin_url('admin.php?page=eliminar_persona&id=' . $row->id); ?>"
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
function formulario_registro_persona()
{
    $generos = GeneroModel::where('activo', true)->get();
    $causasMuerte = CausasMuerteModel::where('activo', true)->orderBy('id')->get();
    //insert
    if (isset($_POST['insert'])) {
        $datos = [
            'nombre_completo' => $_POST['nombre_completo'],
            'edad' => $_POST['edad'],
            'genero_id' => $_POST['genero_id'],
        ];
        $persona = PersonalModel::create($datos);

        if (isset($_POST['causaMuerte'])) {
            $persona->causasMuerte()->sync($_POST['causaMuerte']);
        }
        $message = "Persona creada exitosamente";
    }
    renderCSS();
    ?>

    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4>Formulario de registro de persona</h4>
                </div>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div><?php endif; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="nombre_completo" class="form-label">Nombre completo*</label>
                                <input type="text" class="form-control" id="nombre_completo" maxlength="30"
                                       name="nombre_completo"
                                       required>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="genero_id" class="form-label">Género*</label>
                                <select name="genero_id" id="genero_id" class="form-control w-100" required>
                                    <option value="" hidden selected></option>
                                    <?php foreach ($generos as $genero) { ?>
                                        <option value="<?php echo $genero->id ?>"><?php echo $genero->nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="edad" class="form-label">Edad*</label>
                                <input type="number" required class="form-control" min="0" max="100" name="edad"
                                       id="edad">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                <label>Causas de muerte*</label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                <div class="container-fluid">
                                    <div class="row">

                                        <?php foreach ($causasMuerte as $causa) { ?>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="causaMuerte[]"
                                                           id="causaMuerte"
                                                           value="<?php echo $causa->id ?>">
                                                    <label class="form-check-label"
                                                           for="causaMuerte"><?php echo $causa->descripcion ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=lista_personas'); ?>"
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
function formulario_actualizar_persona()
{
    $id = $_GET['id'];
    $generos = GeneroModel::where('activo', true)->get();
    $causasMuerte = CausasMuerteModel::where('activo', true)->orderBy('id')->get();
    //UPDATE
    if (isset($_POST['update'])) {
        $datos = [
            'nombre_completo' => $_POST['nombre_completo'],
            'edad' => $_POST['edad'],
            'genero_id' => $_POST['genero_id'],
        ];
        $persona = PersonalModel::updateOrCreate([
                'id'=>$id
        ],$datos);

        if (isset($_POST['causaMuerte'])) {
            $persona->causasMuerte()->sync($_POST['causaMuerte']);
        }
        $message = "Persona actualizada exitosamente";
    }
    $registro = PersonalModel::with(['genero', 'causasMuerte'])->where('id', $id)->first();
    $causasMuerteId = $registro->causasMuerte->pluck('id')->toArray();
    renderCSS();
    ?>
    <div class="wrap">
        <div class="container-fluid" style="background: white">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4>Formulario de actualizar de persona</h4>
                </div>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div><?php endif; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="id" value="<?php echo $registro->id; ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="nombre_completo" class="form-label">Nombre completo*</label>
                                <input type="text" class="form-control" id="nombre_completo" maxlength="30"
                                       name="nombre_completo" value="<?php echo $registro->nombre_completo ?>"
                                       required>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="genero_id" class="form-label">Género*</label>
                                <select name="genero_id" id="genero_id" class="form-control w-100" required>
                                    <?php foreach ($generos as $genero) { ?>
                                        <option value="<?php echo $genero->id ?>"
                                                <?php if ($registro->genero->id === $genero->id){ ?>selected <?php } ?>
                                        >
                                            <?php echo $genero->nombre ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                <label for="edad" class="form-label">Edad*</label>
                                <input type="number" required class="form-control" min="0" max="100" name="edad"
                                       id="edad" value="<?php echo $registro->edad ?>">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                <label>Causas de muerte*</label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                <div class="container-fluid">
                                    <div class="row">
                                        <?php foreach ($causasMuerte as $causa) { ?>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="causaMuerte[]"
                                                           id="causaMuerte"
                                                           <?php if (in_array($causa->id, $causasMuerteId)) { ?>checked<?php } ?>
                                                           value="<?php echo $causa->id ?>">
                                                    <label class="form-check-label"
                                                           for="causaMuerte"><?php echo $causa->descripcion ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=lista_personas'); ?>"
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
function formulario_eliminar_persona()
{
    $id = $_GET['id'];
    $generos = GeneroModel::where('activo', true)->get();
    $causasMuerte = CausasMuerteModel::where('activo', true)->orderBy('id')->get();
    $registro = PersonalModel::with(['genero', 'causasMuerte'])->where('id', $id)->first();
    $causasMuerteId = [];
    if ($registro) {
        $causasMuerteId = $registro->causasMuerte->pluck('id')->toArray();
    }

    // DELETE
    if (isset($_POST['delete'])) {
        $registro->causasMuerte()->detach();
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
                    <h4>Formulario de eliminar persona</h4>
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
                                    <label for="nombre_completo" class="form-label">Nombre completo*</label>
                                    <input type="text" class="form-control" id="nombre_completo" maxlength="30"
                                           name="nombre_completo" value="<?php echo $registro->nombre_completo ?>"
                                           required>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                    <label for="genero_id" class="form-label">Género*</label>
                                    <select name="genero_id" id="genero_id" class="form-control w-100" required>
                                        <?php foreach ($generos as $genero) { ?>
                                            <option value="<?php echo $genero->id ?>"
                                                    <?php if ($registro->genero->id === $genero->id){ ?>selected <?php } ?>
                                            >
                                                <?php echo $genero->nombre ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10 col-12">
                                    <label for="edad" class="form-label">Edad*</label>
                                    <input type="number" required class="form-control" min="0" max="100" name="edad"
                                           id="edad" value="<?php echo $registro->edad ?>">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <label>Causas de muerte*</label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <?php foreach ($causasMuerte as $causa) { ?>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="causaMuerte[]"
                                                               id="causaMuerte"
                                                               <?php if (in_array($causa->id, $causasMuerteId)) { ?>checked<?php } ?>
                                                               value="<?php echo $causa->id ?>">
                                                        <label class="form-check-label"
                                                               for="causaMuerte"><?php echo $causa->descripcion ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                        <a href="<?php echo admin_url('admin.php?page=lista_personas'); ?>"
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