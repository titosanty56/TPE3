<?php
require_once 'db/config.php';
class Model {
    protected $db;

    public function __construct() {
        $this->crearDb();
        $this->db = new PDO(
            'mysql:host='. MYSQL_HOST .
            ';dbname='. MYSQL_DB .
            ';charset=utf8', MYSQL_USER, MYSQL_PASS
        );
        $this->deploy();
    }

    private function deploy(){
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $password = '$2y$10$1zkQ5p1OqmcGMyw6NEf7B./d.r3DSAbBEcVRO/zE1Ge1dAGLOzETG';
            $sql =<<<END
            --
            -- Estructura de tabla para la tabla `aerolinea`
            --

            CREATE TABLE `aerolinea` (
            `id` int(11) NOT NULL,
            `Nombre` varchar(100) NOT NULL,
            `Pais` varchar(100) NOT NULL,
            `Fundacion` date NOT NULL,
            `servicios` text NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `aerolinea`
            --

            INSERT INTO `aerolinea` (`id`, `Nombre`, `Pais`, `Fundacion`, `servicios`) VALUES
            (1, 'Aerolineas Argentina', 'Argentina', '1949-05-14', 'Clase Económica, Clase Club Economy (en vuelos nacionales y regionales), Clase Business Club Cóndor (en vuelos internacionales de largo alcance)'),
            (2, 'Sky Airline', 'Chile', '2001-12-13', 'Sky Plus (Clase Premium o Flexible), Sky Light (Clase Básica).'),
            (3, 'Qatar Airways', 'Qatar', '1993-11-22', 'Clase Económica (Economy Class), Clase Ejecutiva (Business Class), Primera Clase (First Class).'),
            (4, 'Iberia', 'España', '1927-06-28', 'Clase Turista (Economy Class), Clase Turista Premium (Premium Economy), Clase Business, Clase Business Plus (en vuelos de larga distancia).'),
            (5, 'Emirates', ' Emiratos Árabes Unidos', '1985-03-25', 'Clase Económica (Economy Class), Clase Business (Business Class), Primera Clase (First Class).');

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `persona`
            --

            CREATE TABLE `persona` (
            `id_persona` int(11) NOT NULL,
            `Nombre` varchar(100) NOT NULL,
            `edad` tinyint(3) NOT NULL,
            `Cantidad` varchar(100) NOT NULL,
            `id_aerolinea` int(11) NOT NULL,
            `Destino` varchar(100) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `persona`
            --

            INSERT INTO `persona` (`id_persona`, `Nombre`, `edad`, `Cantidad`, `id_aerolinea`, `Destino`) VALUES
            (2, 'Carlos Luna', 56, '2', 5, 'China'),
            (3, 'Ezequiel Maggiolo', 0, '3', 3, 'Arabia'),
            (8, 'Maria Mingueza', 4, '33', 2, 'España'),
            (9, 'Juan Carlos Laportilla', 2, '53', 1, 'China');

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `usuario`
            --

            CREATE TABLE `usuario` (
            `id` int(11) NOT NULL,
            `user` varchar(250) NOT NULL,
            `password` char(60) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `usuario`
            --

            INSERT INTO `usuario` (`id`, `user`, `password`) VALUES
            (1, 'webadmin', '$password');

            --
            -- Índices para tablas volcadas
            --

            --
            -- Indices de la tabla `aerolinea`
            --
            ALTER TABLE `aerolinea`
            ADD PRIMARY KEY (`id`);

            --
            -- Indices de la tabla `persona`
            --
            ALTER TABLE `persona`
            ADD PRIMARY KEY (`id_persona`),
            ADD KEY `Id_aerolinea` (`id_aerolinea`);

            --
            -- Indices de la tabla `usuario`
            --
            ALTER TABLE `usuario`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `user` (`user`);

            --
            -- AUTO_INCREMENT de las tablas volcadas
            --

            --
            -- AUTO_INCREMENT de la tabla `aerolinea`
            --
            ALTER TABLE `aerolinea`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

            --
            -- AUTO_INCREMENT de la tabla `persona`
            --
            ALTER TABLE `persona`
            MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

            --
            -- AUTO_INCREMENT de la tabla `usuario`
            --
            ALTER TABLE `usuario`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

            --
            -- Restricciones para tablas volcadas
            --

            --
            -- Filtros para la tabla `persona`
            --
            ALTER TABLE `persona`
            ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`Id_aerolinea`) REFERENCES `aerolinea` (`id`);
            COMMIT;
            END;
            $this->db->query($sql);
        }
    }
    
    private function crearDb(){
        $nombreDb = MYSQL_DB;
        $pdo = new PDO('mysql:host =' . MYSQL_HOST.';charset = utf8', MYSQL_USER, MYSQL_PASS);
        $query = "CREATE DATABASE IF NOT EXISTS $nombreDb";
        $pdo->exec($query);
    }

}