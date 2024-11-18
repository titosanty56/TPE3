PROYECTO: Agencia de viajes.

Integrantes: Santiago Verga Pacali y Simon Marciante

Descripcion: Esta API te permite consultar detalles sobre las Aerolineas y pasajeros apuntados, la idea del proyecto es que si un administrador esta logueado (no nos genera el token), pueda ademas de ver los detalles de las aerolineas y pasajeros, hacer cambios o agregar una nueva Aerolinea o un nuevo pasajero indicando (edad, destino, aerolinea en la que viaja).

URL EJEMPLO: ./api/endpoint/:ID/:subrecurso

ENDPOINTS:

GET /api/aerolinea

GET /api/persona

-Devuelve todos las aerolinea o pasajeros declarados en la db, esta se puede aplicar un filtro por pais en el caso de la aerolinea y por cantidad (de pasasjes) en caso de la persona (pasajero). Ademas se puede ordenar por los diferentes campos.

-Filtrado /api/aerolinea?Pais=Argentina. -Filtrado /api/persona?Cantidad=2.

Ordenamiento aerolinea: orderBy: Este campo ordena los resultados de forma ascendente (por defecto).

  Las aerolineas se pueden ordenar por cualquiera de sus campos:
  -id
  -nombre
  -pais
  -fundacion
  -servicios
orderBy api/aerolinea?orderBy=nombre

Direction: Este campo permite ordenar de forma descendente utilizando DESC.

api/aerolinea?orderBy=nombre&Direction=DESC

Ordenamiento modelo: orderBy: Este campo ordena los resultados de forma ascendente (por defecto).

  Las personas se pueden ordenar por cualquiera de sus campos:
  -id_persona
  -nombre
  -edad
  -cantidad
  -destino
orderBy api/persona?orderBy=destino

Paginacion:

Permite dividir los resultados en mas paginas pequeñas.

pagina: numero de pagina solicitada.
limite: numero de boletos por pagina.
Paginacion api/aerolinea?pais=Argentina&orderBy=nombre&Direction=DESC&items=3&pagina=1

GET api/aerolinea/:id muestra la aerolinea con el id solicitado
GET api/persona/:id Te muestra la persona con el id solicitado.
-POST api/aerolinea para agregar una nueva aerolinea con informacion proporcionada en el cuerpo de solicitud.

ejemplo: { "Nombre": "JetSmart", "Pais": "EEUU", "Fundacion": "1998-04-14", "servicios": Clase Económica (Economy Class), Clase ejecutiva... }

-POST api/persona para agregar una nueva persona con informacicon proporcionada en el cuerpo de la solicitud.

ejemplo: { "Nombre": Maria Gonzalez, "edad": 39, "Cantidad": "3", "Destino": Marruecos }

-PUT api/aerolinea/:id Modifica la aerolinea segun su id, la modificacion se envia en el cuerpo de solicitud.

ejemplo:
{ "Nombre": "JetSmart", "Pais": "Chile", "Fundacion": "2004-08-18", "Servicios": Clase Económica (Economy Class), Clase ejecutiva... }

-PUT api/persona/:id Modifica la persona segun su id, la modificacion se envia en el cuerpo de solicitud.

ejemplo: { "Nombre": Maria Gonzalez, "edad": 39, "Cantidad": "5", "Destino": Colombia }

-DELETE api/aerolinea/:id Elimina la aerolinea segun su id.

-DELETE api/persona/:id Elimina la persona segun su id.

Autenticacion Para acceder a ciertos privilegios el usuario debe autenticarse utilizando un token (punto que implementamos pero no nos funciona).

-GET api/usuarios/token
  Este endpoin permite a los usuarios obtener un token JWT. Para utilizarlo, se deben enviar las credenciales en el encabezado de la solicitud en formato Base64.
  
    -iniciar sesion:
    Nombre de usuario: webadmin
    Contraseña: admin
    
  Esto hara que te devuelva un token JWT que puede ser utilizado para autenticar futuras solicitudes a la APi.