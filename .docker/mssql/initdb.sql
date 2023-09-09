CREATE DATABASE caixa
GO

USE caixa
GO

CREATE TABLE postagems (
    id TEXT NOT NULL,
    titulo TEXT NOT NULL,
    texto TEXT NOT NULL,
    slug TEXT NOT NULL,
    deleted_at DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY (id)
);
GO

INSERT INTO postagems (titulo, texto, slug, created_at)
VALUES
('texto 1', 'lorem ip olore ollllore moo pp ispps lorem ipsum', 'simples-slug', '2007-05-08 12:35:29. 1234567 +12:15'),
('texto 2', 'lorem lorem ipsum lorem lorem ipsum ipsum lorem', 'simples-normal-text', '2007-05-08 12:35:29. 1234567 +12:15'),
('texto 3', 'lorem lorem ipsum ipsum lorem lorem ipsum ipsum lorem', 'ease-text','2007-05-08 12:35:29. 1234567 +12:15');
GO
