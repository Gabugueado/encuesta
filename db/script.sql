-- Crear la tabla de Regiones
CREATE TABLE IF NOT EXISTS Regiones (
    id_region INTEGER PRIMARY KEY,
    nombre_region TEXT NOT NULL
);

-- Poblar la tabla de Regiones
INSERT INTO Regiones (id_region, nombre_region) VALUES
    (1, 'Región de Arica y Parinacota'),
    (2, 'Región de Tarapacá'),
    (3, 'Región de Antofagasta'),
    (4, 'Región de Atacama'),
    (5, 'Región de Coquimbo'),
    (6, 'Región de Valparaíso'),
    (7, 'Región Metropolitana de Santiago'),
    (8, 'Región del Libertador General Bernardo O''Higgins'),
    (9, 'Región del Maule'),
    (10, 'Región de Ñuble'),
    (11, 'Región del Biobío'),
    (12, 'Región de La Araucanía'),
    (13, 'Región de Los Ríos'),
    (14, 'Región de Los Lagos'),
    (15, 'Región de Aysén del General Carlos Ibáñez del Campo'),
    (16, 'Región de Magallanes y de la Antártica Chilena');

-- Crear la tabla de Comunas
CREATE TABLE IF NOT EXISTS Comunas (
    id_comuna INT PRIMARY KEY,
    nombre_comuna VARCHAR(255) NOT NULL,
    id_region INT,
    FOREIGN KEY (id_region) REFERENCES Regiones(id_region)
);

-- Poblar la tabla de Comunas de manera simple
INSERT INTO Comunas (id_comuna, nombre_comuna, id_region) VALUES
    (1, 'Arica', 1),
    (2, 'Iquique', 2),
    (3, 'Antofagasta', 3),
    (4, 'Copiapó', 4),
    (5, 'La Serena', 5),
    (6, 'Valparaíso', 6),
    (7, 'Santiago', 7),
    (8, 'Rancagua', 8),
    (9, 'Talca', 9),
    (10, 'Chillán', 10),
    (11, 'Concepción', 11),
    (12, 'Temuco', 12),
    (13, 'Valdivia', 13),
    (14, 'Puerto Montt', 14),
    (15, 'Coyhaique', 15),
    (16, 'Punta Arenas', 16);

-- Crear la tabla de Candidatos
CREATE TABLE IF NOT EXISTS Candidatos (
    id_candidato INT PRIMARY KEY,
    nombre_candidato VARCHAR(255) NOT NULL,
    id_comuna INT,
    FOREIGN KEY (id_comuna) REFERENCES Comunas(id_comuna)
);

-- Poblar la tabla de Candidatos de manera simple
INSERT INTO Candidatos (id_candidato, nombre_candidato, id_comuna) VALUES
    (1, 'Candidato de Arica', 1),
    (2, 'Candidato de Iquique', 2),
    (3, 'Candidato de Antofagasta', 3),
    (4, 'Candidato de Copiapó', 4),
    (5, 'Candidato de La Serena', 5),
    (6, 'Candidato de Valparaíso', 6),
    (7, 'Candidato de Santiago', 7),
    (8, 'Candidato de Rancagua', 8),
    (9, 'Candidato de Talca', 9),
    (10, 'Candidato de Chillán', 10),
    (11, 'Candidato de Concepción', 11),
    (12, 'Candidato de Temuco', 12),
    (13, 'Candidato de Valdivia', 13),
    (14, 'Candidato de Puerto Montt', 14),
    (15, 'Candidato de Coyhaique', 15),
    (16, 'Candidato de Punta Arenas', 16);

-- Crear la tabla de Encuesta
CREATE TABLE IF NOT EXISTS Encuesta (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre_apellido TEXT NOT NULL,
    alias TEXT NOT NULL,
    rut TEXT NOT NULL,
    email TEXT NOT NULL,
    id_region INTEGER,
    id_comuna INTEGER,
    id_candidato INTEGER,
    web INTEGER,
    tv INTEGER,
    rrss INTEGER,
    amigo INTEGER,
    UNIQUE (rut),
    FOREIGN KEY (id_region) REFERENCES Regiones(id_region),
    FOREIGN KEY (id_comuna) REFERENCES Comunas(id_comuna),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);
