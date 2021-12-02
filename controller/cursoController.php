<?php
class CursoController
{
    private $conectar;
    private $db;
    private $niveles;
    private $videos;
    private $recursos;
    private $assets;
    private $categorias;
    private $dbDir;
    private $mNivel;
    private $mVideo;
    private $mRecurso;
    private $mCategoria;
    private $mCursoBusqueda;


    public function __construct($dir, $model, $modelCursoBusqueda, $modelNivel, $modelVideo, $modelRecurso, $modelCategoria, $carpetaAssets)
    {
        $this->dbDir = $dir;
        $this->mNivel = $modelNivel;
        $this->mVideo = $modelVideo;
        $this->mRecurso = $modelRecurso;
        $this->mCategoria = $modelCategoria;
        $this->mCursoBusqueda = $modelCursoBusqueda;

        require_once $modelNivel;
        require_once $modelVideo;
        require_once $modelRecurso;
        require_once $modelCategoria;
        require_once $modelCursoBusqueda;
        $this->assets = $carpetaAssets;
        $this->videos = new VideoController($this->dbDir, "$modelVideo");
        $this->recursos = new RecursoController($this->dbDir, "$modelRecurso");
        $this->categorias = new CategoriaController($this->dbDir, "$modelCategoria");
        require_once "$model";
        require_once "$this->dbDir";
        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function crearCurso($pCurso)
    {

        $curso = new Curso($pCurso->CursoCrear);
        $dia = date("Ymd");

        $nameAux = str_replace("'", "\'", $curso->TituloCurso);
        $descrAux = str_replace("'", "\'", $curso->DescrCurso);
        $sql = "call crearCurso('$nameAux', '$descrAux', $curso->PrecioCompleto, '$curso->ImagenCurso', $curso->Disponible , $curso->CreadoPor, '$dia')";
        $query = $this->db->query($sql);
        if ($query) {
            $row = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }
        $curso->IdCurso = json_decode($row['IdCurso']);

        foreach ($pCurso->Categorias as $categoria) {
            $auxCat = new Categoria($categoria);
            $this->categorias = new CategoriaController($this->dbDir, $this->mCategoria);

            $IdCatCruso = $this->categorias->addCategoriaCurso($auxCat->IdCategoria, $curso->IdCurso, $curso->CreadoPor);
        }

        foreach ($pCurso->Niveles as $nivel) {
            $auxNivel = new Nivel($nivel);
            $auxIdNivel = $auxNivel->IdNivel;
            $this->niveles = new NivelController($this->dbDir, $this->mNivel);
            $auxNivel =  $this->niveles->crearNivel($curso->IdCurso, $auxNivel);

            foreach ($pCurso->Videos as $video) {
                $auxVideo = new Video($video);
                $auxIdVideo = $auxVideo->IdVideo;
                if ($auxVideo->NivelPadre == $auxIdNivel) {
                    $this->videos = new VideoController($this->dbDir, $this->mVideo);
                    $auxVideo = $this->videos->crearVideo($curso->IdCurso, $auxNivel->IdNivel, $auxVideo, $this->assets);

                    foreach ($pCurso->Archivos as $archivo) {
                        $auxArchivo = new Recurso($archivo);
                        if ($auxArchivo->VideoPadre == $auxIdVideo) {
                            $this->recursos = new RecursoController($this->dbDir, $this->mRecurso);
                            $auxArchivo = $this->recursos->crearRecurso($auxVideo->IdVideo, $auxArchivo, $this->assets);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function getCurso($idCurso)
    {
        $cursoPresentacion = new CursoPresentacion(null);
        $nivelesCurso = array();
        $commentsCurso = array();
        $catsCurso = array();

        $sql = "call getCursoById($idCurso)";

        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $cursoPresentacion->IdCurso = json_decode($row['IdCurso']);
            $cursoPresentacion->TituloCurso = $row['TituloCurso'];
            $cursoPresentacion->DescrCurso = $row['DescrCurso'];
            $cursoPresentacion->PrecioCompleto = $row['PrecioCompleto'];
            $cursoPresentacion->ImagenCurso = $row['ImagenCurso'];
            $cursoPresentacion->IdMaestro = json_decode($row['IdMaestro']);
            $cursoPresentacion->Nombre = $row['Nombre'];
            $cursoPresentacion->APaterno = $row['APaterno'];
            $cursoPresentacion->AMaterno = $row['AMaterno'];
            $cursoPresentacion->ImagenMaestro = $row['ImagenMaestro'];
            $cursoPresentacion->Likes = json_decode($row['Likes']);
            $this->db->close();
            $this->db = $this->conectar->conexion();
            $sqlNiveles = "call getNivelesCurso($idCurso)";
            $queryNiveles = $this->db->query($sqlNiveles);
            if ($queryNiveles != null) {

                while ($rowNiveles = $queryNiveles->fetch_assoc()) {
                    $auxNiveles = new Nivel(null);
                    $auxNiveles->IdNivel = json_decode($rowNiveles['IdNivel']);
                    $auxNiveles->Nombre = $rowNiveles['Nombre'];
                    $auxNiveles->Costo = json_decode($rowNiveles['Costo']);
                    $auxNiveles->CursoPadre = json_decode($rowNiveles['CursoPadre']);

                    array_push($nivelesCurso, $auxNiveles);
                }
            }

            $this->db->close();
            $this->db = $this->conectar->conexion();

            $sqlComments = "call getComentariosCurso($idCurso)";
            $queryComments = $this->db->query($sqlComments);

            if ($queryComments != null) {
                while ($rowComments = $queryComments->fetch_assoc()) {
                    $auxComment = new ComentarioCurso(null);
                    $auxComment->IdComentario = json_decode($rowComments['IdComentario']);
                    $auxComment->CursoComentado = json_decode($rowComments['CursoComentado']);
                    $auxComment->ComentadoPor = json_decode($rowComments['ComentadoPor']);
                    $auxComment->Nombre = $rowComments['Nombre'];
                    $auxComment->APaterno = $rowComments['APaterno'];
                    $auxComment->AMaterno = $rowComments['AMaterno'];
                    $auxComment->ImagenUsuario = $rowComments['ImagenUsuario'];
                    $auxComment->Contenido = $rowComments['Contenido'];
                    $auxComment->Fecha = $rowComments['Fecha'];
                    $auxComment->Calificacion = json_decode($rowComments['Calificacion']);

                    array_push($commentsCurso, $auxComment);
                }
            }

            $cursoPresentacion->NivelesCurso = $nivelesCurso;
            $cursoPresentacion->Comentarios = $commentsCurso;

            $this->db->close();
            $this->db = $this->conectar->conexion();

            $sqlCats = "call getCategoriasCurso($idCurso)";
            $queryCats = $this->db->query($sqlCats);

            if ($queryCats != null) {
                while ($rowCats = $queryCats->fetch_assoc()) {
                    $auxCat = new CategoriaCurso(null);
                    $auxCat->IdCatXCurso = json_decode($rowCats['IdCatXCurso']);
                    $auxCat->CategoriaAsign = json_decode($rowCats['CategoriaAsign']);
                    $auxCat->CursoAsign = json_decode($rowCats['CursoAsign']);
                    $auxCat->Descripcion = $rowCats['Descripcion'];
                    $auxCat->CreadoPor = json_decode($rowCats['CreadoPor']);
                    $auxCat->FechaCreacion = $rowCats['FechaCreacion'];

                    array_push($catsCurso, $auxCat);
                }
            }

            $cursoPresentacion->Categoria = $catsCurso;
        } else {
            return json_decode($this->db->error);
        }

        return $cursoPresentacion;
    }

    public function updateCurso($pData)
    {
        $curso = new CursoModificar($pData);
        $nameAux = str_replace("'", "\'", $curso->TituloCurso);
        $descrAux = str_replace("'", "\'", $curso->DescrCurso);
        if ($curso->Disponible) {
            $dis = 1;
        } else {
            $dis = 0;
        }
        $sql = "call UpdateCurso($curso->IdCurso, '$nameAux', '$descrAux', $dis, '$curso->ImagenCurso')";
        $query = $this->db->query($sql);

        if ($query != null) {
            return true;
        } else {
            echo json_encode($this->db->error);
            return false;
        }
    }

    public function getCursoByCategoria($pIdCat)
    {
        $cursosArray = array();

        $sql = "call getCursoByCategoria($pIdCat)";
        $query = $this->db->query($sql);


        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $auxCurso = new CursoBusqueda(null);
                $auxCurso->IdCurso = json_decode($row['IdCurso']);
                $auxCurso->TituloCurso = $row['TituloCurso'];
                $auxCurso->DescrCurso = $row['DescrCurso'];
                $auxCurso->PrecioCompleto = json_decode($row['PrecioCompleto']);
                $auxCurso->ImagenCurso = $row['ImagenCurso'];
                $auxCurso->Nombre = $row['Nombre'];
                $auxCurso->APaterno = $row['APaterno'];
                $auxCurso->AMaterno = $row['AMaterno'];
                $auxCurso->CategoriaAsign = json_decode($row['CategoriaAsign']);
                $auxCurso->Likes = json_decode($row['Likes']);

                array_push($cursosArray, $auxCurso);
            }
        } else {

            return json_decode($this->db->error);
        }

        return $cursosArray;
    }

    public function getCursoByTexto($pTexto)
    {
        $cursosArray = array();

        $sql = "call getCursoByText('$pTexto')";
        $query = $this->db->query($sql);



        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $auxCurso = new CursoBusqueda(null);
                $auxCurso->IdCurso = json_decode($row['IdCurso']);
                $auxCurso->TituloCurso = $row['TituloCurso'];
                $auxCurso->DescrCurso = $row['DescrCurso'];
                $auxCurso->PrecioCompleto = json_decode($row['PrecioCompleto']);
                $auxCurso->ImagenCurso = $row['ImagenCurso'];
                $auxCurso->Nombre = $row['Nombre'];
                $auxCurso->APaterno = $row['APaterno'];
                $auxCurso->AMaterno = $row['AMaterno'];
                $auxCurso->CategoriaAsign = json_decode($row['CategoriaAsign']);
                $auxCurso->Likes = json_decode($row['Likes']);

                array_push($cursosArray, $auxCurso);
            }
        } else {

            return json_decode($this->db->error);
        }


        return $cursosArray;
    }


    public function getTop3Vendidos()
    {
        $cursos = array();

        $sql = "call getTop3Vendidos()";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $auxCurso = new CursoInicio(null);
                $auxCurso->IdCurso = json_decode($row['IdCurso']);
                $auxCurso->TituloCurso = $row['TituloCurso'];
                $auxCurso->ImagenCurso = $row['ImagenCurso'];

                array_push($cursos, $auxCurso);
            }
        } else {

            return json_decode($this->db->error);
        }

        return $cursos;
    }


