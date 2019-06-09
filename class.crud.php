<?php

class crud {

    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }

    public function retorna_pais($xpais) {
        $query = "select nombre from tbl_pais where codigo =" . $xpais;
        $data = $DB_con->prepare($query);    // Prepare query for execution
        $data->execute(); // Execute (run) the query
        $row = $data->fetch(PDO::FETCH_ASSOC);
        return $row['nombre'];
    }

    public function login($email, $clave) {
        try {
            $stmt = $this->db->prepare("select codusuario from usuarios where email=:mail and clave=:clave");
            $stmt->bindparam(":mail", $email);
            $stmt->bindparam(":clave", $clave);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if ($count) {
                $_SESSION['codusuario'] = $data->codusuario; // Storing user session value
                return true;
            } else {
                $this->error = 'Datos erroneos';
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $e->getMessage();
            return false;
        }
    }

    public function buscarPaciente() {
        try {
            $stmt = $this->db->prepare("SELECT codusuario, CONCAT_WS(' ',nombre1 , nombre2, apellido1 , apellido2) AS nombre FROM usuarios where idperfil=1"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(); //User data
            return $data;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function buscarMedicinas() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM medicinas"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(); //User data
            return $data;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function userDetails($uid) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE codusuario=:uid");
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_OBJ); //User data
            return $data;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function getPerfil($uid) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM perfiles WHERE idperfil=:uid");
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_OBJ); //User data
            return $data;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function create($fname, $lname, $email, $contact, $pais) {
        try {
            $stmt = $this->db->prepare("INSERT INTO tbl_users(first_name,last_name,email_id,contact_no,idpais) VALUES(:fname, :lname, :email, :contact, :pais)");
            $stmt->bindparam(":fname", $fname);
            $stmt->bindparam(":lname", $lname);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":contact", $contact);
            $stmt->bindparam(":pais", $pais);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function diagnosticar($diagnostico, $fecha, $idcita, $observacion, $codusuario, $idestado) {
        try {
            $stmt = $this->db->prepare("insert into historial(diagnostico,fecha,idcita,observacion,codusuario) "
                    . " values(:diag,:fecha,:idcita,:observacion,:idusuario)");
            $stmt->bindparam(":diag", $diagnostico);
            $stmt->bindparam(":fecha", $fecha);
            $stmt->bindparam(":idcita", $idcita);
            $stmt->bindparam(":observacion", $observacion);
            $stmt->bindparam(":idusuario", $codusuario);
            $stmt->execute();
            $this->updateEstado($idcita, $idestado);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public $error = '';

    public function insertarPaciente($dni, $correo, $clave, $lnombre1, $nombre2, $apellido1, $apellido2, $dir, $tel, $canton, $fn) {
        $error = '';
        try {
            $stmt = $this->db->prepare("INSERT INTO usuarios (dni,email,clave,nombre1,nombre2,apellido1,apellido2,direccion,"
                    . "telefono,idcanton, fechanacimiento, idperfil)"
                    . "VALUES(:dni,:email,:clave,:n1, :n2, :a1, :a2,:dir,:tel,:ic,:fn,3)");
            $stmt->bindparam(":dni", $dni);
            $stmt->bindparam(":email", $correo);
            $stmt->bindparam(":clave", $clave);
            $stmt->bindparam(":n1", $lnombre1);
            $stmt->bindparam(":n2", $nombre2);
            $stmt->bindparam(":a1", $apellido1);
            $stmt->bindparam(":a2", $apellido2);
            $stmt->bindparam(":dir", $dir);
            $stmt->bindparam(":tel", $tel);
            $stmt->bindparam(":ic", $canton);
            $stmt->bindparam(":fn", $fn);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function insertarCita($fecha, $hora, $idcanton, $codusuario) {
        $error = '';
        try {
            $stmt = $this->db->prepare("INSERT INTO citas (fecha,hora,idcanton,codusuario)"
                    . "VALUES(:fecha,:hora,:idcanton,:codusuario)");
            $stmt->bindparam(":fecha", $fecha);
            $stmt->bindparam(":hora", $hora);
            $stmt->bindparam(":idcanton", $idcanton);
            $stmt->bindparam(":codusuario", $codusuario);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function insertarMedicamento($idcategoria, $descripcion) {
        $error = '';
        try {
            $stmt = $this->db->prepare("INSERT INTO medicinas (idmedicina,descripcion,idcategoria)"
                    . "VALUES(default,:descripcion,:idcategoria)");
            $stmt->bindparam(":descripcion", $descripcion);
            $stmt->bindparam(":idcategoria", $idcategoria);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public $id = 0;

    public function insertarReceta($descrip, $codusuario) {
        $error = '';
        try {

            $stmt = $this->db->prepare("select getIDReceta() as id");
            $stmt->execute();
            $id = $stmt->fetch();
            $this->id = $id['id'];

            $stmt = $this->db->prepare("INSERT INTO receta "
                    . "VALUES(:id,:descrip,CURDATE(),:codusuario)");
            $stmt->bindparam(":id", $this->id);
            $stmt->bindparam(":descrip", $descrip);
            $stmt->bindparam(":codusuario", $codusuario);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function insertarDetalle($id, $idme, $iddo, $obser, $cant) {
        $error = '';
        try {

            $stmt = $this->db->prepare("INSERT INTO detallereceta "
                    . " (idreceta, idmedicina, dosis, observacion,cantidad) "
                    . "VALUES (:id, :idme, :iddo, :obser,:cant)");
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":idme", $idme);
            $stmt->bindparam(":iddo", $iddo);
            $stmt->bindparam(":obser", $obser);
            $stmt->bindparam(":cant", $cant);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function insertarDocente($dni, $lnombre1, $nombre2, $apellido1, $apellido2, $tel, $mail, $nac, $tit) {
        $error = '';
        try {
            $stmt = $this->db->prepare("insert into usuarios (nombreusuario,clave,idperfil) "
                    . "values (:dni,:dni,2);");
            $stmt->bindparam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindparam(":dni", $dni, PDO::PARAM_STR);
            $stmt->execute();
            $stmt = $this->db->prepare("select idusuario from usuarios where nombreusuario=:dni");
            $stmt->bindparam(":dni", $dni);
            $stmt->execute();
            $id = $stmt->fetch();
            $stmt = $this->db->prepare("INSERT INTO docentes(dni, nombre1, nombre2, apellido1, apellido2, telefono," .
                    "estado, email, nacionalidad, titulo, idusuario)" .
                    "VALUES (:dni, :n1, :n2, :a1, :a2, :tel, 'A', :mail, :nac, :tit, :id)");
            $stmt->bindparam(":dni", $dni);
            $stmt->bindparam(":n1", $lnombre1);
            $stmt->bindparam(":n2", $nombre2);
            $stmt->bindparam(":a1", $apellido1);
            $stmt->bindparam(":a2", $apellido2);
            $stmt->bindparam(":tel", $tel);
            $stmt->bindparam(":mail", $mail);
            $stmt->bindparam(":nac", $nac);
            $stmt->bindparam(":tit", $tit);
            $stmt->bindparam(":id", $id['idusuario']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function insertarResponsable($dni, $lnombre1, $nombre2, $apellido1, $apellido2, $tel, $mail) {
        $error = '';
        try {
            $stmt = $this->db->prepare("insert into usuarios (nombreusuario,clave,idperfil) "
                    . "values (:dni,:dni,2);");
            $stmt->bindparam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindparam(":dni", $dni, PDO::PARAM_STR);
            $stmt->execute();
            $stmt = $this->db->prepare("select idusuario from usuarios where nombreusuario=:dni");
            $stmt->bindparam(":dni", $dni);
            $stmt->execute();
            $id = $stmt->fetch();
            $stmt = $this->db->prepare("INSERT INTO responsables(" .
                    "dni, nombre1, nombre2, apellido1, apellido2, telefono, estado, email,idusuario)" .
                    "VALUES (:dni, :n1, :n2, :a1, :a2, :tel, 'A', :mail, :id)");
            $stmt->bindparam(":dni", $dni);
            $stmt->bindparam(":n1", $lnombre1);
            $stmt->bindparam(":n2", $nombre2);
            $stmt->bindparam(":a1", $apellido1);
            $stmt->bindparam(":a2", $apellido2);
            $stmt->bindparam(":tel", $tel);
            $stmt->bindparam(":mail", $mail);
            $stmt->bindparam(":id", $id['idusuario']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->error = $error;
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id) {
        $stmt = $this->db->prepare("SELECT * FROM tbl_users WHERE id=:id");
        $stmt->execute(array(":id" => $id));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function update($id, $fname, $lname, $email, $contact, $pais) {
        try {
            $stmt = $this->db->prepare("UPDATE tbl_users SET first_name=:fname, 
		                                               last_name=:lname, 
													   email_id=:email, 
													   contact_no=:contact,
													   idpais=:pais
													WHERE id=:id ");
            $stmt->bindparam(":fname", $fname);
            $stmt->bindparam(":lname", $lname);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":contact", $contact);
            $stmt->bindparam(":pais", $pais);

            $stmt->bindparam(":id", $id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateEstado($idcita, $idestado) {
        try {
            $stmt = $this->db->prepare("UPDATE citas SET idestado=:ide WHERE idcita=:idc ");
            $stmt->bindparam(":idc", $idcita);
            $stmt->bindparam(":ide", $idestado);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tbl_users WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

    /* paging */

    public function dataview($query) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php print($row['id']); ?></td>
                    <td><?php print($row['first_name']); ?></td>
                    <td><?php print($row['last_name']); ?></td>
                    <td><?php print($row['email_id']); ?></td>
                    <td><?php print($row['contact_no']); ?></td>
                    <td><?php
                        $vpais = $row['idpais'];
                        $quer_pais = $this->db->prepare("select * from tbl_pais where codigo =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['nombre']);
                        ?>
                    </td>
                    <td align="center">
                        <a href="edit-data.php?edit_id=<?php print($row['id']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                    </td>
                    <td align="center">
                        <a href="delete.php?delete_id=<?php print($row['id']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function getGridCitas($query) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php print($row['idcita']); ?></td>
                    <td><?php
                        $vpais = $row['codusuario'];
                        $quer_pais = $this->db->prepare("select * from usuarios where codusuario =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['nombre1'] . " " . $fila['nombre2'] . " " . $fila['apellido1'] . " " . $fila['apellido2']);
                        ?>
                    </td>
                    <td><?php print($row['fecha']); ?></td>
                    <td><?php print($row['hora']); ?></td>
                    <td><?php
                        $vpais = $row['idcanton'];
                        $quer_pais = $this->db->prepare("select * from cantones where idcanton =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['nombrecanton']);
                        ?>
                    </td>
                    <td><?php
                        $vpais = $row['idestado'];
                        $quer_pais = $this->db->prepare("select * from estados where idestado =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['descripcion']);
                        ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function getHistorial($query) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php print($row['idhistorial']); ?></td>
                    <td><?php print($row['diagnostico']); ?></td>
                    <td><?php print($row['fecha']); ?></td>
                    <td><?php print($row['observacion']); ?></td>

                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function verDetalleReceta($query) {
         
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td><?php print($row['idmedicina']); ?></td>
                    <td><?php print($row['descripcion']); ?></td>
                    <td><?php print($row['cantidad']); ?>
                    <td><?php print($row['dosis']); ?></td>
                    <td><?php print($row['observacion']); ?>

                    </td>



                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

     public function verReceta2($query) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                 
                <tr>
                    <td><?php print($row['idmedicina']); ?></td>
                     <td><?php print($row['descripcion']); ?></td>
                    <td><?php
                $vpais = $row['idcategoria'];
                $quer_pais = $this->db->prepare("select descripcion from categorias where idcategoria=:varpais");
                $quer_pais->execute([':varpais' => $vpais]);
                $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                print($fila['descripcion']);
                ?>
                    </td>
                   
                                   
                     
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }
    
    
    public function verReceta($query) {
       
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td><?php print($row['idreceta']); ?></td>
                    <td><?php print($row['descripcion']); ?></td>
                    <td><?php
                        print($row['fecha']);
                        ?>
                    </td>

                    <td><a href="verDetalleReceta.php?idreceta=<?php print($row['idreceta']); ?>" class="btn btn-primary">Ver Detalles</a></td>              

                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function getGridCitas2($query, $idperfil) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['idcita'];
                ?>
                <tr>
                    <td><?php print($id); ?></td>
                    <td><?php
                        $idu = $row['codusuario'];
                        $quer_pais = $this->db->prepare("select * from usuarios where codusuario =:varpais");
                        $quer_pais->execute([':varpais' => $idu]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        $fulln = $fila['nombre1'] . " " . $fila['nombre2'] . " " . $fila['apellido1'] . " " . $fila['apellido2'];
                        print($fila['nombre1'] . " " . $fila['nombre2'] . " " . $fila['apellido1'] . " " . $fila['apellido2']);
                        ?>
                    </td>
                    <td><?php
                        $fecha = $row['fecha'];
                        print($row['fecha']);
                        ?></td>
                    <td><?php print($row['hora']); ?></td>
                    <td><?php
                        $vpais = $row['idcanton'];
                        $quer_pais = $this->db->prepare("select * from cantones where idcanton =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['nombrecanton']);
                        ?>
                    </td>
                    <td><?php
                        $vpais = $row['idestado'];
                        $quer_pais = $this->db->prepare("select * from estados where idestado =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['descripcion']);
                        ?>
                    </td>
                    <td> 
                        <?php
                        if ($idperfil == 3) {
                            ?>
                            <a href="setStadoCita.php?idcita=<?php print($id) . "&idestado=2" ?>" class="btn btn-primary" type="button"  >Aceptar</a>  
                            <a  href="setStadoCita.php?idcita=<?php print($id) . "&idestado=4" ?>" class="btn btn-danger" type="button"  >Rechazar</a>
                            <?php
                        } else if ($idperfil == 2 && $vpais == 2) {
                            ?>    
                            <a href="diagnostica.php?idcita=<?php print($id) . "&idestado=3&fecha=$fecha&nombre=$fulln&codu=$idu" ?>" class="btn btn-primary" type="button"  >Realizar Consulta</a>  



                        </td>  
                    </tr>

                    <?php
                }
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function getGridCitas3($query) {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['idcita'];
                ?>
                <tr>
                    <td><?php print($id); ?></td>
                    <td><?php
                        $vpais = $row['codusuario'];
                        $quer_pais = $this->db->prepare("select * from usuarios where codusuario =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        $fulln = $fila['nombre1'] . " " . $fila['nombre2'] . " " . $fila['apellido1'] . " " . $fila['apellido2'];
                        print($fila['nombre1'] . " " . $fila['nombre2'] . " " . $fila['apellido1'] . " " . $fila['apellido2']);
                        ?>
                    </td>
                    <td><?php
                        $fecha = $row['fecha'];
                        print($row['fecha']);
                        ?></td>
                    <td><?php print($row['hora']); ?></td>
                    <td><?php
                        $vpais = $row['idcanton'];
                        $quer_pais = $this->db->prepare("select * from cantones where idcanton =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['nombrecanton']);
                        ?>
                    </td>
                    <td><?php
                        $vpais = $row['idestado'];
                        $quer_pais = $this->db->prepare("select * from estados where idestado =:varpais");
                        $quer_pais->execute([':varpais' => $vpais]);
                        $fila = $quer_pais->fetch(PDO::FETCH_ASSOC);
                        print($fila['descripcion']);
                        ?>
                    </td>
                    <td> <a href="diagnostica.php?idcita=<?php print($id) . "&idestado=3&fecha=$fecha&nombre=$fulln" ?>" class="btn btn-primary" type="button"  >Realizar Consulta</a>  
                    </td>  
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td>Sin resultados...</td>
            </tr>
            <?php
        }
    }

    public function paging($query, $records_per_page) {
        $starting_position = 0;
        if (isset($_GET["page_no"])) {
            $starting_position = ($_GET["page_no"] - 1) * $records_per_page;
        }
        $query2 = $query . " limit $starting_position,$records_per_page";
        return $query2;
    }

    public function paginglink($query, $records_per_page) {
        $self = $_SERVER['PHP_SELF'];
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $total_no_of_records = $stmt->rowCount();
        if ($total_no_of_records > 0) {
            ?><ul class="pagination"><?php
                $total_no_of_pages = ceil($total_no_of_records / $records_per_page);
                $current_page = 1;
                if (isset($_GET["page_no"])) {
                    $current_page = $_GET["page_no"];
                }
                if ($current_page != 1) {
                    $previous = $current_page - 1;
                    echo "<li><a href='" . $self . "?page_no=1'>Primero || </a></li>";
                    echo "<li><a href='" . $self . "?page_no=" . $previous . "'> Anterior ||</a></li>";
                }
                for ($i = 1; $i <= $total_no_of_pages; $i++) {
                    if ($i == $current_page) {
                        echo "<li><a href='" . $self . "?page_no=" . $i . "' style='color:red;'> " . $i . " || </a> </li>";
                    } else {
                        echo "<li><a href='" . $self . "?page_no=" . $i . "'> " . $i . " ||</a></li>";
                    }
                }
                if ($current_page != $total_no_of_pages) {
                    $next = $current_page + 1;
                    echo "<li><a href='" . $self . "?page_no=" . $next . "'> Siguiente || </a></li>";
                    echo "<li><a href='" . $self . "?page_no=" . $total_no_of_pages . "'> Último ||</a></li>";
                }
                ?></ul><?php
        }
    }

    /* paging */
}
