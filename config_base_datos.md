# Introduccion Bases de Datos 

## Iniciamos base de datos (*Linux o Mac*)

```
mysql -u root -p
```

### **Ver Bases de Datos**

*Obligatorio ; al final*
```
SHOW DATABASES;
```

### **Crear Base de Datos**


```
CREATE DATABASE appsalon;
```


### *Utilizar Base de Datos*


```
USE appsalon;
```
```
SHOW TABLES;
```

### *Crear Tabla*


```
CREATE TABLE servicios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    PRIMARY KEY (id)
    );
```
```
SHOW TABLES;
```
```
DESCRIBE servicios;
```

## CRUD (*Create Read Update Delete*)

*Crear Leer Actualizar Eliminar*


### **Insertar Valores en una Base de Datos**
### *Create*

```
INSERT INTO servicios (nombre, precio) VALUES ("Corte de Cabello de Adulto", 80);
```

```
INSERT INTO servicios (nombre, precio) VALUES ("Corte de Cabello de Nino", 60);
```

#### *Insertar Varios Valores*
```
INSERT INTO servicios (nombre, precio) VALUES
("Peinado Mujer", 80),
("Peinado Hombre", 60);
```



### **Seleccionar Elementos de una Tabla**
### *Read*

```
SELECT * FROM servicios;
```

```
SELECT nombre FROM servicios;
```

```
SELECT nombre, precio FROM servicios;
```

```
SELECT id, nombre, precio FROM servicios;
```

#### *Cambiar orden de la consulta*

```
SELECT id, nombre, precio FROM servicios ORDER BY precio;
```

#### *Cambiar orden de la consulta en orden ascendente o descendente*

```
SELECT id, nombre, precio FROM servicios ORDER BY precio ASC;
```
 
```markdown
SELECT id, nombre, precio FROM servicios ORDER BY precio DESC;
```


```markdown
SELECT id, nombre, precio FROM servicios ORDER BY id DESC;
```


```markdown
SELECT id, nombre, precio FROM servicios ORDER BY id ASC;
```


#### *Limitar la consulta*

```
SELECT id, nombre, precio FROM servicios LIMIT 2;
```

```markdown
SELECT id, nombre, precio FROM servicios ORDER BY id DESC LIMIT 2;
```


#### *Mostrar de acuerdo al id o producto*


```markdown
SELECT id, nombre, precio FROM servicios WHERE ID = 3;
```


```markdown
SELECT id, nombre, precio FROM servicios WHERE ID = 1;
```

```
SELECT id, nombre, precio FROM servicios WHERE ID = 4;
```
 
### **Seleccionar Elementos de una Tabla**
### *Update*

```
SELECT * FROM servicios;
```

```
UPDATE servicios SET precio = 70 WHERE id = 2;
```
```
UPDATE servicios SET nombre = "Corte de Cabello de Nino Actualizado" WHERE id = 2;
```
```
UPDATE servicios SET nombre = "Corte de Cabello de Adulto ACTUALIZADO", PRECIO = 120 WHERE id = 1;
```

### **Eliminar Registros**
### *Delete*

```
SELECT * FROM servicios;
```

```
DELETE FROM servicios WHERE id = 1;
```
```
DELETE FROM servicios WHERE id = 4;
```

- Insertamos uno nuevo y vemos que el id continua
```
INSERT INTO servicios (nombre, precio) VALUES ("Corte de Cabello de Adulto", 145);
```

## Otros usos en las Tablas

### **Agregar un campo extra a la tabla**

```
USE appsalon;
```
```
ALTER TABLE servicios ADD descripcion VARCHAR(100) NOT NULL
```

### **Modificar columna existente**

```
USE appsalon;
ALTER TABLE servicios CHANGE descripcion nuevonombre VARCHAR(11) NOT NULL
```
```
ALTER TABLE servicios CHANGE nuevonombre descripcion VARCHAR(100) NOT NULL;
```
```
INSERT INTO servicios (nombre, precio, descripcion) VALUES ("Corte", 100, "Corte de Cabello de Adulto");
```

### **Eliminar un campo extra a la tabla**
```
ALTER TABLE servicios DROP COLUMN description;
```

### **Agregar una nueva tabla**

```
CREATE TABLE equipos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    producto VARCHAR(200) NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    PRIMARY KEY (id)
    );
```

- #### Ver Tablas
```
SHOW TABLES;
```
- #### Ver Estructura de una tabla
```
DESCRIBE equipos;
```

### **Eliminar Tablas**
- ##### Nunca pregunta si desea eliminarla, solo lo hace

```
DROP TABLE equipos;
```

```markdown
CREATE TABLE reservaciones (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    apellido VARCHAR(60) NOT NULL,
    hora TIME DEFAULT NULL,
    fecha DATE DEFAULT NULL,
    servicios VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
    );
```

### [Importar datos de Gist](https://gist.github.com/juanpablogdl/13cd6c6e5bf39a3ccff369242ea0a235)


### **Seleccionar Servicios por Precio**
```
SELECT * FROM servicios;
```
```
SELECT * FROM servicios WHERE precio > 90;
```
```
SELECT * FROM servicios WHERE precio >= 80;
```
```
SELECT * FROM servicios WHERE precio < 80;
```
```
SELECT * FROM servicios WHERE precio <= 80;
```
```
SELECT * FROM servicios WHERE precio = 80;
```
```
SELECT * FROM servicios WHERE precio BETWEEN 100 AND 200;
```


