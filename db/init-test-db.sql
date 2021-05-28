--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.20
-- Dumped by pg_dump version 10.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: jsonb_contains(jsonb, text); Type: FUNCTION; Schema: public; Owner: bibservice
--

CREATE FUNCTION public.jsonb_contains(jsonb, text) RETURNS boolean
    LANGUAGE sql
    AS $_$
SELECT $1 ? $2
$_$;


-- ALTER FUNCTION public.jsonb_contains(jsonb, text) OWNER TO bibservice;

--
-- Name: jsonb_contains_or(jsonb, text[]); Type: FUNCTION; Schema: public; Owner: bibservice
--

CREATE FUNCTION public.jsonb_contains_or(jsonb, text[]) RETURNS boolean
    LANGUAGE sql
    AS $_$

SELECT $1 ?| $2

$_$;


-- ALTER FUNCTION public.jsonb_contains_or(jsonb, text[]) OWNER TO bibservice;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: bib; Type: TABLE; Schema: public; Owner: bibservice
--

CREATE TABLE public.bib (
    id character varying(255) NOT NULL,
    updated_date timestamp without time zone,
    created_date timestamp without time zone,
    deleted_date date,
    deleted boolean,
    locations jsonb,
    suppressed boolean,
    available boolean,
    lang jsonb,
    title character varying(2000),
    author character varying(2000),
    material_type jsonb,
    bib_level jsonb,
    publish_year integer,
    catalog_date date,
    country jsonb,
    norm_title character varying(2000),
    norm_author character varying(2000),
    fixed_fields jsonb,
    var_fields jsonb,
    nypl_source character varying(255) NOT NULL,
    nypl_type character varying(255),
    standard_numbers jsonb,
    control_number character varying(255)
);


-- ALTER TABLE public.bib OWNER TO bibservice;

--
-- Name: bib bib_id_nypl_source_pkey; Type: CONSTRAINT; Schema: public; Owner: bibservice
--

ALTER TABLE ONLY public.bib
    ADD CONSTRAINT bib_id_nypl_source_pkey PRIMARY KEY (id, nypl_source);


--
-- Name: bib_control_number_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_control_number_idx ON public.bib USING btree (control_number);


--
-- Name: bib_created_date_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_created_date_idx ON public.bib USING btree (created_date);


--
-- Name: bib_id_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_id_idx ON public.bib USING btree (id);


--
-- Name: bib_nypl_source_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_nypl_source_idx ON public.bib USING btree (nypl_source);


--
-- Name: bib_standard_numbers_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_standard_numbers_idx ON public.bib USING gin (standard_numbers);


--
-- Name: bib_updated_date_id_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_updated_date_id_idx ON public.bib USING btree (updated_date, id);


--
-- Name: bib_updated_date_idx; Type: INDEX; Schema: public; Owner: bibservice
--

CREATE INDEX bib_updated_date_idx ON public.bib USING btree (updated_date);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: bibservice
--

REVOKE ALL ON SCHEMA public FROM rdsadmin;
REVOKE ALL ON SCHEMA public FROM PUBLIC;
-- GRANT ALL ON SCHEMA public TO bibservice;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

