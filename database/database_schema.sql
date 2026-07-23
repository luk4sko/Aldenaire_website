-- Aldenaire Database Schema
-- PostgreSQL - iba struktura (bez dat)

-- Pouzivatelia (ucty)
CREATE TABLE IF NOT EXISTS pouzivatelia (
    id integer NOT NULL,
    username character varying NOT NULL,
    email character varying NOT NULL,
    password character varying NOT NULL,
    profilovka character varying          -- nazov suboru profilovej fotky
);

-- Rezervacie treningov
CREATE TABLE IF NOT EXISTS treningy (
    id integer NOT NULL,
    meno character varying NOT NULL,
    typ character varying NOT NULL,
    trener character varying NOT NULL,
    cena integer NOT NULL,
    datum date NOT NULL,
    cas character varying NOT NULL
);

-- Recenzie (hodnotenia)
CREATE TABLE IF NOT EXISTS reviews (
    id integer NOT NULL,
    meno character varying NOT NULL,
    recenzia text NOT NULL,
    hviezdicky smallint NOT NULL,
    datum timestamp without time zone NOT NULL
);

-- Objednavky z obchodu
CREATE TABLE IF NOT EXISTS objednavky (
    id integer NOT NULL,
    meno character varying NOT NULL,
    email character varying NOT NULL,
    telefon character varying NOT NULL,
    sposob_dorucenia character varying NOT NULL,   -- "adresa" alebo "packeta"
    adresa text NOT NULL,
    polozky text NOT NULL,                          -- napr. "Tricko x2, Mikina x1"
    spolu numeric NOT NULL,                         -- suma spolu (s dopravou)
    datum timestamp without time zone NOT NULL
);
