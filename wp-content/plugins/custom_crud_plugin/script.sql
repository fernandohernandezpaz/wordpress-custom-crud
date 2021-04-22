CREATE TABLE IF NOT EXISTS `{prefix}causas_muerte`(
    `id` BIGINT PRIMARY KEY auto_increment,
    `user_id` BIGINT,
    `descripcion` varchar(255),
    `abreviatura` varchar(255) null,
    `activo` tinyint,
    `fecha_registro` datetime
);

