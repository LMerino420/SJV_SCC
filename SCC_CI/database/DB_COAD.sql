/**********************************************************************************
[CREACION DE LA BASE DE DATOS]
**********************************************************************************/
CREATE DATABASE db_coad;
USE db_coad;

/**********************************************************************************
[CREACION DE LAS TABLAS ]
**********************************************************************************/

/******[TIPO DE USUARIO]******/
create table tipo_usr
(
	idtipo int(10) not null AUTO_INCREMENT,
	perfil varchar(50),
	PRIMARY KEY(idtipo)
);

/******[USUARIOS]******/
create table usuario
(
	iduser int(10) not null AUTO_INCREMENT,
	u_nombre varchar(50),
	u_apellidos varchar(50),
	idtipo int(10),
	usuario varchar(25),
	pwd varchar(35),
	estado boolean,
	PRIMARY KEY(iduser),
	FOREIGN KEY (idtipo) REFERENCES tipo_usr(idtipo)
);

/******[TIPO DE TRIBUTACION]******/
create table tributacion 
(
	idtributo int(10) not null AUTO_INCREMENT,
    nombre varchar(200),
    PRIMARY KEY (idtributo)
);

/******[CONTRIBUYENTES]******/
create table contribuyente
(
	idcontribuyente int(10) not null auto_increment,
    nc int(14),
    titular varchar(200),
    estado varchar(40),
    n_nc int(14),
    idtributo int(10),
    PRIMARY KEY (idcontribuyente),
    FOREIGN KEY(idtributo) REFERENCES tributacion(idtributo) 
);

/******[PROPIEDADES]******/
create table propiedad
(
	idpropiedad int(10) not null auto_increment,
    idcontribuyente int(10),
    poblacion varchar(30),
    distrito varchar(100),
    calle varchar(65),
    n_casa varchar(40),
    propietario varchar(200),
    PRIMARY KEY (idpropiedad),
    FOREIGN KEY (idcontribuyente) REFERENCES contribuyente(idcontribuyente)
);

/******[TASAS DE COBRO]******/
create table tasas_cobro
(
    idcontribuyente int(10),
    anio int(4),
    alumbrado float (6,2),
    pavimentacion float (6,2),
    aseo float (6,2),
    mensualidad float (6,2),
    contrib_especial float(6,2),
    FOREIGN KEY (idcontribuyente) REFERENCES contribuyente(idcontribuyente)
);

/******[REGISTRO DE PAGOS]******/
create table registro_pagos
(
	idcontribuyente int(10),
    anio int(4),
    ene boolean,
    feb boolean,
    mar boolean,
    abr boolean,
    may boolean,
    jun boolean,
    jul boolean,
    ago boolean,
    sep boolean,
    oct boolean,
    nov boolean,
    dic boolean,
    FOREIGN KEY (idcontribuyente) REFERENCES contribuyente(idcontribuyente)
);

/******[ENCABEZADO DE TASAS MUNICIPALES]******/
create table enc_tasas
(
	idestadocuenta int(10) not null auto_increment,
    nc int(14),
    contribuyente varchar(200),
    propietario varchar(200),
    direccion varchar (240),
    emitido varchar(10),
    PRIMARY KEY(idestadocuenta)
);

/******[DETALLE DE TASAS MUNICIPALES]******/
create table detalle_tasas
(
	idestadocuenta int(10),
    anio int(4),
    cnt_meses int(4),
    periodo varchar(50),
    alumbrado_ec float(10,2),
    aseo_ec float(10,2),
    pavimento_ec float(10,2),
    mensualidad_ec float(10,2),
    cobro_periodo float(10,2),
    multa_parcial float(10,2),
    interes_parcial float(10,2),
    FOREIGN KEY (idestadocuenta) REFERENCES enc_tasas(idestadocuenta)
);

/******[PIE DE TASAS MUNICIPALES]******/
create table pie_tasas
(
	idestadocuenta int(10),
    meses_retraso int(3),
    total_calculo float(10,2),
    fiesta_ec float(10,2),
    multa_ec float(10,2),
    interes_ec float(10,2),
    total_pago float(10,2),
    observaciones varchar(250),
    FOREIGN KEY (idestadocuenta) REFERENCES enc_tasas(idestadocuenta)
);

/******[ECNABEZADO DE CONTRIBUCION ESPECIAL]******/
create table enc_especial
(
	idestadocuenta int(10) not null auto_increment,
    nc int(14),
    contribuyente varchar(200),
    propietario varchar(200),
    direccion varchar (240),
    emitido varchar(10),
    PRIMARY KEY(idestadocuenta)
);

/******[DETALLE DE CONTRIBUCION ESPECIAL]******/
create table detalle_especial
(
	idestadocuenta int(10),
    anio int(4),
    cnt_meses int(4),
    periodo varchar(50),
    aseo_ec float(10,2),
    mensualidad_ec float(10,2),
    cobro_periodo float(10,2),
    multa_parcial float(10,2),
    interes_parcial float(10,2),
    FOREIGN KEY (idestadocuenta) REFERENCES enc_especial(idestadocuenta)
);

/******[PIE DE CONTRIBUCION ESPECIAL]******/
create table pie_especial
(
	idestadocuenta int(10),
    meses_retraso int(3),
    total_calculo float(10,2),
    fiesta_ec float(10,2),
    multa_ec float(10,2),
    interes_ec float(10,2),
    total_pago float(10,2),
    observaciones varchar(250),
    FOREIGN KEY (idestadocuenta) REFERENCES enc_especial(idestadocuenta)
);

/******[PARAMETROS]******/
create table parametros 
(
	idparametro int(10) not null auto_increment,
    nombre varchar(150),
    valor float,
    PRIMARY KEY (idparametro)
);

/**********************************************************************************
[INSERT A LAS TABLAS]
**********************************************************************************/
INSERT INTO tipo_usr(perfil) VALUES ('ADMIN');
INSERT INTO tipo_usr(perfil) VALUES ('CUENTAS CORRIENTES');

INSERT INTO usuario(u_nombre,u_apellidos,idtipo,usuario,pwd,estado) VALUES ('Lev Andrei','Merino Torres',1,'lmerino',md5('merino16'),1);

INSERT INTO parametros(nombre,valor) VALUES ('Porcentaje de interes','0.008233');
INSERT INTO parametros(nombre,valor) VALUES ('Porcentaje de fiesta','0.05');
INSERT INTO parametros(nombre,valor) VALUES ('Mora 3 primeros meses','0.05');
INSERT INTO parametros(nombre,valor) VALUES ('Mora despues de los 3 primeros meses','0.1');

INSERT INTO tributacion(nombre) VALUES ('Tasas municipales');
INSERT INTO tributacion(nombre) VALUES ('Contribución especial');
INSERT INTO tributacion(nombre) VALUES ('Actividad económica');