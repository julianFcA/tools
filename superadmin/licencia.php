<?php
require_once 'template.php';

$lista = $conn->prepare("SELECT * FROM licencia, empresa WHERE licencia.nit_empre = empresa.nit_empre AND esta_licen  AND empresa.nit_empre != '65e5b3e7a66b7' IN ('activo', 'inactivo')");

$lista->execute();
$listas = $lista->fetchAll(PDO::FETCH_ASSOC);
?>

 
            <br>
            <br>
            <br>

            <body>

                <div class="content-body container-table">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Actividad de Empresas| Activación y Desactivación de Licencia</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!-- Tabla HTML para mostrar los resultados -->
                                            <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Licencia</th>
                                                        <th>Nombre de Empresa</th>
                                                        <th>Fecha de Inicio</th>
                                                        <th>Fecha de Fin</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($listas as $lista) {
                                                        // Determinar la clase CSS y el estado del botón según el estado_servi
                                                        $estadoClase = '';
                                                        $color = '';
                                                        $mensaje = '';
                                                        $botonInactivo = '';
                                                        $botonCancelar = '';
                                                        $activo = '';

                                                        // Comprobar si la hora de finalización ha pasado
                                                        $horaFinalizacionPasada = strtotime($lista["fecha_fin"]) < strtotime("now");

                                                        // Si la licencia está activa y la hora de finalización ha pasado
                                                        if ($lista["esta_licen"] == 'activo' && $horaFinalizacionPasada) {
                                                            // Actualizar el estado de la licencia en la base de datos a 'inactivo'
                                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = :licencia");
                                                            $updateEstado->bindParam(':licencia', $lista["licencia"], PDO::PARAM_INT);
                                                            $updateEstado->execute();

                                                            // Actualizar las variables para reflejar el nuevo estado
                                                            $estadoClase = 'table-warning';
                                                            $botonInactivo = 'disabled';
                                                            $color = 'orange';
                                                            $mensaje = 'Bloqueado';
                                                        } elseif ($lista["esta_licen"] == 'inactivo' && !$horaFinalizacionPasada) {
                                                            // Si la licencia está inactiva y la hora de finalización no ha pasado
                                                            // Actualizar el estado de la licencia en la base de datos a 'activo'
                                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'activo' WHERE licencia = :licencia");
                                                            $updateEstado->bindParam(':licencia', $lista["licencia"], PDO::PARAM_INT);
                                                            $updateEstado->execute();

                                                            // Actualizar las variables para reflejar el nuevo estado
                                                            $estadoClase = 'table-success';
                                                            $activo = 'disabled';
                                                            $color = 'green';
                                                            $mensaje = 'Disponible';

                                                        } elseif ($lista["esta_licen"] == 'inactivo' && $horaFinalizacionPasada) {
                                                            // Si la licencia está inactiva y la hora de finalización ha pasado
                                                            // No es necesario hacer nada aquí, simplemente mantener el estado inactivo
                                                            $color = 'orange';
                                                            $mensaje = 'Inactivo';
                                                        }
                                                        {
                                                            // Actualiza las variables para reflejar el nuevo estado
                                                            $estadoClase = 'table-success';
                                                            $activo = 'activo';
                                                            $color = 'green';
                                                            $mensaje = 'Disponible';
                                                            }
        
                                                            if ($lista["esta_licen"] == 'inactivo') {
                                                            $estadoClase = '';
                                                            $botonInactivo = 'disabled';
                                                            $color = 'orange';
                                                            $mensaje = 'Esta inactivo';
                                                            } elseif ($lista["esta_licen"] == 'cancelado') {
                                                            $estadoClase = '';
                                                            $botonCancelar = 'disabled';
                                                            $color = 'red';
                                                            $mensaje = 'Esta cancelado';
                                                            } elseif ($lista["esta_licen"] == 'activo') {
                                                            $estadoClase = '';
                                                            $activo = 'disabled';
                                                            $color = 'green';
                                                            $mensaje = 'activo';
                                                            }
                                                    ?> 
                                                    <tr class="<?= $estadoClase ?>" style="color: <?= $color ?>">
                                                            <td><?= $lista["licencia"] ?></td>
                                                            <td><?= $lista["nom_empre"] ?></td>
                                                            <td><?= $lista["fecha_ini"] ?></td>
                                                            <td><?= $lista["fecha_fin"] ?></td>
                                                            <td><?= $lista["esta_licen"] ?></td>
                                                        </tr>

                                                    <?php }?>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>