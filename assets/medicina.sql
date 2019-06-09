
drop database if exists medicina;

create database medicina; 

use medicina;


create table perfiles(
 idperfil int not null primary key auto_increment,
 descripcion character varying(20)
);



insert into perfiles values(1,'PACIENTE');
insert into perfiles values(2,'DOCTOR');
insert into perfiles values(3,'SECRETARIA');


CREATE TABLE provincias(
 idprovincia VARCHAR(2) PRIMARY KEY NOT NULL,
 nombreprovincia VARCHAR(30) NOT NULL
);



CREATE TABLE cantones(
 idcanton VARCHAR(4) PRIMARY KEY NOT NULL,
 idprovincia VARCHAR(2) NOT NULL,
 nombrecanton VARCHAR(50) NOT NULL, 
 constraint foreign key (idprovincia) REFERENCES provincias(idprovincia) ON  UPDATE CASCADE ON DELETE RESTRICT	  
);

CREATE table usuarios(
 codusuario int not null primary key auto_increment,
 dni character varying(10) unique,
 email character varying(50) not null unique,
 clave character varying(20),
 nombre1 character varying(20),
 nombre2 character varying(20),
 apellido1 character varying(20),
 apellido2 character varying(20),
 direccion character varying(100),
 telefono character varying(10),
 idcanton character varying(4),
 fechanacimiento date,
 idperfil int not null,
 constraint foreign key(idcanton) references cantones(idcanton)  ON  UPDATE CASCADE ON DELETE RESTRICT,
 constraint foreign key(idperfil) references perfiles(idperfil)  ON  UPDATE CASCADE ON DELETE RESTRICT
);



create table estados(
 idestado int not null primary key auto_increment,
 descripcion character varying(20)
);

insert into estados values(1,'ENVIADA');
insert into estados values(2,'EN ESPERA');
insert into estados values(3,'ATENDIDA');
insert into estados values(4,'RECHAZADA');

create table citas(
 idcita int primary key auto_increment,
 fecha date,
 hora time,
 idcanton character varying(4)not null,
 codusuario int not null,
 idestado int not null default 1,
 constraint foreign key(idcanton) references cantones(idcanton)  ON  UPDATE CASCADE ON DELETE RESTRICT,
 constraint foreign key(idestado) references estados(idestado)  ON  UPDATE CASCADE ON DELETE RESTRICT,
 constraint foreign key(codusuario) references usuarios(codusuario)  ON  UPDATE CASCADE ON DELETE RESTRICT
);


create table categorias(
 idcategoria int not null primary key auto_increment,
 descripcion character varying(30) not null
);

insert into categorias values(default,' ANTIBIÓTICOS');
insert into categorias values(default,' ANTIBACTERIANO');
insert into categorias values(default,' ANTIVIRAL');
insert into categorias values(default,' ANTIPARASITARIO');
insert into categorias values(default,' ANTIALÉRGICO');


create table medicinas(
 idmedicina int not null primary key auto_increment,
 descripcion character varying(50) not null,
 idcategoria int not null,
 constraint foreign key(idcategoria) references categorias(idcategoria) ON UPDATE CASCADE ON DELETE RESTRICT
);


insert into medicinas values(default,'PARACETAMOL',1);
insert into medicinas values(default,'DICLOFENACO',1);
insert into medicinas values(default,'TETRACICLINA',1);
insert into medicinas values(default,'APRONAX',1);


create table receta(
  idreceta int not null primary key auto_increment, 
  descripcion character varying(100),
  fecha date not null,
  codusuario int not null,
  constraint foreign key(codusuario) references usuarios(codusuario)  ON  UPDATE CASCADE ON DELETE RESTRICT
);

DROP FUNCTION IF EXISTS getIDReceta;
DELIMITER //
create  function getIDReceta() 
returns int 
DETERMINISTIC
begin
 DECLARE cod int;
 select max(idreceta) into cod from receta;
 if cod is null then
  
  set cod=1;
  else
  set cod=cod+1;
 end if;
 return cod;