    public function getTop3Calificados()
    {
        $cursos = array();

        $sql = "call getTop3Calificados()";
        $query = $this->db->query($sql);

        if ($query != null) {

            while ($row = $query->fetch_assoc()) {
                $auxCurso = new CursoInicio(null);
                $auxCurso->IdCurso = json_decode($row['IdCurso']);
                $auxCurso->TituloCurso = $row['TituloCurso'];
                $auxCurso->ImagenCurso = $row['ImagenCurso'];

                array_push($cursos, $auxCurso);
            }
        } else {

            return json_decode($this->db->error);
        }

        return $cursos;
    }

    public function getTop3Recientes()
    {
        $cursos = array();

        $sql = "call getTop3Recientes()";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($row = $query->fetch_assoc()) {

                $auxCurso = new CursoInicio(null);
                $auxCurso->IdCurso = json_decode($row['IdCurso']);
                $auxCurso->TituloCurso = $row['TituloCurso'];
                $auxCurso->ImagenCurso = $row['ImagenCurso'];

                array_push($cursos, $auxCurso);
            }
        } else {

            return json_decode($this->db->error);
        }

        return $cursos;
    }

    public function getCursoToPago($pIdCurso)
    {
        $this->db = $this->conectar->conexion();
        $curso = new CursoToPago(null);

        $sql = "call getCursoToPago($pIdCurso)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $curso->IdCurso = json_decode($row['IdCurso']);
            $curso->TituloCurso = $row['TituloCurso'];
            $curso->PrecioCompleto = json_decode($row['PrecioCompleto']);
        } else {

            return json_decode($this->db->error);
        }

        return $curso;
    }

    public function getCursosCreados($pIdUsuario)
    {
        $cursos = array();

        $sql = "call getCursosCreados($pIdUsuario)";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $aux = new CursoCreado(null);
                $aux->IdCurso = json_decode($row['IdCurso']);
                $aux->TituloCurso = $row['TituloCurso'];
                $aux->DescrCurso = $row['DescrCurso'];
                $aux->ImagenCurso = $row['ImagenCurso'];
                $aux->AlumnosInscritos = json_decode($row['AlumnosInscritos']);
                $aux->Promedio = json_decode($row['Promedio']);
                $aux->IngresosTotales = json_decode($row['IngresosTotales']);

                array_push($cursos, $aux);
            }
        } else {

            return json_decode($this->db->error);
        }

        return $cursos;
    }

    public function getCursoAModificar($pIdCurso)
    {
        $curso = new CursoModificar(null);
        $sql = "call getCursoModificar($pIdCurso)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $curso->IdCurso = json_decode($row['IdCurso']);
            $curso->TituloCurso = $row['TituloCurso'];
            $curso->DescrCurso = $row['DescrCurso'];
            $curso->Disponible =  json_decode($row['Disponible']);
            $curso->ImagenCurso = $row['ImagenCurso'];
        } else {

            return json_decode($this->db->error);
        }

        return $curso;
    }

    public function getVideoCurrentbyUser($pIdUsuario, $pIdCurso)
    {
        $videoToGo = new VideoToGo(null);

        $sql = "call getVideoCurrentbyUser($pIdUsuario, $pIdCurso)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $videoToGo->IdUsuario = json_decode($row['IdUsuario']);
            $videoToGo->UltimoVideo = json_decode($row['UltimoVideo']);
            $videoToGo->Curso = json_decode($row['Curso']);
        } else {
            echo json_decode($this->db->error);

            return false;
        }

        return $videoToGo;
    }

    public function generarDiploma($pIdUsuario, $pIdCurso)
    {
        $dip = new Diploma(null);

        $sql = "call generarDiploma($pIdCurso, $pIdUsuario)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $dip->Nombre = $row['Nombre'];
            $dip->APaterno = $row['APaterno'];
            $dip->AMaterno = $row['AMaterno'];
            $dip->TituloCurso = $row['TituloCurso'];
            $dip->Firma = $row['Firma'];
        } else {

            return false;
        }

        return $dip;
    }

    public function sendComentario($pCurso, $pUsuario, $pContenido, $pCalif)
    {
        $sql = "call calificaCurso($pCurso, $pUsuario, $pContenido, $pCalif)";
        $query = $this->db->query($sql);

        if ($query != null) {

            return true;
        } else {

            return false;
        }
    }

    public function InscribeEnCurso($pCurso, $pUsuario, $pPrecioPagado, $pFormaPago)
    {

        $sql = "call InscribeCurso($pCurso, $pUsuario, $pPrecioPagado, '$pFormaPago')";
        $query = $this->db->query($sql);

        if ($query != null) {

            return true;
        } else {

            return false;
        }
    }
}