### **Funciones Agregadoras**
```
SELECT * FROM reservaciones;
```
```
SELECT COUNT(id), fecha /* Cuenta el id crea tabla COUNT(id) y crea tabla fecha */
```
```
FROM reservaciones  /* Extrae los datos de reservaciones */
```
```
GROUP BY fecha /* Agrupar por fechas */
```
```
ORDER BY COUNT(id) DESC;  /* cuantas veces aparece esa fecha contando el id */
```
```
SELECT SUM(precio) AS totalServicios FROM servicios; /* Suma el total de los servicios y me crea una tabla de forma virtual */
```
```
SELECT MIN(precio) AS precioMenor FROM servicios;
```
```
SELECT MAX(precio) AS precioMayor FROM servicios;
```


### **Como buscar en SQL**
```
SELECT * FROM servicios;
```
```
SELECT * FROM servicios WHERE nombre LIKE 'Corte%'; /* El simbolo % significa que inicia con Corte */
```
```
SELECT * FROM servicios WHERE nombre LIKE '%Cabello'; /* El % significa que busque la palabra que finalice con Cabello */
```
```
SELECT * FROM servicios WHERE nombre LIKE '%Cabello%'; /* El % % significa que busque la palabra tenga Cabello */
```

### **Unir Columnas**
```
SELECT * FROM reservaciones;  /* Tenemos el nombre y apellido separados */
```
```
SELECT CONCAT(nombre, ' ', apellido) AS nombreCompleto FROM reservaciones;
```
```
SELECT * FROM reservaciones
WHERE CONCAT(nombre, " ", apellido) LIKE '%Ana Preciado%';
```
```
SELECT hora, fecha, CONCAT(nombre, ' ', apellido) AS 'Nombre Completo'
FROM reservaciones
WHERE CONCAT(nombre, ' ', apellido)
LIKE '%Ana Preciado%'
```

### **Revisar por Multiples Condiciones**
```
SELECT * FROM reservaciones WHERE id IN(1,3);
```
```
SELECT * FROM reservaciones WHERE fecha = "2021-06-28";
```
```
SELECT * FROM reservaciones WHERE fecha = "2021-06-28" AND id = 1;
```
```
SELECT * FROM reservaciones WHERE fecha = "2021-06-28" AND id IN(1, 10);
```
```
SELECT * FROM reservaciones WHERE fecha = "2021-06-28" AND id = 1 AND nombre = 'Juan';
```

### **Reglas de Normalizacion o Formas Normales**

|Reglas  |
|---------|
|1NF     |
|2NF     |
|3NF     |
|Denormalizacion     |

 
## Diagramas ER

### **Diagramas Entidad Relacion**

- ##### Cardinalidad

```markdown
-----|-   Una

-----<-    Muchas

----||-    Una (y solo una)

----O|-    Cero o Una

----|<-    Una o Muchas

----O<-    Cero o Muchas
```


```
SHOW TABLES;
```

- ##### Eliminamos las tablas y solo dejamos la de servicios

```markdown
DROP TABLE equipos;
```


```markdown
DROP TABLE reservaciones;
```
- ##### Creamos tabla servicios

```markdown
CREATE TABLE clientes (
        id INT(11) NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(60) NOT NULL,
        apellido VARCHAR(60) NOT NULL,
        telefono VARCHAR(12) NOT NULL,
        email VARCHAR(30) NOT NULL UNIQUE,
        PRIMARY KEY (id)
        );
```

```markdown
SHOW TABLES;
```

- ##### Insertamos un cliente

```markdown
INSERT INTO clientes (nombre, apellido, telefono, email) VALUES
("Didier", "Giraldo", 3340116324, "disaned@gmail.com");
```

```markdown
SELECT * FROM clientes
```

```markdown
SELECT * FROM servicios
```

```markdown
CREATE TABLE citas (
        id INT(11) NOT NULL AUTO_INCREMENT,
        fecha DATE NOT NULL,
        hora TIME NOT NULL,
        clienteId INT(11) NOT NULL,
        PRIMARY KEY (id), /* Decimos cual va a ser la llave primaria (PK) */
        KEY clienteId (clienteId),  /* Seleccionamos columna clienteID */
        CONSTRAINT cliente_FK  /* Aqui le daremos limites a la columna clienteId seleccionada */
        FOREIGN KEY (clienteId)  /* Le decimos cual es la llave forenea (FK) */
        REFERENCES clientes (id) /* En que o donde va estar relacionada la llave foranea (FK) */
);
```

```markdown
DESCRIBE citas;
```


```markdown
DESCRIBE clientes;
```

```markdown
SELECT * FROM clientes;
```


```markdown
INSERT INTO citas (fecha, hora, clienteId) VALUES
("2021-06-28", "10:30:00", 1);
```


```markdown
SELECT * FROM citas;
```


```markdown
SELECT * FROM clientes;
```


- ##### Unir dos tablas en una consulta
##### *Para unirlas, requerimos de Joins*