end//
DELIMITER ;

select getIDReceta();

create table detallereceta(
  idreceta int not null,
  idmedicina int,
  dosis character varying(100),
  observacion character varying(100),
  cantidad int,
  constraint foreign key(idreceta) references receta(idreceta)  ON  UPDATE CASCADE ON DELETE RESTRICT,
  constraint foreign key(idmedicina) references medicinas(idmedicina)  ON  UPDATE CASCADE ON DELETE RESTRICT
);

create table historial(
 idhistorial int not null primary key auto_increment,
 diagnostico character varying(100),
 fecha date null,
 idcita int not null,
 observacion character varying(100),
 codusuario int not null,
  constraint foreign key(codusuario) references usuarios(codusuario)  ON  UPDATE CASCADE ON DELETE RESTRICT,
 constraint foreign key(idcita) references citas(idcita)  ON  UPDATE CASCADE ON DELETE RESTRICT 
);



insert into provincias values('01','AZUAY');
insert into provincias values('02','BOLIVAR');
insert into provincias values('03','CAÑAR');
insert into provincias values('04','CARCHI');
insert into provincias values('05','COTOPAXI');
insert into provincias values('06','CHIMBORAZO');
insert into provincias values('07','EL ORO');
insert into provincias values('08','ESMERALDAS');
insert into provincias values('09','GUAYAS');
insert into provincias values('10','IMBABURA');
insert into provincias values('11','LOJA');
insert into provincias values('12','LOS RÍOS');
insert into provincias values('13','MANABI');
insert into provincias values('14','MORONA SANTIAGO');
insert into provincias values('15','NAPO');
insert into provincias values('16','PASTAZA');
insert into provincias values('17','PICHINCHA');
insert into provincias values('18','TUNGURAHUA');
insert into provincias values('19','ZAMORA CHINCHIPE');
insert into provincias values('20','GALAPAGOS');
insert into provincias values('21','SUCUMBIOS');
insert into provincias values('22','ORELLANA');
insert into provincias values('23','SANTO DOMINGO DE LOS TSACHILAS');
insert into provincias values('24','SANTA ELENA');
insert into provincias values('90','ZONAS NO DELIMITADAS');



