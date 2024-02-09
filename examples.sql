INSERT INTO Distribuidor (CNPJ, Senha, Nome)
VALUES
    ('12345678901234', 'distributor_password1', 'Distributor 1'),
    ('98765432109876', 'distributor_password2', 'Distributor 2'),
    ('11111111111111', 'distributor_password3', 'Distributor 3');

INSERT INTO Usuario (CPF, ID_Distribuidor, Nome, Senha)
VALUES
    ('11122233344', 1, 'User 1', 'user_password1'),
    ('55566677788', 2, 'User 2', 'user_password2'),
    ('99988877766', 3, 'User 3', 'user_password3');

INSERT INTO Album (ID_Usuario, Nome, Duracao_Total)
VALUES
    (1, 'Album 1', '01:30:00'),
    (2, 'Album 2', '01:45:00'),
    (3, 'Album 3', '02:00:00');

INSERT INTO Musica (ID_Album, Nome, Genero, Duracao)
VALUES
    (1, 'Song 1', 'Pop', '00:03:45'),
    (1, 'Song 2', 'Rock', '00:04:20'),
    (2, 'Song 3', 'Hip-Hop', '00:03:15'),
    (3, 'Song 4', 'Jazz', '00:05:30');

INSERT INTO Playlist (ID_Usuario, Nome, Descricao, Indicador_Privado, Duracao_Total)
VALUES
    (1, 'My Playlist 1', 'Description 1', false, '00:20:00'),
    (2, 'My Playlist 2', 'Description 2', true, '00:25:00'),
    (3, 'My Playlist 3', 'Description 3', false, '00:30:00');

INSERT INTO Curte_Musica (ID_Usuario, ID_Musica)
VALUES
    (1, 1),
    (1, 2),
    (2, 3),
    (3, 4);

INSERT INTO Curte_Album (ID_Usuario, ID_Album)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO Curte_Playlist (ID_Playlist, ID_Usuario)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO Playlist_Possui_Musica (ID_Playlist, ID_Musica)
VALUES
    (1, 1),
    (1, 2),
    (2, 3),
    (3, 4);
    
INSERT INTO Tem_Autoria (ID_Usuario, ID_Musica)
VALUES
    (1, 1),
    (2, 3),
    (3, 4);
