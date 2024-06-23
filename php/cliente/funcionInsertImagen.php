<?php 
//FUNCIÓN GENERAR CARACTERES PARA GALERIA
function F_gen_password($Paswd_Lenght){
    // set ASCII range for random character generation  
    $lower_ascii_bound = 50; // "2"
    $upper_ascii_bound = 122; // "z"
    // Exclude special characters and some confusing alphanumerics
    // o,O,0,I,1,l etc
    $notuse = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108, 111);
    $i = 0;
    $password = '';
    while ($i < $Paswd_Lenght){
        mt_srand((double)microtime() * 1000000);
        // random limits within ASCII table
        $randnum = mt_rand($lower_ascii_bound, $upper_ascii_bound);
        if (!in_array($randnum, $notuse)){
            $password = $password.chr($randnum);
        $i++;
        };
    }; 
    return $password;
    };



    function insertarImagen($directorio, $name, $tabla){
        include('../conexion.php');
        //nombre del archivo
        $name_archivo = $_FILES[$name]['name'];
        //tipo de archivo
        $tipo_archivo = $_FILES[$name]['type'];
        //tamaño del archivo
        $tamano_archivo = $_FILES[$name]['size'];
        //pregunto si cargo una imagen
        if (trim($name_archivo)!=' '){
            //directorio en el servidor donde guardo las imagenes
          $path="../fletero/'.$directorio.'/";
              //aqui genero el nuevo nombre del archivo en caso de que quiera cambiarle el nombre del archivo ingresado esta arriba en el head 
              $nomdig=F_gen_password(13);
              //Verifico enl tipo de archivo ingresado y y le asigno la extension a una variable
              if($_FILES[$name]['type']=="image/pjpeg" OR $_FILES[$name]['type']=="image/jpeg" OR $_FILES[$name]['type']=="image/png" OR $_FILES[$name]['type']=="image/jpg"){
                $extension='.jpg';
              }else{
            if($_FILES[$name]['type']=="image/gif"){
                        $extension='.gif';
                      }else{
                        ?>
                            <script type="text/javascript">
                                alert(' Verifique el tipo de imagen');
                            </script>
                        <?php
                        $c=1;
                      }
              }
        }else{
            ?>
            <script type="text/javascript">
                alert(' Debe Ingresar una imagen');
            </script>
            <?php
        }
        if ($c==0) {
            // aqui voy formando el nombre del archivo
            $nomdig .=$extension;
            // aqui genero la direccion y nombre donde se gurdara el archivo ej. doc/xxx.jpg
              $nuevo_nombre=$path.$nomdig; 
              //copio el archivo al directorio
              if (copy($_FILES[$name]['tmp_name'], $nuevo_nombre)){
                // aqui actualiazaria la base de datos con la direccion del la imagen en este caso la variable $nuevo_nombre
            $ultid=mysqli_insert_id($conexion);
                //INSERTAR IMAGEN
                $sql1 = "INSERT INTO fletero($tabla) VALUES('$nuevo_nombre') ";
                //FUNCION FORMATEAR FECHA
          //$sql="update imagen set imagen ='$nuevo_nombre' where idImagen='$ultid'";
            $result=mysqli_query($conexion,$sql1);
                ?>
                <script type="text/javascript">
                    alert('Se transfirio correctamente la imagen ');
                </script>
                <?php
              }else{
                ?>
                <script type="text/javascript">
                    alert('No se transfirio correctamente la imagen ');
                </script>
                <?php
                $c=1;
              }
        }
           
};
?>