insert into cantones values('0102','01','GIRÓN');
insert into cantones values('0103','01','GUALACEO');
insert into cantones values('0104','01','NABÓN');
insert into cantones values('0105','01','PAUTE');
insert into cantones values('0106','01','PUCARA');
insert into cantones values('0107','01','SAN FERNANDO');
insert into cantones values('0108','01','SANTA ISABEL');
insert into cantones values('0109','01','SIGSIG');
insert into cantones values('0110','01','OÑA');
insert into cantones values('0111','01','CHORDELEG');
insert into cantones values('0112','01','EL PAN');
insert into cantones values('0113','01','SEVILLA DE ORO');
insert into cantones values('0114','01','GUACHAPALA');
insert into cantones values('0115','01','CAMILO PONCE ENRÍQUEZ');
insert into cantones values('0201','02','GUARANDA');
insert into cantones values('0202','02','CHILLANES');
insert into cantones values('0203','02','CHIMBO');
insert into cantones values('0204','02','ECHEANDÍA');
insert into cantones values('0205','02','SAN MIGUEL');
insert into cantones values('0206','02','CALUMA');
insert into cantones values('0207','02','LAS NAVES');
insert into cantones values('0301','03','AZOGUES');
insert into cantones values('0302','03','BIBLIÁN');
insert into cantones values('0303','03','CAÑAR');
insert into cantones values('0304','03','LA TRONCAL');
insert into cantones values('0305','03','EL TAMBO');
insert into cantones values('0306','03','DÉLEG');
insert into cantones values('0307','03','SUSCAL');
insert into cantones values('0401','04','TULCÁN');
insert into cantones values('0402','04','BOLÍVAR');
insert into cantones values('0403','04','ESPEJO');
insert into cantones values('0404','04','MIRA');
insert into cantones values('0405','04','MONTÚFAR');
insert into cantones values('0406','04','SAN PEDRO DE HUACA');
insert into cantones values('0501','05','LATACUNGA');
insert into cantones values('0502','05','LA MANÁ');
insert into cantones values('0503','05','PANGUA');
insert into cantones values('0504','05','PUJILI');
insert into cantones values('0505','05','SALCEDO');
insert into cantones values('0506','05','SAQUISILÍ');
insert into cantones values('0507','05','SIGCHOS');
insert into cantones values('0601','06','RIOBAMBA');
insert into cantones values('0602','06','ALAUSI');
insert into cantones values('0603','06','COLTA');
insert into cantones values('0604','06','CHAMBO');
insert into cantones values('0605','06','CHUNCHI');
insert into cantones values('0606','06','GUAMOTE');
insert into cantones values('0607','06','GUANO');
insert into cantones values('0608','06','PALLATANGA');
insert into cantones values('0609','06','PENIPE');
insert into cantones values('0610','06','CUMANDÁ');
insert into cantones values('0701','07','MACHALA');
insert into cantones values('0702','07','ARENILLAS');
insert into cantones values('0703','07','ATAHUALPA');
insert into cantones values('0704','07','BALSAS');
insert into cantones values('0705','07','CHILLA');
insert into cantones values('0706','07','EL GUABO');
insert into cantones values('0707','07','HUAQUILLAS');
insert into cantones values('0708','07','MARCABELÍ');
insert into cantones values('0709','07','PASAJE');
insert into cantones values('0710','07','PIÑAS');
insert into cantones values('0711','07','PORTOVELO');
insert into cantones values('0712','07','SANTA ROSA');
insert into cantones values('0713','07','ZARUMA');
insert into cantones values('0714','07','LAS LAJAS');
insert into cantones values('0801','08','ESMERALDAS');
insert into cantones values('0802','08','ELOY ALFARO');
insert into cantones values('0803','08','MUISNE');
insert into cantones values('0804','08','QUININDÉ');
insert into cantones values('0805','08','SAN LORENZO');
insert into cantones values('0806','08','ATACAMES');
insert into cantones values('0807','08','RIOVERDE');
insert into cantones values('0808','08','LA CONCORDIA');
insert into cantones values('0901','09','GUAYAQUIL');
insert into cantones values('0902','09','ALFREDO BAQUERIZO MORENO (JUJÁN)');
insert into cantones values('0903','09','BALAO');
insert into cantones values('0904','09','BALZAR');
insert into cantones values('0905','09','COLIMES');
insert into cantones values('0906','09','DAULE');
insert into cantones values('0907','09','DURÁN');
insert into cantones values('0908','09','EL EMPALME');
insert into cantones values('0909','09','EL TRIUNFO');
insert into cantones values('0910','09','MILAGRO');
insert into cantones values('0911','09','NARANJAL');
insert into cantones values('0912','09','NARANJITO');
insert into cantones values('0913','09','PALESTINA');
insert into cantones values('0914','09','PEDRO CARBO');
insert into cantones values('0916','09','SAMBORONDÓN');
insert into cantones values('0918','09','SANTA LUCÍA');
insert into cantones values('0919','09','SALITRE (URBINA JADO)');
insert into cantones values('0920','09','SAN JACINTO DE YAGUACHI');
insert into cantones values('0921','09','PLAYAS');
insert into cantones values('0922','09','SIMÓN BOLÍVAR');
insert into cantones values('0923','09','CORONEL MARCELINO MARIDUEÑA');
insert into cantones values('0924','09','LOMAS DE SARGENTILLO');
insert into cantones values('0925','09','NOBOL');
insert into cantones values('0927','09','GENERAL ANTONIO ELIZALDE');
insert into cantones values('0928','09','ISIDRO AYORA');
insert into cantones values('1001','10','IBARRA');
insert into cantones values('1002','10','ANTONIO ANTE');
insert into cantones values('1003','10','COTACACHI');
insert into cantones values('1004','10','OTAVALO');
insert into cantones values('1005','10','PIMAMPIRO');
insert into cantones values('1006','10','SAN MIGUEL DE URCUQUÍ');
insert into cantones values('1101','11','LOJA');
insert into cantones values('1102','11','CALVAS');
insert into cantones values('1103','11','CATAMAYO');
insert into cantones values('1104','11','CELICA');
insert into cantones values('1105','11','CHAGUARPAMBA');
insert into cantones values('1106','11','ESPÍNDOLA');
insert into cantones values('1107','11','GONZANAMÁ');
insert into cantones values('1108','11','MACARÁ');
insert into cantones values('1109','11','PALTAS');
insert into cantones values('1110','11','PUYANGO');
insert into cantones values('1111','11','SARAGURO');
insert into cantones values('1112','11','SOZORANGA');
insert into cantones values('1113','11','ZAPOTILLO');
insert into cantones values('1114','11','PINDAL');
insert into cantones values('1115','11','QUILANGA');
insert into cantones values('1116','11','OLMEDO');

