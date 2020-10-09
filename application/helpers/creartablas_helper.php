<?php
	//***************************** TABLAS DE CONTABILIDAD **********************************//
	function tablaGastoFijos($id){
		return 'CREATE TABLE zavord5_conta.gastosFijo_'.$id.'(
			  idgastosFijo int(11) NOT NULL AUTO_INCREMENT,
			  nombre varchar(50) NOT NULL,
			  importe float NOT NULL DEFAULT "0",
			  iva int(11) DEFAULT "0",
			  PRIMARY KEY (`idgastosFijo`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
		
	}
	function tablaLibroBancos($id){
		return 'CREATE TABLE zavord5_conta.libroBancos_'.$id.'(
				  idlibroBanco int(11) NOT NULL AUTO_INCREMENT,
				  fecha date DEFAULT NULL,
				  noCheque varchar(45) DEFAULT NULL,
				  concepto varchar(150) DEFAULT NULL,
				  deposito double DEFAULT NULL,
				  egreso double DEFAULT NULL,
				  idegreso int(11) DEFAULT NULL,
				  idDeposito int(11) DEFAULT NULL,
				  idPago int(11) DEFAULT NULL,
				  PRIMARY KEY (idlibroBanco),
				  KEY fk_venta_idx'.$id.'(idDeposito),
				  CONSTRAINT fk_venta'.$id.' FOREIGN KEY (idDeposito) REFERENCES relacionVentas_'.$id.'(id) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaPagoSalarios($id){
		return 'CREATE TABLE zavord5_conta.pagoSalarios_'.$id.' (
			  idpago int(11) NOT NULL AUTO_INCREMENT,
			  cantidadPresta float NOT NULL,
			  cantidadLibre float NOT NULL,
			  fecha date NOT NULL,
			  quincena int(11) NOT NULL,
			  PRIMARY KEY (`idpago`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaParametros($id){
		return 'CREATE TABLE zavord5_conta.parametros_'.$id.' (
			  idparametro int(11) NOT NULL AUTO_INCREMENT,
			  nombre varchar(45) NOT NULL,
			  valor varchar(45) NOT NULL,
			  PRIMARY KEY (`idparametro`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaProveedores($id){
		return 'CREATE TABLE zavord5_conta.proveedores_'.$id.' (
			  idproveedor int(11) NOT NULL AUTO_INCREMENT,
			  nombre varchar(150) NOT NULL,
			  rfc varchar(45) NOT NULL,
			  PRIMARY KEY (`idproveedor`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaRelacionG($id){
		return 'CREATE TABLE zavord5_conta.relacionGastos_'.$id.' (
						  idrelacionG int(11) NOT NULL AUTO_INCREMENT,
						  fecha date NOT NULL,
						  idproveedor int(11) DEFAULT NULL,
						  importe float DEFAULT NULL,
						  iva float DEFAULT NULL,
						  total float DEFAULT NULL,
						  tipoGasto int(11) DEFAULT NULL,
						  factura varchar(45) DEFAULT NULL,
						  nota text,
						  PRIMARY KEY (`idrelacionG`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaRelacionV($id){
		return 'CREATE TABLE zavord5_conta.relacionVentas_'.$id.'(
				  id int(11) NOT NULL AUTO_INCREMENT,
				  fecha date DEFAULT NULL,
				  vp_efectivo float DEFAULT "0",
				  vp_cheque float DEFAULT "0",
				  vp_credito float DEFAULT "0",
				  vp_total float DEFAULT "0",
				  vf_efectivo float DEFAULT "0",
				  vf_cheque float DEFAULT "0",
				  vf_credito float DEFAULT "0",
				  vf_total float DEFAULT "0",
				  sinIva float DEFAULT "0",
				  conIva float DEFAULT "0",
				  idVentaAbono int(11) DEFAULT NULL,
				  concepto varchar(45) DEFAULT NULL,
  				  notas text,
  				  factura varchar(45) DEFAULT "Sin factura",
				  PRIMARY KEY (id),
				  KEY fk_recursiva_idx'.$id.'(idVentaAbono),
				  CONSTRAINT fk_recursiva'.$id.' FOREIGN KEY (idVentaAbono) REFERENCES relacionVentas_'.$id.'(id) ON DELETE CASCADE ON UPDATE NO ACTION
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function tablaSueldos($id){
		return 'CREATE TABLE zavord5_conta.sueldos_'.$id.' (
							  idsueldos int(11) NOT NULL AUTO_INCREMENT,
							  empleado varchar(150) NOT NULL,
							  importe int(11) NOT NULL,
							  prestaciones int(11) NOT NULL DEFAULT "0",
							  tipoPago int(11) NOT NULL,
							  PRIMARY KEY (`idsueldos`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	function insertaDatos($id){
		return 'INSERT INTO zavord5_conta.gastosFijo_'.$id.'(idgastosFijo,nombre,importe,iva)VALUES(1,"Sueldos",0,0);';
	}
	function insertaDatosPara($id){
		return 'INSERT INTO zavord5_conta.parametros_'.$id.'(nombre,valor)VALUES("Sueldos",0);';
	}

	//***************************** TABLAS DE CONTACTOS **************************************//
	function tablaContactos($id){
		return 'CREATE TABLE zavord5_contactos.contactos_'.$id.'(
							  id int(11) NOT NULL AUTO_INCREMENT,
							  nombre varchar(200) DEFAULT NULL,
							  apellidos varchar(200) DEFAULT NULL,
							  empresa varchar(200) DEFAULT NULL,
							  direccion varchar(200) DEFAULT NULL,
							  telefono varchar(45) DEFAULT NULL,
							  movil varchar(45) DEFAULT NULL,
							  email varchar(200) DEFAULT NULL,
							  pagina varchar(200) DEFAULT NULL,
							  cumple date DEFAULT NULL,
							  imagen varchar(150) DEFAULT NULL,
							  tipo varchar(100) DEFAULT NULL,
  							  comentarios text,
  							  puesto varchar(150) DEFAULT NULL,
							  PRIMARY KEY (id)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1';
	}

	function tablaVentas($id){
		return 'CREATE TABLE zavord5_contactos.ventas_'.$id.'(
							     id int(11) NOT NULL AUTO_INCREMENT,
								  concepto varchar(250) DEFAULT NULL,
								  fecha date DEFAULT NULL,
								  cantidad float DEFAULT NULL,
								  tipo int(11) DEFAULT NULL,
								  contacto int(11) NOT NULL,
								  idventa int(11) DEFAULT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
	}

	function tablaPendientes($id){
		return 'CREATE TABLE zavord5_contactos.pendientes_'.$id.'(
							 id int(11) NOT NULL AUTO_INCREMENT,
							  nombre varchar(150) DEFAULT NULL,
							  fecha date DEFAULT NULL,
							  hora varchar(45) DEFAULT NULL,
							  contacto int(11) NOT NULL,
							  fecha_fin date DEFAULT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1';
	}
//***************************** TABLAS DE PENDIENTES **************************************//
	
	function tablaIntegrantes($id){
		return 'CREATE TABLE zavord5_tareas.integrantes_'.$id.' (
  				idintegrante int(11) NOT NULL AUTO_INCREMENT,
  				nombre varchar(150) NOT NULL,
  				foto varchar(150) NOT NULL,
  				color varchar(45) DEFAULT NULL,
  				PRIMARY KEY (idintegrante)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	
	function tablasTareas($id){
		return 'CREATE TABLE zavord5_tareas.objetivos_'.$id.' (
  				id int(11) NOT NULL AUTO_INCREMENT,
  				tarea varchar(150) DEFAULT NULL,
  				hora varchar(6) DEFAULT NULL,
  				fecha date DEFAULT NULL,
  				intactivo int(11) DEFAULT NULL,
  				idintegrante int(11) DEFAULT NULL,
 				color varchar(45) DEFAULT NULL,
 				PRIMARY KEY (`id`),
  				KEY fk_integrante_idx (idintegrante),
  				CONSTRAINT fk_integrante'.$id.' FOREIGN KEY (idintegrante) REFERENCES integrantes_'.$id.' (idintegrante) ON DELETE CASCADE ON UPDATE NO ACTION
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}
	//******************************************* HISTOGRAMA *******************************************//

	function tablaEtapas($id){
		return 'CREATE TABLE zavord5_histograma.etapas_'.$id.' (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  nombre varchar(100) DEFAULT NULL,
		  descripcion text,
		  id_proyecto int(11) DEFAULT NULL,
		  imagen varchar(150) DEFAULT NULL,
		  estado int(11) DEFAULT NULL,
		  fecha_fin date DEFAULT NULL,
		  PRIMARY KEY (id),
		  KEY fk_proyecto_etapa_idx (id_proyecto),
		  CONSTRAINT fk_proyecto_etapa'.$id.' FOREIGN KEY (id_proyecto) REFERENCES proyecto_'.$id.' (id) ON DELETE CASCADE ON UPDATE SET NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
	}

	function tablaEventoComentario($id){
		return 'CREATE TABLE zavord5_histograma.evento_comentario_'.$id.' (
		  idevencom int(11) NOT NULL AUTO_INCREMENT,
		  idevento int(11) DEFAULT NULL,
		  comentario text,
		  id_perfil int(11) DEFAULT NULL,
		  fecha varchar(45) DEFAULT NULL,
		  archivo int(11) DEFAULT NULL,
		  nombreArchivo varchar(45) DEFAULT NULL,
		  PRIMARY KEY (idevencom),
		  KEY fk_idevento_comentario_idx (idevento),
		  CONSTRAINT fk_idevento_comentario'.$id.' FOREIGN KEY (idevento) REFERENCES eventos_'.$id.' (idevento) ON DELETE CASCADE ON UPDATE NO ACTION
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
	}

	function tablaEventos($id){
		return 'CREATE TABLE zavord5_histograma.eventos_'.$id.' (
		  idevento int(11) NOT NULL AUTO_INCREMENT,
		  titulo varchar(45) DEFAULT NULL,
		  contenido text,
		  idetapa int(11) DEFAULT NULL,
		  respuetas int(11) DEFAULT "0",
		  priori int(11) DEFAULT NULL,
		  estado int(11) DEFAULT NULL,
		  fecha varchar(50) DEFAULT NULL,
		  color varchar(45) DEFAULT NULL,
		  id_perfil int(11) DEFAULT NULL,
		  fecha_fin date DEFAULT NULL,
		  PRIMARY KEY (idevento)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}

	function tablaIntegrantes_histograma($id){
		return 'CREATE TABLE zavord5_histograma.integrantes_'.$id.' (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  id_perfil int(11) DEFAULT NULL,
		  id_proyecto int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY id_proyecto_idx (id_proyecto),
		  CONSTRAINT id_proyecto'.$id.' FOREIGN KEY (id_proyecto) REFERENCES proyecto_'.$id.' (id) ON DELETE SET NULL ON UPDATE CASCADE
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}

	function tablaProyecto($id){
		return 'CREATE TABLE zavord5_histograma.proyecto_'.$id.'(
		  id int(11) NOT NULL AUTO_INCREMENT,
		  nombre varchar(85) DEFAULT NULL,
		  descripcion varchar(800) DEFAULT NULL,
		  password varchar(150) DEFAULT NULL,
		  lider varchar(150) DEFAULT NULL,
		  estado varchar(45) DEFAULT NULL,
		  fecha date DEFAULT NULL,
		  fecha_fin date DEFAULT NULL,
		  archivado int(11) DEFAULT "0",
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;';
	}

	function tablaProyectoResponsable($id){
		return 'CREATE TABLE zavord5_histograma.proyecto_responsable_'.$id.' (
		  idetapa int(11) DEFAULT NULL,
		  idresponsable int(11) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
	}

	function triggerEventoAftInsert($id){
		return 'CREATE TRIGGER zavord5_histograma.evento_comentario_'.$id.'_AFTER_INSERT AFTER INSERT ON evento_comentario_'.$id.' FOR EACH ROW
		BEGIN
		declare actual int;
		declare newTotal int;
		set actual = (select respuetas from zavord5_histograma.eventos_'.$id.' where idevento = new.idevento);
		set newTotal = actual+1;
		update zavord5_histograma.eventos_'.$id.' set respuetas = newTotal where idevento = new.idevento;
		END';
	}
	function triggerEventoAftDelete($id){
		return 'CREATE  TRIGGER zavord5_histograma.evento_comentario_'.$id.'_AFTER_DELETE AFTER DELETE ON evento_comentario_'.$id.' FOR EACH ROW
		BEGIN
		declare actual int;
		declare newTotal int;
		set actual = (select respuetas from zavord5_histograma.eventos_'.$id.' where idevento = old.idevento);
		set newTotal = actual-1;
		update zavord5_histograma.eventos_'.$id.' set respuetas = newTotal where idevento = old.idevento;
		END';
	}
?>