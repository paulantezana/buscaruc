CREATE TABLE app_authorizations(
    app_authorization_id INT AUTO_INCREMENT NOT NULL,
    module VARCHAR(64) NOT NULL,
    action VARCHAR(64) DEFAULT '',
    description VARCHAR(64) DEFAULT '',
    state TINYINT DEFAULT 1,
    CONSTRAINT pk_app_authorizations PRIMARY KEY (app_authorization_id)
) ENGINE=InnoDB;

CREATE TABLE user_roles(
    user_role_id INT AUTO_INCREMENT NOT NULL,
    description VARCHAR(64) NOT NULL,

    updated_at DATETIME,
    created_at DATETIME,
    created_user_id INT,
    updated_user_id INT,
    state TINYINT DEFAULT 1,
    CONSTRAINT pk_user_roles PRIMARY KEY (user_role_id)
) ENGINE=InnoDB;

CREATE TABLE user_role_authorizations(
    user_role_id INT NOT NULL,
    app_authorization_id INT NOT NULL,
    CONSTRAINT fk_user_roles_authorization_user_roles FOREIGN KEY (user_role_id) REFERENCES user_roles (user_role_id)
        ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT fk_user_roles_authorization_app_authorizations FOREIGN KEY (app_authorization_id) REFERENCES app_authorizations (app_authorization_id)
        ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE users(
    user_id INT AUTO_INCREMENT NOT NULL,
    user_name VARCHAR(64) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    gender enum('0','1','2') DEFAULT '2',
    avatar VARCHAR(64) DEFAULT '',
    email  VARCHAR(64) DEFAULT '' UNIQUE,
    user_role_id INT NOT NULL,
    phone  VARCHAR(32) DEFAULT '',
    is_verified TINYINT DEFAULT 0,
    date_verified DATETIME,

    updated_at DATETIME,
    created_at DATETIME,
    created_user_id INT,
    updated_user_id INT,
    state TINYINT DEFAULT 1,
    CONSTRAINT pk_user PRIMARY KEY (user_id),
    CONSTRAINT fk_user_user_roles FOREIGN KEY (user_role_id) REFERENCES user_roles (user_role_id)
        ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE user_forgots(
    user_forgot_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    secret_key VARCHAR(128) NOT NULL,
    used TINYINT DEFAULT 0,

    updated_at DATETIME,
    created_at DATETIME,
    created_user_id INT,
    updated_user_id INT,
    state TINYINT DEFAULT 1,
    CONSTRAINT pk_user_forgots PRIMARY KEY (user_forgot_id),
    CONSTRAINT fk_user_forgots_user FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO app_authorizations (module,action,description,state)
VALUES ('home','home','dashboard',true),

       ('rol','listar','listar roles',true),
       ('rol','crear','crear nuevos rol',true),
       ('rol','eliminar','Eliminar un rol',true),
       ('rol','modificar','Acualizar los roles',true),

       ('usuario','listar','listar usuarios',true),
       ('usuario','crear','crear nuevo usuarios',true),
       ('usuario','eliminar','Eliminar un usuario',true),
       ('usuario','modificar','Acualizar los datos del usuario exepto la contraseña',true),
       ('usuario','modificarContraseña','Solo se permite actualizar la contraseña',true);

INSERT INTO user_roles (created_at, created_user_id, description, state)
VALUES ('2020-02-17 00:00:00', '0', 'Usuario', 1),
       ('2020-02-17 00:00:00', '0', 'Administrador', 1);

INSERT INTO users(user_name, password, full_name, avatar, email, user_role_id, gender)
VALUES ('admin1',sha1('admin1'),'admin1','','admin@admin.com',2,2);

INSERT INTO user_role_authorizations (user_role_id,app_authorization_id)
VALUES (2, 1),
       (2, 2),
       (2, 3),
       (2, 4),
       (2, 5),
       (2, 6),
       (2, 7),
       (2, 8),
       (2, 9),
       (2, 10);

INSERT INTO user_role_authorizations (user_role_id,app_authorization_id)
VALUES (1, 1),
       (1, 6),
       (1, 7),
       (1, 8),
       (1, 9),
       (1, 10);

-- // OTHER
CREATE TABLE census (
  ruc BIGINT AUTO_INCREMENT NOT NULL,
  social_reason VARCHAR(255) NOT NULL,
  taxpayer_state VARCHAR(64) DEFAULT '',
  domicile_condition VARCHAR(64) DEFAULT '',
  ubigeo VARCHAR(12) DEFAULT '',
  type_road VARCHAR(12) DEFAULT '',
  name_road VARCHAR(128) DEFAULT '',
  zone_code VARCHAR(32) DEFAULT '',
  type_zone VARCHAR(128) DEFAULT '',
  number VARCHAR(64) DEFAULT '',
  inside VARCHAR(64) DEFAULT '',
  lot VARCHAR(64) DEFAULT '',
  department VARCHAR(64) DEFAULT '',
  kilometer VARCHAR(64) DEFAULT '',
  address VARCHAR(150) DEFAULT '',
  full_address VARCHAR(250) DEFAULT '',
  last_update_sunat VARCHAR(64) DEFAULT '',
  CONSTRAINT pk_census PRIMARY KEY (ruc)
) ENGINE = InnoDB;

CREATE TABLE census_file(
    census_file_id INT AUTO_INCREMENT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    is_process TINYINT DEFAULT 0,
    CONSTRAINT pk_census_file PRIMARY KEY (census_file_id)
) ENGINE = InnoDB;

DELIMITER $$
CREATE PROCEDURE insert_row_census(
  IN _ruc BIGINT,
  IN _social_reason VARCHAR(255),
  IN _taxpayer_state VARCHAR(64),
  IN _domicile_condition VARCHAR(64),
  IN _ubigeo VARCHAR(12),
  IN _type_road VARCHAR(12),
  IN _name_road VARCHAR(128),
  IN _zone_code VARCHAR(32),
  IN _type_zone VARCHAR(128),
  IN _number VARCHAR(64),
  IN _inside VARCHAR(64),
  IN _lot VARCHAR(64),
  IN _department VARCHAR(64),
  IN _kilometer VARCHAR(64),
  IN _address VARCHAR(150),
  IN _full_address VARCHAR(250),
  IN _last_update_sunat VARCHAR(64)
)
    BEGIN
        DECLARE is_exit BIGINT;
        SELECT count(ruc) INTO is_exit FROM census WHERE ruc = _ruc LIMIT 1;
        IF(is_exit = 0) THEN
            INSERT  INTO census (ruc, social_reason, taxpayer_state, domicile_condition, ubigeo, type_road, name_road, zone_code, type_zone, number, inside, lot, department, kilometer, address, full_address, last_update_sunat)
            VALUES (_ruc, _social_reason, _taxpayer_state, _domicile_condition, _ubigeo, _type_road, _name_road, _zone_code, _type_zone, _number, _inside, _lot, _department, _kilometer, _address, _full_address, _last_update_sunat);
        ELSE
            UPDATE census SET social_reason = _social_reason, taxpayer_state = _taxpayer_state, domicile_condition = _domicile_condition, ubigeo = _ubigeo, type_road = _type_road, name_road = _name_road, zone_code = _zone_code, type_zone = _type_zone,
            number = _number, inside = _inside, lot = _lot, department = _department, kilometer = _kilometer, address = _address, full_address = _full_address, last_update_sunat = _last_update_sunat
            WHERE ruc = _ruc;
        END IF;
        SELECT _ruc;
    END$$
DELIMITER ;