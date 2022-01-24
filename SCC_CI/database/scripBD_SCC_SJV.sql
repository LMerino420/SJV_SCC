/**********************************************************************************
[CONSULTAS DE LAS TABLAS] count(*) *
**********************************************************************************/
USE db_coad;
SELECT * FROM tipo_usr;
SELECT * FROM usuario;
SELECT * FROM parametros;
SELECT * FROM tributacion;

SELECT * FROM contribuyente;
SELECT count(*) FROM contribuyente;

SELECT * FROM propiedad;
SELECT count(*) FROM propiedad;

SELECT * FROM tasas_cobro;
SELECT count(*) FROM tasas_cobro;

SELECT * FROM registro_pagos;
SELECT count(*) FROM registro_pagos;

SELECT * FROM enc_tasas;
SELECT * FROM detalle_tasas;
SELECT * FROM pie_tasas;

SELECT * FROM enc_especial;
SELECT * FROM detalle_especial;
SELECT * FROM pie_especial;

/**********************************************************************************
[LIMPIAR/ELIMINAR/EDITAR TABLAS SIN RESTRICCION DE LLAVES FORANEAS]
**********************************************************************************/
/*ELIMINAR TABLA*/
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE enc_tasas;
DROP TABLE detalle_tasas;
DROP TABLE pie_tasas;
SET FOREIGN_KEY_CHECKS=1;

/*BORRAR TODOS LOS DATOS DE LA TABLA*/
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE enc_tasas;
TRUNCATE TABLE detalle_tasas;
TRUNCATE TABLE pie_tasas;
SET FOREIGN_KEY_CHECKS=1;

SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE enc_especial;
TRUNCATE TABLE detalle_especial;
TRUNCATE TABLE pie_especial;
SET FOREIGN_KEY_CHECKS=1;

SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE contribuyente;
TRUNCATE TABLE propiedad;
TRUNCATE TABLE tasas_cobro;
SET FOREIGN_KEY_CHECKS=1;

/*ELIMINAR REGISTROS ESPECIFICOS*/
SET SQL_SAFE_UPDATES = 0;
DELETE FROM enc_tasas WHERE idestadocuenta = 3;
SET SQL_SAFE_UPDATES = 1;

SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE registro_pagos;
SET FOREIGN_KEY_CHECKS=1;

/**********************************************************************************
[CONSULTAS PARA EL FUNCIONAMIETO DEL SISTEMA]
**********************************************************************************/
SELECT * 
FROM contribuyente AS C
INNER JOIN propiedad AS P ON C.idcontribuyente = P.idcontribuyente
WHERE C.idcontribuyente = 3855;
/*LISTAR CONTRIBUYENTES EN VISTA EST_CUENTA*/

SELECT count(*) 
FROM contribuyente AS C
LEFT JOIN propiedad AS P ON C.idcontribuyente = P.idcontribuyente
LEFT JOIN tributacion AS T ON C.idtributo = T.idtributo
WHERE titular like '%REINA%' limit 2,4;

SELECT c.idtributo, t.nombre
FROM contribuyente as c
LEFT JOIN tributacion as t ON c.idtributo = t.idtributo
WHERE NC = 2015106;

SELECT idcontribuyente
FROM contribuyente
WHERE nc = 2015106;

/*LISTAR CONTRIBUYENTES EN VISTA EST_CUENTA*/

SELECT DISTINCT anio 
FROM registro_pagos
WHERE idcontribuyente = 3855;
/*LISTAR LOS AÑOS REGISTRADOS*/

SELECT *
FROM tasas_cobro
WHERE idcontribuyente = 3083 AND anio = 2012;
/*OBTENER TASAS DE COBRO SEGUN AÑO Y CONTRIBUYENTE*/

SELECT * FROM tasas_cobro WHERE idcontribuyente = 3083;

SELECT * 
FROM registro_pagos
WHERE idcontribuyente = 1 AND anio = 2010;
/*OBTENER REGISTRO DE PAGOS SEGUN AÑO Y CONTRIBUYENTE*/ 

SELECT MAX(idestadocuenta) AS nro
FROM estadocuenta_enc;
/*OBTENER EL ULTIMO ID INGRESADO PARA EN ESTADO DE CUENTA*/

SELECT * 
FROM detalle_especial WHERE idestadocuenta = 5;
/*LISTAR EL DETALLE DEL ESTADO DE CUENTA*/

DELETE FROM detalle_especial WHERE idestadocuenta = 2  AND anio = 2014 AND periodo = 'SEP-' ;
/*ELIMINAR DETALLE DEL ESTADO DE CUENTA*/

SELECT TIMESTAMPDIFF(MONTH, '2021-01-01', now()) AS meses;

SELECT TIMESTAMPDIFF(MONTH, '2021-12-14', now()) AS meses;
/*OBTENER LA DIFERENCIA DE MESES ENTRE UNA FECHA HASTA LA FECHA*/

SELECT SUM(cnt_meses) AS cantidad FROM  estadocuenta_detalle WHERE idestadocuenta = 1;
/*OBTENER LA SUMA DE MESES QUE SE CANCELAN POR ESTADO DE CUENTA*/

UPDATE parametros SET valor=0.008233 WHERE idparametro=1;
/*ACTUALIZAR EL VALOR DEL PARAMETRO*/

SELECT valor AS interes FROM parametros WHERE idparametro=1;
/*OBTENER EL PORCENTAJE DE CALCULO DE INTERES*/

SELECT valor AS fiesta FROM parametros WHERE idparametro=2;
/*OBTENER EL PORCENTAJE DE CALCULO DE FIESTA*/

SELECT * FROM estadocuenta_pie WHERE idestadocuenta=1;
/*VERIFICAR SI YA EXISTE REGISTRO PARA ESA CUENTA Y NO REPETIR VALORES*/

SELECT * from contribuyente where tributo IS NULL;
/*OBTENER LA LISTA DE CONTRIBUYENTES SIN TIPO DE TRIBUTACION ASIGNADO*/

UPDATE contribuyente SET idtributo = null WHERE idcontribuyente = 1;
/*ACTUALIZAR EL TIPO DE TRIBUTACION DEL CADA CODNTRIBUYENTE*/

SELECT *
FROM enc_tasas
WHERE nc = 2015106 
LIMIT 1;

SELECT idestadocuenta
FROM enc_tasas
WHERE nc= 2015106;

SELECT DISTINCT anio 
FROM detalle_tasas
WHERE idestadocuenta = 2;

SELECT *
FROM detalle_tasas
WHERE idestadocuenta = 1;

SELECT *
FROM detalle_tasas
WHERE idestadocuenta = 1 AND anio = 2015;

SELECT sum(cnt_meses)
FROM detalle_tasas
WHERE idestadocuenta = 1 AND anio = 2010;

SELECT sum(cobro_periodo)
FROM detalle_tasas
WHERE idestadocuenta = 1 AND anio = 2010;

SELECT sum(multa_parcial)
FROM detalle_tasas
WHERE idestadocuenta = 1 AND anio = 2010;