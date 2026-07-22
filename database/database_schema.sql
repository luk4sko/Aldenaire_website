-- Aldenaire Database Schema
-- Generated: 2026-07-22 18:49:48
-- PostgreSQL Schema Only (no data)

CREATE TABLE IF NOT EXISTS pouzivatelia (
    id integer NOT NULL,
    username character varying NOT NULL,
    email character varying NOT NULL,
    password character varying NOT NULL
);

CREATE TABLE IF NOT EXISTS treningy (
    id integer NOT NULL,
    meno character varying NOT NULL,
    typ character varying NOT NULL,
    trener character varying NOT NULL,
    cena integer NOT NULL,
    datum date NOT NULL,
    cas character varying NOT NULL
);

CREATE TABLE IF NOT EXISTS reviews (
    id integer NOT NULL,
    meno character varying NOT NULL,
    recenzia text NOT NULL,
    hviezdicky smallint NOT NULL,
    datum timestamp without time zone NOT NULL
);

