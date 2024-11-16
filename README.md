# SISTEMA DE CLUBES

## Integrantes:
 * Agustin Van Waarde
 * Tobias Vittor Aguerregoyhen

## Descripcion del proyecto:
En este esquema de tablas SQL desarrollaremos un sistema de clubes el cual el usuario va a poder registrar los mismos,y ademas se va a poder registrar distintos aspectos relacionados al club como por ejemplo los distintos socios o disciplinas las cuales incluya,sumado a eso brinda datos sobre el club.

## Avances en el proyecto:
Desarrolamos la api rest cambiando nuestra estructura de la primer entrega que era de tipo SSR y ahora la desarrollamos en un servicio CSR sin su frontend. Realiazamos todos los endpoints de la tabla de clubes,sus orderBy,tipoOrder,filtros y le aplicamos sus distintas http-request GET,POST,PUT,DELETE.Para insertar y editar tenes que que estar logueado con usuario y clave que esta abajo para obtener el token.

## Endpoints
api/clubes, GET -> trae todos los clubes,ademas se le puede aplicar las query de:  
orderBy=club,fundacion,contacto,localidad,sede.  
tipoOrder=ascendente,descendente.  
filtros con todos los campos de orderBy con algun valor.  

api/clubes/id, GET -> traigo un club por id.

api/clubes, POST -> insertar un club estando logueado.  
api/clubes/id, DELETE -> elimino un club.  
api/clubes/id, PUT -> edito un club estando logueado.  

api/token, GET -> obtengo el token ingresando usuario:webadmin, password:admin .(las sessions duran 90 seg)

## Diagrama
 ![Diagrama de SQL](/modeloSQL_sistemaClubes.png);