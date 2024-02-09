-- DROP DATABASE IF EXISTS PBD_CRUD;
-- CREATE DATABASE PBD_CRUD;


CREATE TABLE Distribuidores (
    ID SERIAL PRIMARY KEY,
    CNPJ VARCHAR(14) UNIQUE NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    Nome VARCHAR(100) NOT NULL
);

CREATE TABLE Usuarios (
    ID SERIAL PRIMARY KEY,
    CPF VARCHAR(11) UNIQUE NOT NULL,
    ID_Distribuidor INT REFERENCES Distribuidores(ID),
    Nome VARCHAR(100) UNIQUE NOT NULL,
    Senha VARCHAR(255) NOT NULL
);

CREATE TABLE Albums (
    ID SERIAL PRIMARY KEY,
    ID_Usuario INT REFERENCES Usuarios(ID),
    Nome VARCHAR(100) NOT NULL,
    Duracao_Total INTERVAL NOT NULL
);

CREATE TABLE Musicas (
    ID SERIAL PRIMARY KEY,
    ID_Album INT REFERENCES Albums(ID),
    Nome VARCHAR(100) NOT NULL,
    Genero VARCHAR(50),
    Duracao INTERVAL NOT NULL
);

CREATE TABLE Playlists (
    ID SERIAL PRIMARY KEY,
    ID_Usuario INT REFERENCES Usuarios(ID),
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT,
    Indicador_Privado BOOLEAN NOT NULL,
    Duracao_Total INTERVAL NOT NULL
);

CREATE TABLE Curte_Musicas (
    ID_Usuario INT REFERENCES Usuarios(ID),
    ID_Musica INT REFERENCES Musicas(ID),
    PRIMARY KEY (ID_Usuario, ID_Musica)
);

CREATE TABLE Curte_Playlists (
    ID_Playlist INT REFERENCES Playlists(ID),
    ID_Usuario INT REFERENCES Usuarios(ID),
    PRIMARY KEY (ID_Playlist, ID_Usuario)
);

CREATE TABLE Curte_Albums (
    ID_Usuario INT REFERENCES Usuarios(ID),
    ID_Album INT REFERENCES Albums(ID),
    PRIMARY KEY (ID_Usuario, ID_Album)
);

CREATE TABLE Playlist_Possui_Musicas (
    ID_Playlist INT REFERENCES Playlists(ID),
    ID_Musica INT REFERENCES Musicas(ID),
    PRIMARY KEY (ID_Playlist, ID_Musica)
);

CREATE TABLE Tem_Autoria (
    ID_Usuario INT REFERENCES Usuarios(ID),
    ID_Musica INT REFERENCES Musicas(ID),
    PRIMARY KEY (ID_Usuario, ID_Musica)
);