insert into cantones values('1201','12','BABAHOYO');
INSERT into usuarios values(default,'1201','1','1','Paciente Gregory','P.','House','Software',
'sdsdsd','sdssss','1201','1991-01-01',1);

INSERT into usuarios values(default,'1203','2','2','Dr. Gregory','P.','House','Software',
'sdsdsd','sdssss','1201','1991-01-01',2);

INSERT into usuarios values(default,'1204','3','3','Secretario Gregory','P.','House','Software',
'sdsdsd','sdssss','1201','1991-01-01',3);


insert into cantones values('1202','12','BABA');
insert into cantones values('1203','12','MONTALVO');
insert into cantones values('1204','12','PUEBLOVIEJO');
insert into cantones values('1205','12','QUEVEDO');
insert into cantones values('1206','12','URDANETA');
insert into cantones values('1207','12','VENTANAS');
insert into cantones values('1208','12','VINCES');
insert into cantones values('1209','12','PALENQUE');
insert into cantones values('1210','12','BUENA FÉ');
insert into cantones values('1211','12','VALENCIA');
insert into cantones values('1212','12','MOCACHE');
insert into cantones values('1213','12','QUINSALOMA');
insert into cantones values('1301','13','PORTOVIEJO');
insert into cantones values('1302','13','BOLÍVAR');
insert into cantones values('1303','13','CHONE');
insert into cantones values('1304','13','EL CARMEN');
insert into cantones values('1305','13','FLAVIO ALFARO');
insert into cantones values('1306','13','JIPIJAPA');
insert into cantones values('1307','13','JUNÍN');
insert into cantones values('1308','13','MANTA');
insert into cantones values('1309','13','MONTECRISTI');
insert into cantones values('1310','13','PAJÁN');
insert into cantones values('1311','13','PICHINCHA');
insert into cantones values('1312','13','ROCAFUERTE');
insert into cantones values('1313','13','SANTA ANA');
insert into cantones values('1314','13','SUCRE');
insert into cantones values('1315','13','TOSAGUA');
insert into cantones values('1316','13','24 DE MAYO');
insert into cantones values('1317','13','PEDERNALES');
insert into cantones values('1318','13','OLMEDO');
insert into cantones values('1319','13','PUERTO LÓPEZ');
insert into cantones values('1320','13','JAMA');
insert into cantones values('1321','13','JARAMIJÓ');
insert into cantones values('1322','13','SAN VICENTE');
insert into cantones values('1401','14','MORONA');
insert into cantones values('1402','14','GUALAQUIZA');
insert into cantones values('1403','14','LIMÓN INDANZA');
insert into cantones values('1404','14','PALORA');
insert into cantones values('1405','14','SANTIAGO');
insert into cantones values('1406','14','SUCÚA');
insert into cantones values('1407','14','HUAMBOYA');
insert into cantones values('1408','14','SAN JUAN BOSCO');
insert into cantones values('1409','14','TAISHA');
insert into cantones values('1410','14','LOGROÑO');
insert into cantones values('1411','14','PABLO SEXTO');
insert into cantones values('1412','14','TIWINTZA');
insert into cantones values('1501','15','TENA');
insert into cantones values('1503','15','ARCHIDONA');
insert into cantones values('1504','15','EL CHACO');
insert into cantones values('1507','15','QUIJOS');
insert into cantones values('1509','15','CARLOS JULIO AROSEMENA TOLA');
insert into cantones values('1601','16','PASTAZA');
insert into cantones values('1602','16','MERA');
insert into cantones values('1603','16','SANTA CLARA');
insert into cantones values('1604','16','ARAJUNO');
insert into cantones values('1701','17','QUITO');
insert into cantones values('1702','17','CAYAMBE');
insert into cantones values('1703','17','MEJIA');
insert into cantones values('1704','17','PEDRO MONCAYO');
insert into cantones values('1705','17','RUMIÑAHUI');
insert into cantones values('1707','17','SAN MIGUEL DE LOS BANCOS');
insert into cantones values('1708','17','PEDRO VICENTE MALDONADO');
insert into cantones values('1709','17','PUERTO QUITO');
insert into cantones values('1801','18','AMBATO');
insert into cantones values('1802','18','BAÑOS DE AGUA SANTA');
insert into cantones values('1803','18','CEVALLOS');
insert into cantones values('1804','18','MOCHA');
insert into cantones values('1805','18','PATATE');
insert into cantones values('1806','18','QUERO');
insert into cantones values('1807','18','SAN PEDRO DE PELILEO');
insert into cantones values('1808','18','SANTIAGO DE PÍLLARO');
insert into cantones values('1809','18','TISALEO');
insert into cantones values('1901','19','ZAMORA');
insert into cantones values('1902','19','CHINCHIPE');
insert into cantones values('1903','19','NANGARITZA');
insert into cantones values('1904','19','YACUAMBI');
insert into cantones values('1905','19','YANTZAZA (YANZATZA)');
insert into cantones values('1906','19','EL PANGUI');
insert into cantones values('1907','19','CENTINELA DEL CÓNDOR');
insert into cantones values('1908','19','PALANDA');
insert into cantones values('1909','19','PAQUISHA');
insert into cantones values('2001','20','SAN CRISTÓBAL');
insert into cantones values('2002','20','ISABELA');
insert into cantones values('2003','20','SANTA CRUZ');
insert into cantones values('2101','21','LAGO AGRIO');
insert into cantones values('2102','21','GONZALO PIZARRO');
insert into cantones values('2103','21','PUTUMAYO');
insert into cantones values('2104','21','SHUSHUFINDI');
insert into cantones values('2105','21','SUCUMBÍOS');
insert into cantones values('2106','21','CASCALES');
insert into cantones values('2107','21','CUYABENO');
insert into cantones values('2201','22','ORELLANA');
insert into cantones values('2202','22','AGUARICO');
insert into cantones values('2203','22','LA JOYA DE LOS SACHAS');
insert into cantones values('2204','22','LORETO');
insert into cantones values('2301','23','SANTO DOMINGO');
insert into cantones values('2401','24','SANTA ELENA');
insert into cantones values('2402','24','LA LIBERTAD');
insert into cantones values('2403','24','SALINAS');
insert into cantones values('9001','90','LAS GOLONDRINAS');
insert into cantones values('9003','90','MANGA DEL CURA');
insert into cantones values('9004','90','EL PIEDRERO');
