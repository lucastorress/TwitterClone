CREATE TABLE usuarios(
    id int NOT NULL AUTO_INCREMENT,
    usuario varchar(15) NOT NULL,
    senha varchar(32) NOT NULL,
    seguidores int DEFAULT 0,
    seguindo int DEFAULT 0,
    tweets int DEFAULT 0,
	url_img varchar(140) NOT NULL DEFAULT 'default.jpg',
    PRIMARY KEY (id)
);

CREATE TABLE following(
    id int NOT NULL AUTO_INCREMENT,
    usuario1_id int REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    usuario2_id int REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE tweets(
    id int NOT NULL AUTO_INCREMENT,
    usuario varchar(15) NOT NULL,
    usuario_id int REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    tweet varchar(140) NOT NULL,
    tempoinicial bigint(20) NOT NULL,
    PRIMARY KEY (id)
);