<?php

class Proceso_Profesor{
    var $id;    	var $nom;      var $ape;       	var $doc;		var $fecha;			var $con;		var $tipo;
    var $dir;      	var $tel;   	var $cel;      	var $correo;	var $especialidad;	var $estado;
    
    function __construct($id, $nom, $ape, $doc, $fecha, $dir, $tel, $cel, $correo, $especialidad, $estado, $tipo, $con){
        $this->id=$id;      $this->nom=$nom;    $this->ape=$ape;  $this->doc=$doc;			$this->fecha=$fecha;	$this->estado=$estado;
        $this->dir=$dir;    $this->tel=$tel;    $this->cel=$cel;  $this->correo=$correo;	$this->especialidad=$especialidad;	
		$this->tipo=$tipo;	$this->con=$con;
		
    }
    
    function guardar(){
        $id=$this->id;		$nom=$this->nom;	$ape=$this->ape;	$doc=$this->doc;		$fecha=$this->fecha;	$estado=$this->estado;
		$dir=$this->dir;	$tel=$this->tel;	$cel=$this->cel;	$correo=$this->correo;	$especialidad=$this->especialidad;
		$tipo=$this->tipo;	$con=$this->con;
			
        mysql_query("INSERT INTO profesor (nom, ape, doc, con, fecha, estado, dir, tel, cel, correo, especialidad, tipo) 
                                  VALUES ('$nom','$ape','$doc','$con','$fecha','$estado','$dir','$tel','$cel','$correo','$especialidad','$tipo')");
								  
    }
	
	function actualizar(){
       	$id=$this->id;		$nom=$this->nom;	$ape=$this->ape;	$doc=$this->doc;		$fecha=$this->fecha;	$estado=$this->estado;
		$dir=$this->dir;	$tel=$this->tel;	$cel=$this->cel;	$correo=$this->correo;	$especialidad=$this->especialidad;
		$tipo=$this->tipo;	$con=$this->con;
		
		mysql_query("UPDATE profesor SET nom='$nom',
										ape='$ape',
										fecha='$fecha',
										estado='$estado',
										dir='$dir',
										tel='$tel',
										cel='$cel',
										correo='$correo',
										especialidad='$especialidad',
										tipo='$tipo'
								WHERE id='$id'");
	}
}
?>