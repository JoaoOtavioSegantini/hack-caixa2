CREATE DATABASE caixa
GO

USE caixa
GO

CREATE TABLE postagens (
    id UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
    titulo TEXT NOT NULL,
    texto TEXT NOT NULL,
    slug TEXT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,
    PRIMARY KEY (id)
);
GO

INSERT INTO postagens (titulo, texto, slug, created_at, updated_at)
VALUES
('texto 1', 'lorem ip olore ollllore moo pp ispps lorem ipsum', 'simples-slug', convert(datetime,'08-09-23 10:54:09 PM',5), convert(datetime,'08-09-23 10:54:09 PM',5)),
('texto 2', 'lorem lorem ipsum lorem lorem ipsum ipsum lorem', 'simples-normal-text', convert(datetime,'08-09-23 10:14:09 PM',5), convert(datetime,'08-09-23 10:14:09 PM',5)),
('texto 3', 'lorem lorem ipsum ipsum lorem lorem ipsum ipsum lorem', 'ease-text',convert(datetime,'08-09-23 11:01:09 PM',5), convert(datetime,'08-09-23 11:01:09 PM',5));
GO
