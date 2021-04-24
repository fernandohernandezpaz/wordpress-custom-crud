CREATE TABLE IF NOT EXISTS `{prefix}causas_muerte`
(
    `id`             BIGINT PRIMARY KEY auto_increment,
    `user_id`        BIGINT,
    `descripcion`    varchar(255),
    `abreviatura`    varchar(255) null,
    `activo`         tinyint,
    `fecha_registro` datetime
    );

CREATE TABLE IF NOT EXISTS `{prefix}genero`
(
    `id`     int PRIMARY KEY auto_increment,
    `nombre` varchar(20),
    `activo` tinyint
    );

CREATE TABLE IF NOT EXISTS `{prefix}persona`
(
    `id`              BIGINT PRIMARY KEY auto_increment,
    `genero_id`       int,
    `nombre_completo` varchar(30),
    `edad`            smallint
    );

CREATE TABLE IF NOT EXISTS `{prefix}persona_causas_muerte`
(
    `id`              BIGINT PRIMARY KEY auto_increment,
    `persona_id`      BIGINT,
    `causa_muerte_id` BIGINT
);

ALTER TABLE `{prefix}persona`
    ADD CONSTRAINT `FK_{prefix}person_{prefix}genero`
        FOREIGN KEY (`genero_id`) REFERENCES `{prefix}genero` (`id`);

ALTER TABLE `{prefix}persona_causas_muerte`
    ADD CONSTRAINT `FK_{prefix}persona_causas_muerte_{prefix}persona`
        FOREIGN KEY (`persona_id`) REFERENCES `{prefix}persona` (`id`);


ALTER TABLE `{prefix}persona_causas_muerte`
    ADD CONSTRAINT `FK_{prefix}persona_causas_muerte_{prefix}causas_muerte`
        FOREIGN KEY (`causa_muerte_id`) REFERENCES `{prefix}causas_muerte` (`id`);




