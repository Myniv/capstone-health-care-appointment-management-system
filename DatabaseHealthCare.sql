--
-- PostgreSQL database dump
--

-- Dumped from database version 17.0
-- Dumped by pg_dump version 17.0

-- Started on 2025-05-15 06:29:46

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 251 (class 1259 OID 29962)
-- Name: appointments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.appointments (
    id integer NOT NULL,
    patient_id integer,
    doctor_schedule_id integer,
    doctor_id integer,
    room_id integer,
    date timestamp without time zone,
    documents character varying(255),
    status character varying(50),
    reason_for_visit character varying(100),
    is_reschedule character varying(50),
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.appointments OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 29961)
-- Name: appointments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.appointments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.appointments_id_seq OWNER TO postgres;

--
-- TOC entry 5065 (class 0 OID 0)
-- Dependencies: 250
-- Name: appointments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.appointments_id_seq OWNED BY public.appointments.id;


--
-- TOC entry 228 (class 1259 OID 29802)
-- Name: auth_activation_attempts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_activation_attempts (
    id integer NOT NULL,
    ip_address character varying(255) NOT NULL,
    user_agent character varying(255) NOT NULL,
    token character varying(255),
    created_at timestamp without time zone NOT NULL
);


ALTER TABLE public.auth_activation_attempts OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 29801)
-- Name: auth_activation_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_activation_attempts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_activation_attempts_id_seq OWNER TO postgres;

--
-- TOC entry 5066 (class 0 OID 0)
-- Dependencies: 227
-- Name: auth_activation_attempts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_activation_attempts_id_seq OWNED BY public.auth_activation_attempts.id;


--
-- TOC entry 230 (class 1259 OID 29811)
-- Name: auth_groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_groups (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255) NOT NULL
);


ALTER TABLE public.auth_groups OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 29810)
-- Name: auth_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_groups_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_groups_id_seq OWNER TO postgres;

--
-- TOC entry 5067 (class 0 OID 0)
-- Dependencies: 229
-- Name: auth_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_groups_id_seq OWNED BY public.auth_groups.id;


--
-- TOC entry 233 (class 1259 OID 29828)
-- Name: auth_groups_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_groups_permissions (
    group_id integer DEFAULT 0 NOT NULL,
    permission_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.auth_groups_permissions OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 29844)
-- Name: auth_groups_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_groups_users (
    group_id integer DEFAULT 0 NOT NULL,
    user_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.auth_groups_users OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 29767)
-- Name: auth_logins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_logins (
    id integer NOT NULL,
    ip_address character varying(255),
    email character varying(255),
    user_id integer,
    date timestamp without time zone NOT NULL,
    success smallint NOT NULL
);


ALTER TABLE public.auth_logins OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 29766)
-- Name: auth_logins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_logins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_logins_id_seq OWNER TO postgres;

--
-- TOC entry 5068 (class 0 OID 0)
-- Dependencies: 221
-- Name: auth_logins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_logins_id_seq OWNED BY public.auth_logins.id;


--
-- TOC entry 232 (class 1259 OID 29820)
-- Name: auth_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_permissions (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255) NOT NULL
);


ALTER TABLE public.auth_permissions OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 29819)
-- Name: auth_permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_permissions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_permissions_id_seq OWNER TO postgres;

--
-- TOC entry 5069 (class 0 OID 0)
-- Dependencies: 231
-- Name: auth_permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_permissions_id_seq OWNED BY public.auth_permissions.id;


--
-- TOC entry 226 (class 1259 OID 29793)
-- Name: auth_reset_attempts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_reset_attempts (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    ip_address character varying(255) NOT NULL,
    user_agent character varying(255) NOT NULL,
    token character varying(255),
    created_at timestamp without time zone NOT NULL
);


ALTER TABLE public.auth_reset_attempts OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 29792)
-- Name: auth_reset_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_reset_attempts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_reset_attempts_id_seq OWNER TO postgres;

--
-- TOC entry 5070 (class 0 OID 0)
-- Dependencies: 225
-- Name: auth_reset_attempts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_reset_attempts_id_seq OWNED BY public.auth_reset_attempts.id;


--
-- TOC entry 224 (class 1259 OID 29778)
-- Name: auth_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_tokens (
    id integer NOT NULL,
    selector character varying(255) NOT NULL,
    "hashedValidator" character varying(255) NOT NULL,
    user_id integer NOT NULL,
    expires timestamp without time zone NOT NULL
);


ALTER TABLE public.auth_tokens OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 29777)
-- Name: auth_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auth_tokens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auth_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 5071 (class 0 OID 0)
-- Dependencies: 223
-- Name: auth_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auth_tokens_id_seq OWNED BY public.auth_tokens.id;


--
-- TOC entry 235 (class 1259 OID 29860)
-- Name: auth_users_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_users_permissions (
    user_id integer DEFAULT 0 NOT NULL,
    permission_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.auth_users_permissions OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 29989)
-- Name: doctor_absents; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctor_absents (
    id integer NOT NULL,
    doctor_id integer,
    date timestamp without time zone,
    status character varying(50),
    reason character varying(100),
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.doctor_absents OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 29988)
-- Name: doctor_absents_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctor_absents_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.doctor_absents_id_seq OWNER TO postgres;

--
-- TOC entry 5072 (class 0 OID 0)
-- Dependencies: 252
-- Name: doctor_absents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctor_absents_id_seq OWNED BY public.doctor_absents.id;


--
-- TOC entry 237 (class 1259 OID 29877)
-- Name: doctor_category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctor_category (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    description text
);


ALTER TABLE public.doctor_category OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 29876)
-- Name: doctor_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctor_category_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.doctor_category_id_seq OWNER TO postgres;

--
-- TOC entry 5073 (class 0 OID 0)
-- Dependencies: 236
-- Name: doctor_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctor_category_id_seq OWNED BY public.doctor_category.id;


--
-- TOC entry 249 (class 1259 OID 29945)
-- Name: doctor_schedules; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctor_schedules (
    id integer NOT NULL,
    doctor_id integer,
    room_id integer,
    start_time time without time zone,
    end_time time without time zone,
    max_patient integer,
    status character varying(100),
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.doctor_schedules OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 29944)
-- Name: doctor_schedules_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctor_schedules_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.doctor_schedules_id_seq OWNER TO postgres;

--
-- TOC entry 5074 (class 0 OID 0)
-- Dependencies: 248
-- Name: doctor_schedules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctor_schedules_id_seq OWNED BY public.doctor_schedules.id;


--
-- TOC entry 239 (class 1259 OID 29886)
-- Name: doctors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctors (
    id integer NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    phone character varying(20),
    address character varying(500),
    sex character varying(100),
    dob date,
    email character varying(150),
    profile_picture character varying(255),
    doctor_category_id integer,
    user_id integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.doctors OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 29885)
-- Name: doctors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.doctors_id_seq OWNER TO postgres;

--
-- TOC entry 5075 (class 0 OID 0)
-- Dependencies: 238
-- Name: doctors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctors_id_seq OWNED BY public.doctors.id;


--
-- TOC entry 243 (class 1259 OID 29919)
-- Name: educations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.educations (
    id integer NOT NULL,
    doctor_id integer,
    university character varying(100),
    city character varying(50),
    study_program character varying(100),
    degree character varying(50),
    year character varying(50),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.educations OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 29918)
-- Name: educations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.educations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.educations_id_seq OWNER TO postgres;

--
-- TOC entry 5076 (class 0 OID 0)
-- Dependencies: 242
-- Name: educations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.educations_id_seq OWNED BY public.educations.id;


--
-- TOC entry 259 (class 1259 OID 30027)
-- Name: equipment_rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.equipment_rooms (
    id integer NOT NULL,
    room_id integer NOT NULL,
    equipment_id integer NOT NULL,
    total integer
);


ALTER TABLE public.equipment_rooms OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 30026)
-- Name: equipment_rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.equipment_rooms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.equipment_rooms_id_seq OWNER TO postgres;

--
-- TOC entry 5077 (class 0 OID 0)
-- Dependencies: 258
-- Name: equipment_rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.equipment_rooms_id_seq OWNED BY public.equipment_rooms.id;


--
-- TOC entry 247 (class 1259 OID 29938)
-- Name: equipments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.equipments (
    id integer NOT NULL,
    name character varying(100),
    function character varying(100),
    stock integer NOT NULL,
    status character varying(50),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.equipments OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 29937)
-- Name: equipments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.equipments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.equipments_id_seq OWNER TO postgres;

--
-- TOC entry 5078 (class 0 OID 0)
-- Dependencies: 246
-- Name: equipments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.equipments_id_seq OWNED BY public.equipments.id;


--
-- TOC entry 263 (class 1259 OID 30055)
-- Name: histories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.histories (
    id integer NOT NULL,
    appointment_id integer,
    patient_id integer,
    notes character varying(100),
    prescriptions character varying(100),
    documents character varying(255),
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.histories OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 30054)
-- Name: histories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.histories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.histories_id_seq OWNER TO postgres;

--
-- TOC entry 5079 (class 0 OID 0)
-- Dependencies: 262
-- Name: histories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.histories_id_seq OWNED BY public.histories.id;


--
-- TOC entry 255 (class 1259 OID 30001)
-- Name: inventories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inventories (
    id integer NOT NULL,
    serial_number character varying NOT NULL,
    name character varying(100),
    function character varying(100),
    status character varying(50),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.inventories OWNER TO postgres;

--
-- TOC entry 254 (class 1259 OID 30000)
-- Name: inventories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inventories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.inventories_id_seq OWNER TO postgres;

--
-- TOC entry 5080 (class 0 OID 0)
-- Dependencies: 254
-- Name: inventories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inventories_id_seq OWNED BY public.inventories.id;


--
-- TOC entry 257 (class 1259 OID 30010)
-- Name: inventory_rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inventory_rooms (
    id integer NOT NULL,
    room_id integer NOT NULL,
    inventory_id integer NOT NULL
);


ALTER TABLE public.inventory_rooms OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 30009)
-- Name: inventory_rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inventory_rooms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.inventory_rooms_id_seq OWNER TO postgres;

--
-- TOC entry 5081 (class 0 OID 0)
-- Dependencies: 256
-- Name: inventory_rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inventory_rooms_id_seq OWNED BY public.inventory_rooms.id;


--
-- TOC entry 218 (class 1259 OID 29743)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 29742)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5082 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 241 (class 1259 OID 29905)
-- Name: patients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.patients (
    id integer NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    phone character varying(20),
    address character varying(500),
    sex character varying(100),
    patient_type character varying(100),
    dob date,
    email character varying(150),
    profile_picture character varying(255),
    user_id integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.patients OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 29904)
-- Name: patients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.patients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.patients_id_seq OWNER TO postgres;

--
-- TOC entry 5083 (class 0 OID 0)
-- Dependencies: 240
-- Name: patients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.patients_id_seq OWNED BY public.patients.id;


--
-- TOC entry 245 (class 1259 OID 29931)
-- Name: rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rooms (
    id integer NOT NULL,
    name character varying(100),
    function character varying(100),
    status character varying(50),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.rooms OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 29930)
-- Name: rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rooms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rooms_id_seq OWNER TO postgres;

--
-- TOC entry 5084 (class 0 OID 0)
-- Dependencies: 244
-- Name: rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rooms_id_seq OWNED BY public.rooms.id;


--
-- TOC entry 261 (class 1259 OID 30044)
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    id integer NOT NULL,
    key character varying(100) NOT NULL,
    value text,
    description text
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 30043)
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.settings_id_seq OWNER TO postgres;

--
-- TOC entry 5085 (class 0 OID 0)
-- Dependencies: 260
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- TOC entry 220 (class 1259 OID 29752)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    username character varying(30),
    password_hash character varying(255) NOT NULL,
    reset_hash character varying(255),
    reset_at timestamp without time zone,
    reset_expires timestamp without time zone,
    activate_hash character varying(255),
    status character varying(255),
    status_message character varying(255),
    active smallint DEFAULT 0 NOT NULL,
    force_pass_reset smallint DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 29751)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5086 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4781 (class 2604 OID 29965)
-- Name: appointments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments ALTER COLUMN id SET DEFAULT nextval('public.appointments_id_seq'::regclass);


--
-- TOC entry 4765 (class 2604 OID 29805)
-- Name: auth_activation_attempts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_activation_attempts ALTER COLUMN id SET DEFAULT nextval('public.auth_activation_attempts_id_seq'::regclass);


--
-- TOC entry 4766 (class 2604 OID 29814)
-- Name: auth_groups id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups ALTER COLUMN id SET DEFAULT nextval('public.auth_groups_id_seq'::regclass);


--
-- TOC entry 4762 (class 2604 OID 29770)
-- Name: auth_logins id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_logins ALTER COLUMN id SET DEFAULT nextval('public.auth_logins_id_seq'::regclass);


--
-- TOC entry 4767 (class 2604 OID 29823)
-- Name: auth_permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_permissions ALTER COLUMN id SET DEFAULT nextval('public.auth_permissions_id_seq'::regclass);


--
-- TOC entry 4764 (class 2604 OID 29796)
-- Name: auth_reset_attempts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_reset_attempts ALTER COLUMN id SET DEFAULT nextval('public.auth_reset_attempts_id_seq'::regclass);


--
-- TOC entry 4763 (class 2604 OID 29781)
-- Name: auth_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_tokens ALTER COLUMN id SET DEFAULT nextval('public.auth_tokens_id_seq'::regclass);


--
-- TOC entry 4782 (class 2604 OID 29992)
-- Name: doctor_absents id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_absents ALTER COLUMN id SET DEFAULT nextval('public.doctor_absents_id_seq'::regclass);


--
-- TOC entry 4774 (class 2604 OID 29880)
-- Name: doctor_category id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_category ALTER COLUMN id SET DEFAULT nextval('public.doctor_category_id_seq'::regclass);


--
-- TOC entry 4780 (class 2604 OID 29948)
-- Name: doctor_schedules id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_schedules ALTER COLUMN id SET DEFAULT nextval('public.doctor_schedules_id_seq'::regclass);


--
-- TOC entry 4775 (class 2604 OID 29889)
-- Name: doctors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctors ALTER COLUMN id SET DEFAULT nextval('public.doctors_id_seq'::regclass);


--
-- TOC entry 4777 (class 2604 OID 29922)
-- Name: educations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.educations ALTER COLUMN id SET DEFAULT nextval('public.educations_id_seq'::regclass);


--
-- TOC entry 4785 (class 2604 OID 30030)
-- Name: equipment_rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipment_rooms ALTER COLUMN id SET DEFAULT nextval('public.equipment_rooms_id_seq'::regclass);


--
-- TOC entry 4779 (class 2604 OID 29941)
-- Name: equipments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipments ALTER COLUMN id SET DEFAULT nextval('public.equipments_id_seq'::regclass);


--
-- TOC entry 4787 (class 2604 OID 30058)
-- Name: histories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.histories ALTER COLUMN id SET DEFAULT nextval('public.histories_id_seq'::regclass);


--
-- TOC entry 4783 (class 2604 OID 30004)
-- Name: inventories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventories ALTER COLUMN id SET DEFAULT nextval('public.inventories_id_seq'::regclass);


--
-- TOC entry 4784 (class 2604 OID 30013)
-- Name: inventory_rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventory_rooms ALTER COLUMN id SET DEFAULT nextval('public.inventory_rooms_id_seq'::regclass);


--
-- TOC entry 4758 (class 2604 OID 29746)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4776 (class 2604 OID 29908)
-- Name: patients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patients ALTER COLUMN id SET DEFAULT nextval('public.patients_id_seq'::regclass);


--
-- TOC entry 4778 (class 2604 OID 29934)
-- Name: rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms ALTER COLUMN id SET DEFAULT nextval('public.rooms_id_seq'::regclass);


--
-- TOC entry 4786 (class 2604 OID 30047)
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- TOC entry 4759 (class 2604 OID 29755)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5047 (class 0 OID 29962)
-- Dependencies: 251
-- Data for Name: appointments; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.appointments VALUES (3, 1, 9, 7, 3, '2025-05-02 00:00:00', '', 'done', 'Maag', 'false', '2025-05-01 18:23:01', '2025-05-01 18:54:46');
INSERT INTO public.appointments VALUES (2, 1, 15, 1, 3, '2025-05-06 00:00:00', '', 'cancel', 'Headache', 'false', '2025-05-01 18:22:23', '2025-05-01 18:57:52');
INSERT INTO public.appointments VALUES (1, 1, 14, 1, 2, '2025-05-02 00:00:00', '', 'done', 'Headache', 'false', '2025-05-01 18:21:29', '2025-05-01 19:00:39');
INSERT INTO public.appointments VALUES (6, 12, 10, 4, 3, '2025-05-09 00:00:00', 'documents_18_2025_05_02_1746144057.pdf', 'booking', 'Check up', 'false', '2025-05-02 00:00:57', '2025-05-02 00:00:57');
INSERT INTO public.appointments VALUES (33, 1, 2, 1, 1, '2025-05-09 00:00:00', '', 'booking', 'sakit gigi', 'true', '2025-05-08 07:51:02', '2025-05-08 08:09:58');
INSERT INTO public.appointments VALUES (10, 1, 9, 7, 3, '2025-05-09 00:00:00', '', 'booking', 'MY child heart sick', 'false', '2025-05-02 00:27:05', '2025-05-02 00:27:05');
INSERT INTO public.appointments VALUES (12, 1, 10, 4, 3, '2025-05-13 00:00:00', 'documents_7_2025_05_02_1746146055.pdf', 'booking', 'Checkup my child', 'true', '2025-05-02 00:34:15', '2025-05-02 02:30:01');
INSERT INTO public.appointments VALUES (4, 12, 15, 1, 3, '2025-05-02 00:00:00', 'documents_18_2025_05_01_1746143897.pdf', 'done', 'A hole in the tooth', 'true', '2025-05-01 23:58:17', '2025-05-02 06:48:31');
INSERT INTO public.appointments VALUES (13, 1, 15, 1, 3, '2025-05-23 00:00:00', '', 'booking', 'Sick', 'true', '2025-05-02 02:31:41', '2025-05-02 06:52:48');
INSERT INTO public.appointments VALUES (17, 1, 9, 7, 3, '2025-05-15 00:00:00', '', 'booking', 'Sakit', 'false', '2025-05-02 07:01:48', '2025-05-02 07:01:48');
INSERT INTO public.appointments VALUES (5, 12, 13, 3, 2, '2025-05-05 00:00:00', '', 'cancel', 'Stomachace', 'false', '2025-05-01 23:59:24', '2025-05-01 23:59:24');
INSERT INTO public.appointments VALUES (7, 4, 9, 7, 3, '2025-05-02 00:00:00', '', 'cancel', 'Flue', 'false', '2025-05-02 00:03:55', '2025-05-02 00:03:55');
INSERT INTO public.appointments VALUES (8, 4, 2, 1, 2, '2025-05-02 00:00:00', '', 'cancel', 'Needs help', 'false', '2025-05-02 00:05:18', '2025-05-02 00:05:18');
INSERT INTO public.appointments VALUES (9, 7, 2, 1, 3, '2025-05-05 00:00:00', '', 'cancel', 'Stomacache', 'false', '2025-05-02 00:06:21', '2025-05-02 00:06:21');
INSERT INTO public.appointments VALUES (11, 1, 13, 3, 2, '2025-05-05 00:00:00', 'documents_7_2025_05_02_1746145665.pdf', 'cancel', 'Checkup for my child', 'false', '2025-05-02 00:27:45', '2025-05-02 00:27:45');
INSERT INTO public.appointments VALUES (14, 1, 10, 4, 3, '2025-05-02 00:00:00', 'documents_7_2025_05_02_1746156510.pdf', 'cancel', 'Stomachace', 'false', '2025-05-02 03:28:30', '2025-05-02 03:28:30');
INSERT INTO public.appointments VALUES (18, 1, 14, 1, 2, '2025-05-11 00:00:00', 'documents_7_2025_05_07_1746625643.pdf', 'booking', 'Check up for my sickness', 'false', '2025-05-07 13:47:23', '2025-05-07 13:47:23');
INSERT INTO public.appointments VALUES (19, 4, 12, 6, 1, '2025-05-07 00:00:00', 'documents_10_2025_05_07_1746655316.pdf', 'done', 'Stomachace', 'false', '2025-05-07 22:01:56', '2025-05-07 22:02:54');
INSERT INTO public.appointments VALUES (20, 8, 15, 1, 3, '2025-05-10 00:00:00', '', 'booking', 'My Stomachace hurts', 'false', '2025-05-07 22:04:46', '2025-05-07 22:04:46');
INSERT INTO public.appointments VALUES (21, 8, 2, 1, 1, '2025-05-12 00:00:00', '', 'booking', 'Checkup for my stomach', 'false', '2025-05-07 22:05:21', '2025-05-07 22:05:21');
INSERT INTO public.appointments VALUES (22, 11, 10, 4, 3, '2025-05-14 00:00:00', 'documents_17_2025_05_07_1746655623.pdf', 'booking', 'There is like a lump under my skin', 'false', '2025-05-07 22:07:03', '2025-05-07 22:07:03');
INSERT INTO public.appointments VALUES (23, 11, 10, 4, 3, '2025-05-15 00:00:00', 'documents_17_2025_05_07_1746655663.pdf', 'booking', 'Check up for the lump under the skin', 'false', '2025-05-07 22:07:43', '2025-05-07 22:07:43');
INSERT INTO public.appointments VALUES (24, 11, 13, 3, 2, '2025-05-09 00:00:00', 'documents_17_2025_05_07_1746655733.pdf', 'booking', 'My Stomache hurts', 'false', '2025-05-07 22:08:53', '2025-05-07 22:08:53');
INSERT INTO public.appointments VALUES (25, 11, 7, 5, 3, '2025-05-10 00:00:00', '', 'booking', 'Check up for my stomache', 'false', '2025-05-07 22:09:35', '2025-05-07 22:09:35');
INSERT INTO public.appointments VALUES (26, 10, 2, 1, 1, '2025-05-08 00:00:00', '', 'booking', 'My head hurts so much', 'false', '2025-05-07 22:12:38', '2025-05-07 22:12:38');
INSERT INTO public.appointments VALUES (27, 9, 15, 1, 3, '2025-05-08 00:00:00', '', 'booking', 'I want to put fake tooth', 'false', '2025-05-07 22:13:37', '2025-05-07 22:13:37');
INSERT INTO public.appointments VALUES (28, 1, 10, 4, 3, '2025-05-07 00:00:00', 'documents_7_2025_05_07_1746656094.pdf', 'done', 'My child have a fever', 'false', '2025-05-07 22:14:54', '2025-05-07 22:16:36');
INSERT INTO public.appointments VALUES (29, 1, 4, 2, 2, '2025-05-09 00:00:00', 'documents_7_2025_05_07_1746656318.pdf', 'booking', 'My child tooth want to fall', 'false', '2025-05-07 22:18:38', '2025-05-07 22:18:38');
INSERT INTO public.appointments VALUES (16, 1, 14, 1, 2, '2025-05-11 00:00:00', 'documents_7_2025_05_02_1746168171.pdf', 'booking', 'sakit gigi', 'true', '2025-05-02 06:42:51', '2025-05-02 06:45:58');
INSERT INTO public.appointments VALUES (30, 1, 5, 6, 2, '2025-05-14 00:00:00', 'documents_7_2025_05_08_1746679526.pdf', 'done', 'headache', 'false', '2025-05-08 04:45:26', '2025-05-08 04:52:36');
INSERT INTO public.appointments VALUES (15, 1, 2, 1, 1, '2025-05-05 00:00:00', 'documents_7_2025_05_02_1746156560.pdf', 'booking', 'Stomachace', 'false', '2025-05-02 03:29:20', '2025-05-02 03:29:20');
INSERT INTO public.appointments VALUES (31, 2, 1, 2, 1, '2025-05-15 00:00:00', '', 'booking', 'test', 'false', '2025-05-08 05:38:22', '2025-05-08 05:38:22');
INSERT INTO public.appointments VALUES (32, 3, 1, 2, 1, '2025-05-15 00:00:00', '', 'booking', 'test 2', 'false', '2025-05-08 05:40:01', '2025-05-08 05:40:01');


--
-- TOC entry 5024 (class 0 OID 29802)
-- Dependencies: 228
-- Data for Name: auth_activation_attempts; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_activation_attempts VALUES (1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '58e44ba1e567b4a5989809d55802cf8d', '2025-05-01 15:59:03');


--
-- TOC entry 5026 (class 0 OID 29811)
-- Dependencies: 230
-- Data for Name: auth_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_groups VALUES (1, 'administrator', 'Administrator');
INSERT INTO public.auth_groups VALUES (2, 'doctor', 'Doctor');
INSERT INTO public.auth_groups VALUES (3, 'patient', 'Patient');


--
-- TOC entry 5029 (class 0 OID 29828)
-- Dependencies: 233
-- Data for Name: auth_groups_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5030 (class 0 OID 29844)
-- Dependencies: 234
-- Data for Name: auth_groups_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_groups_users VALUES (1, 1);
INSERT INTO public.auth_groups_users VALUES (2, 2);
INSERT INTO public.auth_groups_users VALUES (2, 3);
INSERT INTO public.auth_groups_users VALUES (2, 4);
INSERT INTO public.auth_groups_users VALUES (2, 5);
INSERT INTO public.auth_groups_users VALUES (2, 6);
INSERT INTO public.auth_groups_users VALUES (3, 7);
INSERT INTO public.auth_groups_users VALUES (3, 8);
INSERT INTO public.auth_groups_users VALUES (3, 9);
INSERT INTO public.auth_groups_users VALUES (3, 10);
INSERT INTO public.auth_groups_users VALUES (3, 11);
INSERT INTO public.auth_groups_users VALUES (3, 12);
INSERT INTO public.auth_groups_users VALUES (3, 13);
INSERT INTO public.auth_groups_users VALUES (3, 14);
INSERT INTO public.auth_groups_users VALUES (3, 15);
INSERT INTO public.auth_groups_users VALUES (3, 16);
INSERT INTO public.auth_groups_users VALUES (3, 17);
INSERT INTO public.auth_groups_users VALUES (3, 18);
INSERT INTO public.auth_groups_users VALUES (2, 19);
INSERT INTO public.auth_groups_users VALUES (2, 20);


--
-- TOC entry 5018 (class 0 OID 29767)
-- Dependencies: 222
-- Data for Name: auth_logins; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_logins VALUES (1, '::1', 'admin', NULL, '2025-05-01 14:31:08', 0);
INSERT INTO public.auth_logins VALUES (2, '::1', 'admin@yopmail.com', 1, '2025-05-01 14:40:54', 1);
INSERT INTO public.auth_logins VALUES (3, '::1', 'irfandwi@yopmail.com', 18, '2025-05-01 15:59:12', 1);
INSERT INTO public.auth_logins VALUES (4, '::1', 'irfandwi@yopmail.com', 18, '2025-05-01 16:01:15', 1);
INSERT INTO public.auth_logins VALUES (5, '::1', 'irfandwi', NULL, '2025-05-01 16:02:39', 0);
INSERT INTO public.auth_logins VALUES (6, '::1', 'mynivid@gmail.com', 7, '2025-05-01 16:02:54', 1);
INSERT INTO public.auth_logins VALUES (7, '::1', 'admin', NULL, '2025-05-01 16:04:49', 0);
INSERT INTO public.auth_logins VALUES (8, '::1', 'admin@yopmail.com', 1, '2025-05-01 16:04:55', 1);
INSERT INTO public.auth_logins VALUES (9, '::1', 'mynivid@gmail.com', 7, '2025-05-01 17:27:49', 1);
INSERT INTO public.auth_logins VALUES (10, '::1', 'admin@yopmail.com', 1, '2025-05-01 17:33:07', 1);
INSERT INTO public.auth_logins VALUES (11, '::1', 'mynivid@gmail.com', 7, '2025-05-01 18:21:00', 1);
INSERT INTO public.auth_logins VALUES (12, '::1', 'welldone', NULL, '2025-05-01 18:23:25', 0);
INSERT INTO public.auth_logins VALUES (13, '::1', 'welldone@yopmail.com', NULL, '2025-05-01 18:23:36', 0);
INSERT INTO public.auth_logins VALUES (14, '::1', 'drwell@yopmail.com', 20, '2025-05-01 18:24:06', 1);
INSERT INTO public.auth_logins VALUES (15, '::1', 'mynivid@gmail.com', 7, '2025-05-01 18:43:46', 1);
INSERT INTO public.auth_logins VALUES (16, '::1', 'drwell@yopmail.com', 20, '2025-05-01 18:44:43', 1);
INSERT INTO public.auth_logins VALUES (17, '::1', 'mynivid@gmail.com', 7, '2025-05-01 18:55:42', 1);
INSERT INTO public.auth_logins VALUES (18, '::1', 'tirta', NULL, '2025-05-01 19:00:06', 0);
INSERT INTO public.auth_logins VALUES (19, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-01 19:00:16', 1);
INSERT INTO public.auth_logins VALUES (20, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-01 19:01:35', 1);
INSERT INTO public.auth_logins VALUES (21, '::1', 'admin', NULL, '2025-05-01 19:10:01', 0);
INSERT INTO public.auth_logins VALUES (22, '::1', 'admin@yopmail.com', 1, '2025-05-01 19:10:06', 1);
INSERT INTO public.auth_logins VALUES (23, '::1', 'admin', NULL, '2025-05-01 23:56:15', 0);
INSERT INTO public.auth_logins VALUES (24, '::1', 'admin@yopmail.com', 1, '2025-05-01 23:56:21', 1);
INSERT INTO public.auth_logins VALUES (25, '::1', 'irfandwi', NULL, '2025-05-01 23:57:12', 0);
INSERT INTO public.auth_logins VALUES (26, '::1', 'irfandwi@yopmail.com', 18, '2025-05-01 23:57:21', 1);
INSERT INTO public.auth_logins VALUES (27, '::1', 'irfandwi@yopmail.com', 18, '2025-05-01 23:58:45', 1);
INSERT INTO public.auth_logins VALUES (28, '::1', 'michaeljoe@yopmail.com', 10, '2025-05-02 00:03:32', 1);
INSERT INTO public.auth_logins VALUES (29, '::1', 'sarahlim@yopmail.com', 13, '2025-05-02 00:05:48', 1);
INSERT INTO public.auth_logins VALUES (30, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 00:06:42', 1);
INSERT INTO public.auth_logins VALUES (31, '::1', 'irfandwi@yopmail.com', 18, '2025-05-02 00:07:33', 1);
INSERT INTO public.auth_logins VALUES (32, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 00:10:39', 1);
INSERT INTO public.auth_logins VALUES (33, '::1', 'admin@yopmail.com', 1, '2025-05-02 00:15:05', 1);
INSERT INTO public.auth_logins VALUES (34, '::1', 'mynivid@gmail.com', 7, '2025-05-02 00:20:40', 1);
INSERT INTO public.auth_logins VALUES (35, '::1', 'irfandwi', NULL, '2025-05-02 00:21:21', 0);
INSERT INTO public.auth_logins VALUES (36, '::1', 'irfandwi@yopmail.com', 18, '2025-05-02 00:21:34', 1);
INSERT INTO public.auth_logins VALUES (37, '::1', 'mynivid@gmail.com', 7, '2025-05-02 00:26:20', 1);
INSERT INTO public.auth_logins VALUES (38, '::1', 'admin@yopmail.com', 1, '2025-05-02 02:19:41', 1);
INSERT INTO public.auth_logins VALUES (39, '::1', 'admin', NULL, '2025-05-02 02:29:42', 0);
INSERT INTO public.auth_logins VALUES (40, '::1', 'admin@yopmail.com', 1, '2025-05-02 02:29:46', 1);
INSERT INTO public.auth_logins VALUES (41, '::1', 'mynivid@gmail.com', 7, '2025-05-02 02:31:06', 1);
INSERT INTO public.auth_logins VALUES (42, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 02:32:27', 1);
INSERT INTO public.auth_logins VALUES (43, '::1', 'admin@yopmail.com', 1, '2025-05-02 02:35:54', 1);
INSERT INTO public.auth_logins VALUES (44, '::1', 'mynivid@gmail.com', 7, '2025-05-02 02:46:03', 1);
INSERT INTO public.auth_logins VALUES (45, '::1', 'mynivid@gmail.com', 7, '2025-05-02 02:52:57', 1);
INSERT INTO public.auth_logins VALUES (46, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 02:55:02', 1);
INSERT INTO public.auth_logins VALUES (47, '::1', 'mynivid@gmail.com', 7, '2025-05-02 02:56:39', 1);
INSERT INTO public.auth_logins VALUES (48, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 02:58:22', 1);
INSERT INTO public.auth_logins VALUES (49, '::1', 'mynivid@gmail.com', 7, '2025-05-02 03:00:29', 1);
INSERT INTO public.auth_logins VALUES (50, '::1', 'admin', NULL, '2025-05-02 03:04:06', 0);
INSERT INTO public.auth_logins VALUES (51, '::1', 'admin@yopmail.com', 1, '2025-05-02 03:04:11', 1);
INSERT INTO public.auth_logins VALUES (52, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 03:04:44', 1);
INSERT INTO public.auth_logins VALUES (53, '::1', 'admin', NULL, '2025-05-02 03:12:16', 0);
INSERT INTO public.auth_logins VALUES (54, '::1', 'admin@yopmail.com', 1, '2025-05-02 03:12:27', 1);
INSERT INTO public.auth_logins VALUES (55, '::1', 'mynivid@gmail.com', 7, '2025-05-02 03:12:51', 1);
INSERT INTO public.auth_logins VALUES (56, '::1', 'admin@yopmail.com', 1, '2025-05-02 03:50:46', 1);
INSERT INTO public.auth_logins VALUES (57, '::1', 'admin@yopmail.com', 1, '2025-05-02 06:27:14', 1);
INSERT INTO public.auth_logins VALUES (58, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 06:30:37', 1);
INSERT INTO public.auth_logins VALUES (59, '::1', 'mynivid@gmail.com', 7, '2025-05-02 06:39:57', 1);
INSERT INTO public.auth_logins VALUES (60, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 06:46:50', 1);
INSERT INTO public.auth_logins VALUES (61, '::1', 'irfandwi@yopmail.com', 18, '2025-05-02 06:49:33', 1);
INSERT INTO public.auth_logins VALUES (62, '::1', 'admin@yopmail.com', 1, '2025-05-02 06:52:00', 1);
INSERT INTO public.auth_logins VALUES (63, '::1', 'mynivid@gmail.com', 7, '2025-05-02 07:01:26', 1);
INSERT INTO public.auth_logins VALUES (64, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 07:03:01', 1);
INSERT INTO public.auth_logins VALUES (65, '::1', 'mynivid@gmail.com', 7, '2025-05-02 07:05:10', 1);
INSERT INTO public.auth_logins VALUES (66, '::1', 'mynivid@gmail.com', 7, '2025-05-02 07:09:12', 1);
INSERT INTO public.auth_logins VALUES (67, '::1', 'ggg', NULL, '2025-05-02 07:10:04', 0);
INSERT INTO public.auth_logins VALUES (68, '::1', 'admin', NULL, '2025-05-02 07:11:00', 0);
INSERT INTO public.auth_logins VALUES (69, '::1', 'admin@yopmail.com', 1, '2025-05-02 07:11:06', 1);
INSERT INTO public.auth_logins VALUES (70, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-02 07:16:03', 1);
INSERT INTO public.auth_logins VALUES (71, '::1', 'admin@yopmail.com', 1, '2025-05-02 21:04:13', 1);
INSERT INTO public.auth_logins VALUES (72, '::1', 'admin@yopmail.com', 1, '2025-05-06 04:52:27', 1);
INSERT INTO public.auth_logins VALUES (73, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-06 05:37:37', 1);
INSERT INTO public.auth_logins VALUES (74, '::1', 'admin@yopmail.com', 1, '2025-05-06 05:39:23', 1);
INSERT INTO public.auth_logins VALUES (75, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 13:19:06', 1);
INSERT INTO public.auth_logins VALUES (76, '::1', 'admin', NULL, '2025-05-07 13:31:34', 0);
INSERT INTO public.auth_logins VALUES (77, '::1', 'admin@yopmail.com', 1, '2025-05-07 13:31:40', 1);
INSERT INTO public.auth_logins VALUES (78, '::1', 'mynivid@gmail.com', 7, '2025-05-07 13:32:34', 1);
INSERT INTO public.auth_logins VALUES (79, '::1', 'mynivid@gmail.com', 7, '2025-05-07 13:33:20', 1);
INSERT INTO public.auth_logins VALUES (80, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 13:35:31', 1);
INSERT INTO public.auth_logins VALUES (81, '::1', 'mynivid@gmail.com', 7, '2025-05-07 13:46:11', 1);
INSERT INTO public.auth_logins VALUES (82, '::1', 'admin@yopmail.com', 1, '2025-05-07 14:04:00', 1);
INSERT INTO public.auth_logins VALUES (83, '::1', 'admin', NULL, '2025-05-07 22:00:32', 0);
INSERT INTO public.auth_logins VALUES (84, '::1', 'admin@yopmail.com', 1, '2025-05-07 22:00:37', 1);
INSERT INTO public.auth_logins VALUES (85, '::1', 'michaeljoe@yopmail.com', 10, '2025-05-07 22:01:30', 1);
INSERT INTO public.auth_logins VALUES (86, '::1', 'drsteve@yopmail.com', 19, '2025-05-07 22:02:25', 1);
INSERT INTO public.auth_logins VALUES (87, '::1', 'admin@yopmail.com', 1, '2025-05-07 22:03:13', 1);
INSERT INTO public.auth_logins VALUES (88, '::1', 'hendrawan@yopmail.com', 14, '2025-05-07 22:03:51', 1);
INSERT INTO public.auth_logins VALUES (89, '::1', 'melindatan@yopmail.com', 17, '2025-05-07 22:06:04', 1);
INSERT INTO public.auth_logins VALUES (90, '::1', 'mynivid@gmail.com', 7, '2025-05-07 22:10:21', 1);
INSERT INTO public.auth_logins VALUES (91, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 22:10:33', 1);
INSERT INTO public.auth_logins VALUES (92, '::1', 'aguspratama@yopmail.com', 16, '2025-05-07 22:11:46', 1);
INSERT INTO public.auth_logins VALUES (93, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 22:12:02', 1);
INSERT INTO public.auth_logins VALUES (94, '::1', 'devirani@yopmail.com', 15, '2025-05-07 22:12:59', 1);
INSERT INTO public.auth_logins VALUES (95, '::1', 'faqih', NULL, '2025-05-07 22:13:54', 0);
INSERT INTO public.auth_logins VALUES (96, '::1', 'mynivid@gmail.com', 7, '2025-05-07 22:14:00', 1);
INSERT INTO public.auth_logins VALUES (97, '::1', 'drleonard', NULL, '2025-05-07 22:15:15', 0);
INSERT INTO public.auth_logins VALUES (98, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 22:15:20', 1);
INSERT INTO public.auth_logins VALUES (99, '::1', 'drleon@yopmail.com', 5, '2025-05-07 22:15:59', 1);
INSERT INTO public.auth_logins VALUES (100, '::1', 'admin@yopmail.com', 1, '2025-05-07 22:17:51', 1);
INSERT INTO public.auth_logins VALUES (101, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-07 22:21:43', 1);
INSERT INTO public.auth_logins VALUES (102, '::1', 'sarahlim@yopmail.com', 13, '2025-05-07 22:22:46', 1);
INSERT INTO public.auth_logins VALUES (103, '::1', 'admin', NULL, '2025-05-07 22:44:48', 0);
INSERT INTO public.auth_logins VALUES (104, '::1', 'admin@yopmail.com', 1, '2025-05-07 22:44:53', 1);
INSERT INTO public.auth_logins VALUES (105, '::1', 'admin@yopmail.com', 1, '2025-05-08 02:53:38', 1);
INSERT INTO public.auth_logins VALUES (106, '::1', 'admin@yopmail.com', 1, '2025-05-08 02:56:20', 1);
INSERT INTO public.auth_logins VALUES (107, '::1', 'drtirta', NULL, '2025-05-08 03:00:07', 0);
INSERT INTO public.auth_logins VALUES (108, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-08 03:00:21', 1);
INSERT INTO public.auth_logins VALUES (109, '::1', 'mynivid@gmail.com', 7, '2025-05-08 03:02:33', 1);
INSERT INTO public.auth_logins VALUES (110, '::1', 'admin@yopmail.com', 1, '2025-05-08 03:05:47', 1);
INSERT INTO public.auth_logins VALUES (111, '::1', 'mynivid@gmail.com', 7, '2025-05-08 03:46:06', 1);
INSERT INTO public.auth_logins VALUES (112, '::1', 'admin@yopmail.com', 1, '2025-05-08 04:18:34', 1);
INSERT INTO public.auth_logins VALUES (113, '::1', 'mynivid@gmail.com', 7, '2025-05-08 04:24:33', 1);
INSERT INTO public.auth_logins VALUES (114, '::1', 'drsteve@yopmail.com', 19, '2025-05-08 04:51:16', 1);
INSERT INTO public.auth_logins VALUES (115, '::1', 'mynivid@gmail.com', 7, '2025-05-08 04:53:16', 1);
INSERT INTO public.auth_logins VALUES (116, '::1', 'admin@yopmail.com', 1, '2025-05-08 04:56:55', 1);
INSERT INTO public.auth_logins VALUES (117, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-08 05:13:06', 1);
INSERT INTO public.auth_logins VALUES (118, '::1', 'johnsmith@yopmail.com', 8, '2025-05-08 05:37:48', 1);
INSERT INTO public.auth_logins VALUES (119, '::1', 'anitarahma@yopmail.com', 9, '2025-05-08 05:39:36', 1);
INSERT INTO public.auth_logins VALUES (120, '::1', 'mynivid@gmail.com', 7, '2025-05-08 06:30:18', 1);
INSERT INTO public.auth_logins VALUES (121, '::1', 'admin@yopmail.com', 1, '2025-05-08 06:31:20', 1);
INSERT INTO public.auth_logins VALUES (122, '::1', 'mynivid@gmail.com', 7, '2025-05-08 07:17:43', 1);
INSERT INTO public.auth_logins VALUES (123, '::1', 'mynivid@gmail.com', 7, '2025-05-08 07:47:58', 1);
INSERT INTO public.auth_logins VALUES (124, '::1', '2011500457@student.budiluhur.ac.id', 2, '2025-05-08 07:55:28', 1);
INSERT INTO public.auth_logins VALUES (125, '::1', 'admin@yopmail.com', 1, '2025-05-08 07:58:06', 1);
INSERT INTO public.auth_logins VALUES (126, '::1', 'mynivid@gmail.com', 7, '2025-05-08 08:09:20', 1);
INSERT INTO public.auth_logins VALUES (127, '::1', 'admin', NULL, '2025-05-08 08:16:04', 0);
INSERT INTO public.auth_logins VALUES (128, '::1', 'admin@yopmail.com', 1, '2025-05-08 08:16:11', 1);
INSERT INTO public.auth_logins VALUES (129, '::1', 'mynivid@gmail.com', 7, '2025-05-08 08:16:50', 1);


--
-- TOC entry 5028 (class 0 OID 29820)
-- Dependencies: 232
-- Data for Name: auth_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5022 (class 0 OID 29793)
-- Dependencies: 226
-- Data for Name: auth_reset_attempts; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_reset_attempts VALUES (1, 'irfandwi@yopmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '226c6e56013353cd3c3a967d1094e3f2', '2025-05-01 16:01:06');


--
-- TOC entry 5020 (class 0 OID 29778)
-- Dependencies: 224
-- Data for Name: auth_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5031 (class 0 OID 29860)
-- Dependencies: 235
-- Data for Name: auth_users_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5049 (class 0 OID 29989)
-- Dependencies: 253
-- Data for Name: doctor_absents; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.doctor_absents VALUES (1, 1, '2025-05-07 00:00:00', NULL, 'Holiday', '2025-05-01 19:09:35', '2025-05-01 19:09:35');


--
-- TOC entry 5033 (class 0 OID 29877)
-- Dependencies: 237
-- Data for Name: doctor_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.doctor_category VALUES (1, 'dentist', 'Dokter Gigi');
INSERT INTO public.doctor_category VALUES (2, 'pediatrician', 'Dokter Anak');
INSERT INTO public.doctor_category VALUES (4, 'Dokter Kanker', 'Kanker');
INSERT INTO public.doctor_category VALUES (3, 'general practitioner', 'Dokter Umum');
INSERT INTO public.doctor_category VALUES (5, 'Dokter Ibu hamil', 'Dokter Ibu hamil');


--
-- TOC entry 5045 (class 0 OID 29945)
-- Dependencies: 249
-- Data for Name: doctor_schedules; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.doctor_schedules VALUES (1, 2, 1, '07:00:00', '12:00:00', 10, 'active', '2025-05-01 17:22:17', '2025-05-01 17:22:17');
INSERT INTO public.doctor_schedules VALUES (2, 1, 1, '12:00:00', '15:00:00', 5, 'active', '2025-05-01 17:22:39', '2025-05-01 17:22:39');
INSERT INTO public.doctor_schedules VALUES (3, 4, 1, '15:00:00', '20:00:00', 15, 'active', '2025-05-01 17:23:21', '2025-05-01 17:23:21');
INSERT INTO public.doctor_schedules VALUES (4, 2, 2, '12:00:00', '15:00:00', 10, 'active', '2025-05-01 17:24:09', '2025-05-01 17:24:09');
INSERT INTO public.doctor_schedules VALUES (5, 6, 2, '15:00:00', '20:00:00', 15, 'active', '2025-05-01 17:24:32', '2025-05-01 17:24:32');
INSERT INTO public.doctor_schedules VALUES (6, 7, 2, '07:00:00', '12:00:00', 10, 'active', '2025-05-01 17:24:54', '2025-05-01 17:24:54');
INSERT INTO public.doctor_schedules VALUES (8, 3, 3, '12:00:00', '15:00:00', 10, 'active', '2025-05-01 17:25:41', '2025-05-01 17:25:41');
INSERT INTO public.doctor_schedules VALUES (9, 7, 3, '15:00:00', '20:00:00', 13, 'active', '2025-05-01 17:26:24', '2025-05-01 17:26:24');
INSERT INTO public.doctor_schedules VALUES (10, 4, 3, '20:00:00', '23:00:00', 10, 'active', '2025-05-01 17:37:03', '2025-05-01 17:37:03');
INSERT INTO public.doctor_schedules VALUES (11, 5, 1, '03:00:00', '07:00:00', 10, 'active', '2025-05-01 17:37:37', '2025-05-01 17:37:37');
INSERT INTO public.doctor_schedules VALUES (12, 6, 1, '20:00:00', '23:00:00', 10, 'active', '2025-05-01 17:38:32', '2025-05-01 17:38:32');
INSERT INTO public.doctor_schedules VALUES (13, 3, 2, '20:00:00', '23:00:00', 10, 'active', '2025-05-01 17:39:20', '2025-05-01 17:39:20');
INSERT INTO public.doctor_schedules VALUES (14, 1, 2, '03:00:00', '07:00:00', 7, 'active', '2025-05-01 17:41:06', '2025-05-01 17:41:06');
INSERT INTO public.doctor_schedules VALUES (7, 5, 3, '03:00:00', '07:00:00', 10, 'active', '2025-05-01 17:25:20', '2025-05-01 17:44:35');
INSERT INTO public.doctor_schedules VALUES (15, 1, 3, '07:00:00', '12:00:00', 9, 'active', '2025-05-01 17:45:14', '2025-05-01 17:45:14');
INSERT INTO public.doctor_schedules VALUES (17, 4, 3, '23:00:00', '23:59:00', 2, 'active', '2025-05-07 14:25:46', '2025-05-07 14:25:46');
INSERT INTO public.doctor_schedules VALUES (18, 2, 1, '23:00:00', '23:59:00', 2, 'active', '2025-05-08 08:01:58', '2025-05-08 08:01:58');


--
-- TOC entry 5035 (class 0 OID 29886)
-- Dependencies: 239
-- Data for Name: doctors; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.doctors VALUES (2, 'James', 'Jones', '081234567890', 'Jl. Merdeka No. 123, Jakarta', 'male', '1980-05-14', 'drjones@yopmail.com', 'uploads/doctors/3/profile_picture/profile_picture_3_2025_05_01_1746111518.jfif', 2, 3, '2025-05-01 14:58:38', '2025-05-01 14:58:38', NULL);
INSERT INTO public.doctors VALUES (1, 'Tirta', 'Mandira', '085230352769', 'Jl. Raya Legok - Karawaci', 'male', '1983-05-14', '2011500457@student.budiluhur.ac.id', 'uploads/doctors/2/profile_picture/profile_picture_2_2025_05_01_1746111535.jfif', 1, 2, '2025-05-01 14:53:50', '2025-05-01 14:58:55', NULL);
INSERT INTO public.doctors VALUES (3, 'Susan', 'Tan', '082198745632', 'Jl. Diponegoro No. 45, Surabaya', 'female', '1985-08-22', 'drsusan@yopmail.com', 'uploads/doctors/4/profile_picture/profile_picture_4_2025_05_01_1746111714.jpg', 3, 4, '2025-05-01 15:01:54', '2025-05-01 15:01:54', NULL);
INSERT INTO public.doctors VALUES (4, 'Leonard', 'Wijaya', '081322114455', 'Jl. Asia Afrika No. 99, Bandung', 'male', '1978-12-03', 'drleon@yopmail.com', 'uploads/doctors/5/profile_picture/profile_picture_5_2025_05_01_1746111898.jpg', 2, 5, '2025-05-01 15:04:58', '2025-05-01 15:04:58', NULL);
INSERT INTO public.doctors VALUES (5, 'Melissa', 'Halim', '083122334455', 'Jl. Pemuda No. 7, Semarang', 'female', '1990-07-09', 'drmelissa@yopmail.com', 'uploads/doctors/6/profile_picture/profile_picture_6_2025_05_01_1746112039.jpg', 3, 6, '2025-05-01 15:07:19', '2025-05-01 15:07:19', NULL);
INSERT INTO public.doctors VALUES (6, 'Steve', 'Joe', '08123456789', 'Jl. Cendana No. 9, Makassar', 'male', '1883-02-23', 'drsteve@yopmail.com', 'uploads/doctors/19/profile_picture/profile_picture_19_2025_05_01_1746115643.jpeg', 1, 19, '2025-05-01 16:07:23', '2025-05-01 16:07:23', NULL);
INSERT INTO public.doctors VALUES (7, 'Well', 'Done', '08987654321', 'Jl. Merpati No. 2, Bali', 'female', '2002-03-19', 'drwell@yopmail.com', 'uploads/doctors/20/profile_picture/profile_picture_20_2025_05_01_1746115782.jpg', 2, 20, '2025-05-01 16:08:53', '2025-05-01 16:09:42', NULL);


--
-- TOC entry 5039 (class 0 OID 29919)
-- Dependencies: 243
-- Data for Name: educations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.educations VALUES (1, 1, 'Universitas Indonesia', 'Jakarta', 'Dentist', 'Master', '2013', '2025-05-01 14:53:50', '2025-05-01 14:53:50', NULL);
INSERT INTO public.educations VALUES (2, 1, 'Universitas Gajah Mada', 'Yogyakarta', 'Dentist', 'Doctor', '2020', '2025-05-01 14:53:50', '2025-05-01 14:53:50', NULL);
INSERT INTO public.educations VALUES (3, 2, 'Universitas Indonesia', 'Jakarta', 'General Medicine', 'Master', '2005', '2025-05-01 14:58:38', '2025-05-01 14:58:38', NULL);
INSERT INTO public.educations VALUES (4, 3, 'Universitas Airlangga', 'Surabaya', 'General Medicine', 'Doctor', '2009', '2025-05-01 15:01:54', '2025-05-01 15:01:54', NULL);
INSERT INTO public.educations VALUES (5, 4, 'Universitas Padjadjaran', 'Bandung', 'General Medicine', 'Bachelor', '2002', '2025-05-01 15:04:58', '2025-05-01 15:04:58', NULL);
INSERT INTO public.educations VALUES (6, 4, 'Universitas Indonesia', 'Jakarta', 'Pediatrics', 'Master', '2007', '2025-05-01 15:04:58', '2025-05-01 15:04:58', NULL);
INSERT INTO public.educations VALUES (7, 4, 'University of Melbourne', 'Melbourne', 'Child Development', 'Doctor', '2012', '2025-05-01 15:04:58', '2025-05-01 15:04:58', NULL);
INSERT INTO public.educations VALUES (8, 5, 'Universitas Diponegoro', 'Semarang', 'General Medicine', 'Master', '2014', '2025-05-01 15:07:19', '2025-05-01 15:07:19', NULL);
INSERT INTO public.educations VALUES (9, 5, 'Universitas Airlangga', 'Surabaya', 'Dermatology', 'Doctor', '2018', '2025-05-01 15:07:19', '2025-05-01 15:07:19', NULL);
INSERT INTO public.educations VALUES (10, 6, 'Universitas Budi Luhur', 'Jakarta', 'Dentist', 'Doctor', '2024', '2025-05-01 16:07:23', '2025-05-01 16:07:23', NULL);
INSERT INTO public.educations VALUES (11, 7, 'Oxford University', 'Los Angels', 'Peditrician', 'Doctor', '2003', '2025-05-01 16:08:53', '2025-05-01 16:08:53', NULL);


--
-- TOC entry 5055 (class 0 OID 30027)
-- Dependencies: 259
-- Data for Name: equipment_rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.equipment_rooms VALUES (1, 1, 2, 16);
INSERT INTO public.equipment_rooms VALUES (2, 1, 9, 18);
INSERT INTO public.equipment_rooms VALUES (3, 1, 14, 17);
INSERT INTO public.equipment_rooms VALUES (4, 1, 11, 9);
INSERT INTO public.equipment_rooms VALUES (5, 1, 12, 9);
INSERT INTO public.equipment_rooms VALUES (6, 2, 5, 19);
INSERT INTO public.equipment_rooms VALUES (7, 2, 13, 20);
INSERT INTO public.equipment_rooms VALUES (8, 2, 14, 11);
INSERT INTO public.equipment_rooms VALUES (9, 2, 11, 16);
INSERT INTO public.equipment_rooms VALUES (10, 2, 2, 10);
INSERT INTO public.equipment_rooms VALUES (11, 3, 7, 11);
INSERT INTO public.equipment_rooms VALUES (12, 3, 9, 20);
INSERT INTO public.equipment_rooms VALUES (13, 3, 13, 9);
INSERT INTO public.equipment_rooms VALUES (14, 3, 3, 11);
INSERT INTO public.equipment_rooms VALUES (15, 3, 11, 5);
INSERT INTO public.equipment_rooms VALUES (16, 3, 12, 4);


--
-- TOC entry 5043 (class 0 OID 29938)
-- Dependencies: 247
-- Data for Name: equipments; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.equipments VALUES (4, 'Surgical Gloves', 'Worn during procedures to maintain sterility.', 245, 'Available', '2025-05-01 16:31:16', '2025-05-01 16:31:16', NULL);
INSERT INTO public.equipments VALUES (6, 'IV Cannula', 'Provides intravenous access for fluids and medications.', 0, 'Out Of Stock', '2025-05-01 16:32:09', '2025-05-01 16:32:09', NULL);
INSERT INTO public.equipments VALUES (8, 'Cotton Ball', 'Used for cleaning wounds or applying medication.', 0, 'Out Of Stock', '2025-05-01 16:32:48', '2025-05-01 16:32:48', NULL);
INSERT INTO public.equipments VALUES (1, 'Tongue Depressor', 'Holds the tongue down to examine the mouth and throat.', 0, 'Out Of Stock', '2025-05-01 16:30:02', '2025-05-01 16:36:53', NULL);
INSERT INTO public.equipments VALUES (10, 'Disposable Gown', 'Protects clothing and skin during medical procedures.', 3, 'Available', '2025-05-01 16:33:41', '2025-05-01 16:37:06', NULL);
INSERT INTO public.equipments VALUES (5, 'Face Mask', 'Protects against airborne pathogens.', 413, 'Available', '2025-05-01 16:31:47', '2025-05-01 17:20:48', NULL);
INSERT INTO public.equipments VALUES (14, 'Bandage Strip', 'Covers small cuts or wounds.', 25, 'Available', '2025-05-01 16:35:04', '2025-05-01 17:20:48', NULL);
INSERT INTO public.equipments VALUES (2, 'Syringe', 'Used for injections or drawing fluids.', 31, 'Available', '2025-05-01 16:30:30', '2025-05-01 17:20:48', NULL);
INSERT INTO public.equipments VALUES (7, 'Alcohol Swab', 'Disinfects skin before injection.', 68, 'Available', '2025-05-01 16:32:30', '2025-05-01 17:21:34', NULL);
INSERT INTO public.equipments VALUES (9, 'Surgical Mask', 'Worn to prevent the spread of infection during surgery.', 562, 'Available', '2025-05-01 16:33:14', '2025-05-01 17:21:34', NULL);
INSERT INTO public.equipments VALUES (13, 'ECG Electrode', 'Adheres to skin for ECG signal detection.', 221, 'Available', '2025-05-01 16:34:44', '2025-05-01 17:21:34', NULL);
INSERT INTO public.equipments VALUES (3, 'Scalpel Blade', 'Used for making precise surgical incisions.', 108, 'Available', '2025-05-01 16:30:52', '2025-05-01 17:21:34', NULL);
INSERT INTO public.equipments VALUES (11, 'Plastic Apron', 'Protects against spills and splashes.', 67, 'Available', '2025-05-01 16:34:01', '2025-05-08 05:01:02', NULL);
INSERT INTO public.equipments VALUES (15, 'Sarung Tangan', 'Untuk melindungi tangan', 0, 'Out Of Stock', '2025-05-02 06:55:42', '2025-05-08 08:02:37', NULL);
INSERT INTO public.equipments VALUES (12, 'Specimen Container', 'Used to collect and transport samples.', 16, 'Available', '2025-05-01 16:34:22', '2025-05-08 08:04:20', NULL);


--
-- TOC entry 5059 (class 0 OID 30055)
-- Dependencies: 263
-- Data for Name: histories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.histories VALUES (1, 3, 1, 'The patient reported a sore throat and mild fever. ', 'Paracetamol 500mg to be taken every 6 hours as needed. Warm salt water gargle twice daily.', 'uploads/patients/7/medical_document/medical_document_7_2025_05_01_1746125686.pdf', '2025-05-01 18:54:46', '2025-05-01 18:54:46');
INSERT INTO public.histories VALUES (2, 1, 1, 'The patient complained of a persistent cough lasting over two weeks.', 'Montelukast 10mg at bedtime and Levocetirizine 5mg at bedtime. Daily steam inhalation advised.', 'uploads/patients/7/medical_document/medical_document_7_2025_05_01_1746126039.pdf', '2025-05-01 19:00:39', '2025-05-01 19:00:39');
INSERT INTO public.histories VALUES (3, 4, 12, 'iya dia sakit gigi', 'obat kumur', 'uploads/patients/18/medical_document/medical_document_18_2025_05_02_1746168511.pdf', '2025-05-02 06:48:31', '2025-05-02 06:48:31');
INSERT INTO public.histories VALUES (4, 19, 4, 'Eat some vegetable', 'Just eat vegetable, no need for drugs', NULL, '2025-05-07 22:02:54', '2025-05-07 22:02:54');
INSERT INTO public.histories VALUES (5, 28, 1, 'He must take some rest', 'Paracetamol 1x1 day,
', NULL, '2025-05-07 22:16:36', '2025-05-07 22:16:36');
INSERT INTO public.histories VALUES (6, 30, 1, 'Get some rest', 'No need for drugs', 'uploads/patients/7/medical_document/medical_document_7_2025_05_08_1746679956.pdf', '2025-05-08 04:52:36', '2025-05-08 04:52:36');


--
-- TOC entry 5051 (class 0 OID 30001)
-- Dependencies: 255
-- Data for Name: inventories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.inventories VALUES (14, 'INV-ICEMDP', 'Table', 'To place some stuff', 'Available', '2025-05-01 17:15:04', '2025-05-01 17:15:04', NULL);
INSERT INTO public.inventories VALUES (1, 'INV-L7NNB9', 'Heart Rate Monitor', 'Too see the heart rate of the patient', 'In Use', '2025-05-01 17:09:46', '2025-05-01 17:18:44', NULL);
INSERT INTO public.inventories VALUES (9, 'INV-PJTVEC', 'Table', 'To place some stuff', 'In Use', '2025-05-01 17:13:26', '2025-05-01 17:18:44', NULL);
INSERT INTO public.inventories VALUES (13, 'INV-XFHXOY', 'Tensimeter', 'To see the heart rate of the patient', 'In Use', '2025-05-01 17:14:33', '2025-05-01 17:18:44', NULL);
INSERT INTO public.inventories VALUES (6, 'INV-TZDB5D', 'Bed', 'For patient to lie down', 'In Use', '2025-05-01 17:11:00', '2025-05-01 17:18:44', NULL);
INSERT INTO public.inventories VALUES (7, 'INV-KJ8KB9', 'Infusion Pole', 'To hold the infuse that connect to the patient', 'In Use', '2025-05-01 17:12:16', '2025-05-01 17:20:10', NULL);
INSERT INTO public.inventories VALUES (11, 'INV-RVBY73', 'Table', 'To place some stuff', 'In Use', '2025-05-01 17:13:42', '2025-05-01 17:20:10', NULL);
INSERT INTO public.inventories VALUES (3, 'INV-PVWHM4', 'Bed', 'For patient to lie down', 'In Use', '2025-05-01 17:10:27', '2025-05-01 17:20:10', NULL);
INSERT INTO public.inventories VALUES (12, 'INV-KL6ENS', 'Tensimeter', 'To see the heart rate of the patient', 'In Use', '2025-05-01 17:14:26', '2025-05-01 17:20:10', NULL);
INSERT INTO public.inventories VALUES (5, 'INV-8INFKP', 'Bed', 'For patient to lie down', 'In Use', '2025-05-01 17:10:49', '2025-05-01 17:21:11', NULL);
INSERT INTO public.inventories VALUES (8, 'INV-VGKLW5', 'Infusion Pole', 'To hold the infuse that connect to the patient', 'In Use', '2025-05-01 17:12:24', '2025-05-01 17:21:11', NULL);
INSERT INTO public.inventories VALUES (10, 'INV-YWUIOS', 'Table', 'To place some stuff', 'In Use', '2025-05-01 17:13:34', '2025-05-01 17:21:11', NULL);
INSERT INTO public.inventories VALUES (2, 'INV-JKGRXI', 'Heart Rate Monitor', 'Too see the heart rate of the patient', 'In Use', '2025-05-01 17:09:57', '2025-05-01 17:21:11', NULL);
INSERT INTO public.inventories VALUES (16, 'INV-ESL22H', 'Bed', 'For patient to rest', 'Available', '2025-05-08 08:03:18', '2025-05-08 08:03:18', NULL);
INSERT INTO public.inventories VALUES (4, 'INV-CWKAC2', 'Bed', 'For patient to lie down', 'In Use', '2025-05-01 17:10:38', '2025-05-08 08:03:59', NULL);


--
-- TOC entry 5053 (class 0 OID 30010)
-- Dependencies: 257
-- Data for Name: inventory_rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.inventory_rooms VALUES (1, 1, 1);
INSERT INTO public.inventory_rooms VALUES (2, 1, 9);
INSERT INTO public.inventory_rooms VALUES (3, 1, 13);
INSERT INTO public.inventory_rooms VALUES (4, 1, 6);
INSERT INTO public.inventory_rooms VALUES (5, 2, 7);
INSERT INTO public.inventory_rooms VALUES (6, 2, 11);
INSERT INTO public.inventory_rooms VALUES (7, 2, 3);
INSERT INTO public.inventory_rooms VALUES (8, 2, 12);
INSERT INTO public.inventory_rooms VALUES (9, 3, 5);
INSERT INTO public.inventory_rooms VALUES (10, 3, 8);
INSERT INTO public.inventory_rooms VALUES (11, 3, 10);
INSERT INTO public.inventory_rooms VALUES (12, 3, 2);
INSERT INTO public.inventory_rooms VALUES (13, 3, 4);


--
-- TOC entry 5014 (class 0 OID 29743)
-- Dependencies: 218
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.migrations VALUES (1, '2017-11-20-223112', 'Myth\Auth\Database\Migrations\CreateAuthTables', 'default', 'Myth\Auth', 1746109495, 1);
INSERT INTO public.migrations VALUES (2, '2025-04-09-085339', 'App\Database\Migrations\CreateDoctorCategoryTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (3, '2025-04-09-085430', 'App\Database\Migrations\CreateDoctorTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (4, '2025-04-09-085511', 'App\Database\Migrations\CreatePatientTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (5, '2025-04-10-043720', 'App\Database\Migrations\CreateEducationTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (6, '2025-04-11-060605', 'App\Database\Migrations\CreateRoomTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (7, '2025-04-11-061354', 'App\Database\Migrations\CreateEquipmentTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (8, '2025-04-14-014208', 'App\Database\Migrations\CreateDoctorScheduleTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (9, '2025-04-14-014209', 'App\Database\Migrations\CreateAppointmentTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (10, '2025-04-14-014704', 'App\Database\Migrations\CreateDoctorAbsentTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (11, '2025-04-17-141358', 'App\Database\Migrations\CreateInventoryTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (12, '2025-04-17-221805', 'App\Database\Migrations\CreateInventoryRoomTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (13, '2025-04-17-221818', 'App\Database\Migrations\CreateEquipmentRoomTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (14, '2025-04-23-013519', 'App\Database\Migrations\CreateSettingsTable', 'default', 'App', 1746109495, 1);
INSERT INTO public.migrations VALUES (15, '2025-04-24-020528', 'App\Database\Migrations\CreateHistoryTable', 'default', 'App', 1746109495, 1);


--
-- TOC entry 5037 (class 0 OID 29905)
-- Dependencies: 241
-- Data for Name: patients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.patients VALUES (1, 'Faqih', 'Abdillah', '085770302069', 'Binong Permai, I 19/23', 'male', 'non-BPJS(Swasta)', '2004-05-03', 'mynivid@gmail.com', 'uploads/patients/7/profile_picture/profile_picture_7_2025_05_01_1746114160.jpg', 7, '2025-05-01 15:42:40', '2025-05-01 15:42:40', NULL);
INSERT INTO public.patients VALUES (2, 'John', 'Smith', '081234111222', 'Jl. Kenanga No. 10, Jakarta', 'male', 'BPJS', '1975-11-27', 'johnsmith@yopmail.com', '', 8, '2025-05-01 15:44:30', '2025-05-01 15:44:30', NULL);
INSERT INTO public.patients VALUES (3, 'Anita', 'Rahma', '082188899900', 'Jl. Mawar No. 5, Bandung', 'female', 'Regular', '1995-09-25', 'anitarahma@yopmail.com', 'uploads/patients/9/profile_picture/profile_picture_9_2025_05_01_1746114422.jfif', 9, '2025-05-01 15:47:02', '2025-05-01 15:47:02', NULL);
INSERT INTO public.patients VALUES (4, 'Michael', 'Joe', '081355566677', 'Jl. Melati No. 21, Surabaya', 'male', 'non-BPJS(Swasta)', '2000-06-10', 'michaeljoe@yopmail.com', 'uploads/patients/10/profile_picture/profile_picture_10_2025_05_01_1746114521.jpeg', 10, '2025-05-01 15:48:41', '2025-05-01 15:48:41', NULL);
INSERT INTO public.patients VALUES (5, 'Cynthia', 'Tan', '083177788899', 'Jl. Anggrek No. 3, Medan', 'female', 'non-BPJS(Swasta)', '1995-03-19', 'cynthiatan@yopmail.com', 'uploads/patients/11/profile_picture/profile_picture_11_2025_05_01_1746114629.jfif', 11, '2025-05-01 15:50:29', '2025-05-01 15:50:29', NULL);
INSERT INTO public.patients VALUES (6, 'Rizky', 'Andi', '085612345123', 'Jl. Flamboyan No. 12, Yogyakarta', 'male', 'BPJS', '1992-09-04', 'rizkyandi@yopmail.com', 'uploads/patients/12/profile_picture/profile_picture_12_2025_05_01_1746114692.jpeg', 12, '2025-05-01 15:51:32', '2025-05-01 15:51:32', NULL);
INSERT INTO public.patients VALUES (7, 'Sarah', 'Lim', '081245678901', 'Jl. Sakura No. 7, Jakarta', 'female', 'Regular', '1991-03-17', 'sarahlim@yopmail.com', 'uploads/patients/13/profile_picture/profile_picture_13_2025_05_01_1746114767.jfif', 13, '2025-05-01 15:52:47', '2025-05-01 15:52:47', NULL);
INSERT INTO public.patients VALUES (8, 'Hendra', 'Wan', '081377788899', 'Jl. Teratai No. 15, Bandung', 'male', 'BPJS', '1997-04-23', 'hendrawan@yopmail.com', 'uploads/patients/14/profile_picture/profile_picture_14_2025_05_01_1746114831.jpeg', 14, '2025-05-01 15:53:51', '2025-05-01 15:53:51', NULL);
INSERT INTO public.patients VALUES (9, 'Devi', 'Rani', '082198765432', 'Jl. Cemara No. 6, Semarang', 'female', 'non-BPJS(Swasta)', '1973-09-18', 'devirani@yopmail.com', 'uploads/patients/15/profile_picture/profile_picture_15_2025_05_01_1746114900.jfif', 15, '2025-05-01 15:55:00', '2025-05-01 15:55:00', NULL);
INSERT INTO public.patients VALUES (10, 'Agus', 'Pratama', '085611223344', 'Jl. Kamboja No. 18, Surabaya', 'male', 'Regular', '1988-05-30', 'aguspratama@yopmail.com', 'uploads/patients/16/profile_picture/profile_picture_16_2025_05_01_1746114962.jpeg', 16, '2025-05-01 15:56:02', '2025-05-01 15:56:02', NULL);
INSERT INTO public.patients VALUES (11, 'Melinda', 'Tan', '083155566677', 'Jl. Merpati No. 2, Bali', 'female', 'BPJS', '2000-03-09', 'melindatan@yopmail.com', 'uploads/patients/17/profile_picture/profile_picture_17_2025_05_01_1746115025.jfif', 17, '2025-05-01 15:57:05', '2025-05-01 15:57:05', NULL);
INSERT INTO public.patients VALUES (12, 'Irfan', 'Dwi', '081388889999', 'Jl. Cendana No. 9, Makassar', 'male', 'non-BPJS(Swasta)', '1994-03-17', 'irfandwi@yopmail.com', 'uploads/patients/18/profile_picture/profile_picture_18_2025_05_01_1746115135.jpeg', 18, '2025-05-01 15:58:55', '2025-05-01 15:58:55', NULL);


--
-- TOC entry 5041 (class 0 OID 29931)
-- Dependencies: 245
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.rooms VALUES (1, 'General Room', 'For general sickness', 'Active', '2025-05-01 17:15:36', '2025-05-01 17:15:36', NULL);
INSERT INTO public.rooms VALUES (2, 'High Care Unit', 'For patient that have worst condition', 'Active', '2025-05-01 17:16:53', '2025-05-01 17:16:53', NULL);
INSERT INTO public.rooms VALUES (3, 'Operation Room', 'For operation to patient', 'Active', '2025-05-01 17:18:16', '2025-05-01 17:18:16', NULL);


--
-- TOC entry 5057 (class 0 OID 30044)
-- Dependencies: 261
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.settings VALUES (1, 'reminder_days', '7,3,1', 'Reminder For Appointment');
INSERT INTO public.settings VALUES (2, 'cancel_due', '3', 'For due cancelation appointment');


--
-- TOC entry 5016 (class 0 OID 29752)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (1, 'admin@yopmail.com', 'admin', '$2y$10$SYE250CiLyYt/lZQr..TfeXOn3FMMsYQI2rlMJgxNEW6tBfNdjbRK', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 14:26:24', '2025-05-01 14:26:24', NULL);
INSERT INTO public.users VALUES (2, '2011500457@student.budiluhur.ac.id', 'drtirta', '$2y$10$1pCEnlUXcFXxj6pCEaBqIOoownfNVjboHDXVwWsCUWmdA4Wl3Gsya', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 14:53:50', '2025-05-01 14:53:50', NULL);
INSERT INTO public.users VALUES (3, 'drjones@yopmail.com', 'drjones', '$2y$10$U2jNxOA8j/acUKUocHrhQuLbGk.7JvDTiY9buvDEkS9wlYqoYVsXm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 14:58:38', '2025-05-01 14:58:38', NULL);
INSERT INTO public.users VALUES (4, 'drsusan@yopmail.com', 'drsusan', '$2y$10$dfB92GHRoAgbkL2rt9KbUOuP/rPh.tcgydbeCxm4EJoqyBZ8gLG72', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:01:54', '2025-05-01 15:01:54', NULL);
INSERT INTO public.users VALUES (5, 'drleon@yopmail.com', 'drleon', '$2y$10$ipNRt4AjtgAONH2oKOx/L.rHrFrx4lM50ll/qgUpxHZOhdXufdclC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:04:58', '2025-05-01 15:04:58', NULL);
INSERT INTO public.users VALUES (6, 'drmelissa@yopmail.com', 'drmelissa', '$2y$10$cmrnysnsJNGygrG0EZdvSOiM8eTvaLg6m88Da82SXo6csBJTnzx9m', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:07:19', '2025-05-01 15:07:19', NULL);
INSERT INTO public.users VALUES (7, 'mynivid@gmail.com', 'faqih', '$2y$10$1XcgAh2QkI6eCT.Ys1wBzOPsUiCcqfwbtNTClDW89Nub4tG4qD9bC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:42:40', '2025-05-01 15:42:40', NULL);
INSERT INTO public.users VALUES (8, 'johnsmith@yopmail.com', 'johnsmith', '$2y$10$cDzrq./Og1lw6LAJvUyR0.PUPQPp5LMhWuAhWEo04H.bzD.nkn9FW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:44:30', '2025-05-01 15:44:30', NULL);
INSERT INTO public.users VALUES (9, 'anitarahma@yopmail.com', 'anitarahma', '$2y$10$EpuEQ.4B607qArYJTk2IXuI9lXm2MjzIBMb7ysBp4QvXWKf3lSot.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:47:01', '2025-05-01 15:47:01', NULL);
INSERT INTO public.users VALUES (10, 'michaeljoe@yopmail.com', 'michaeljoe', '$2y$10$gVZARSUm.RkjHIW/Z4WCIuYYq/EUCtiF5lhpr/cJt91GT.ER2OJdG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:48:41', '2025-05-01 15:48:41', NULL);
INSERT INTO public.users VALUES (11, 'cynthiatan@yopmail.com', 'cynthiatan', '$2y$10$3.ZjoO49Mw0JfpAPqYx3Quqza7Xs5BLuoyxgmuZtAlECI1IFFOxDC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:50:29', '2025-05-01 15:50:29', NULL);
INSERT INTO public.users VALUES (12, 'rizkyandi@yopmail.com', 'rizkyandi', '$2y$10$w1f4/QdBjEOWJ06CvcUfheuNYuTlSSH0nMclqr8Rpm4/oRLO1vhWC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:51:32', '2025-05-01 15:51:32', NULL);
INSERT INTO public.users VALUES (13, 'sarahlim@yopmail.com', 'sarahlim', '$2y$10$VVRwvAuExMK2W1tJ2O9VD.zOzSblFq86TONGgzspyabPAfQTJ8Qya', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:52:47', '2025-05-01 15:52:47', NULL);
INSERT INTO public.users VALUES (14, 'hendrawan@yopmail.com', 'hendrawan', '$2y$10$h1p7TnhHI10ioaaJHIwvFOoq4NrwP1ZpNQOp9KgVZ7WQIETKdcElG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:53:51', '2025-05-01 15:53:51', NULL);
INSERT INTO public.users VALUES (15, 'devirani@yopmail.com', 'devirani', '$2y$10$FTqKFSgVj.1o8YxLURuiLeSbIzQqLMIqxzoiTnujzdwQChT23oFJm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:55:00', '2025-05-01 15:55:00', NULL);
INSERT INTO public.users VALUES (16, 'aguspratama@yopmail.com', 'aguspratama', '$2y$10$liWdHbDnvJRtNiCvUNLWYOrlArnUrh2bRb6iEJZlmruHan8R/i5kS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:56:02', '2025-05-01 15:56:02', NULL);
INSERT INTO public.users VALUES (17, 'melindatan@yopmail.com', 'melindatan', '$2y$10$Fn/OyvS21o3wcJhPCYbqXuaEsf12fH5LNmWwL8u77t3YBUiXdZEC.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:57:05', '2025-05-01 15:57:05', NULL);
INSERT INTO public.users VALUES (18, 'irfandwi@yopmail.com', 'irfandwi', '$2y$10$gdEctMMBZJbCKJeSGXLV2.vkCsBhV6WGMqVjkqUwUcrbuC3x05LZW', NULL, '2025-05-01 16:01:07', NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 15:58:51', '2025-05-01 16:01:07', NULL);
INSERT INTO public.users VALUES (19, 'drsteve@yopmail.com', 'drsteve', '$2y$10$YueTfUCUF6wkceFWO4DI.e0OeiBbNJRCaLIZPVqsIr7wncP34Pk3W', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 16:07:23', '2025-05-01 16:07:23', NULL);
INSERT INTO public.users VALUES (20, 'drwell@yopmail.com', 'drwell', '$2y$10$8At5VgjSR89AO9A/zAi3ZeaRm6SZFaozNs4GUVpKc3wiUli.9lI8S', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-05-01 16:08:53', '2025-05-01 16:08:53', NULL);


--
-- TOC entry 5087 (class 0 OID 0)
-- Dependencies: 250
-- Name: appointments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.appointments_id_seq', 33, true);


--
-- TOC entry 5088 (class 0 OID 0)
-- Dependencies: 227
-- Name: auth_activation_attempts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_activation_attempts_id_seq', 1, true);


--
-- TOC entry 5089 (class 0 OID 0)
-- Dependencies: 229
-- Name: auth_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_groups_id_seq', 3, true);


--
-- TOC entry 5090 (class 0 OID 0)
-- Dependencies: 221
-- Name: auth_logins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_logins_id_seq', 129, true);


--
-- TOC entry 5091 (class 0 OID 0)
-- Dependencies: 231
-- Name: auth_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_permissions_id_seq', 1, false);


--
-- TOC entry 5092 (class 0 OID 0)
-- Dependencies: 225
-- Name: auth_reset_attempts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_reset_attempts_id_seq', 1, true);


--
-- TOC entry 5093 (class 0 OID 0)
-- Dependencies: 223
-- Name: auth_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_tokens_id_seq', 1, false);


--
-- TOC entry 5094 (class 0 OID 0)
-- Dependencies: 252
-- Name: doctor_absents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctor_absents_id_seq', 1, true);


--
-- TOC entry 5095 (class 0 OID 0)
-- Dependencies: 236
-- Name: doctor_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctor_category_id_seq', 5, true);


--
-- TOC entry 5096 (class 0 OID 0)
-- Dependencies: 248
-- Name: doctor_schedules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctor_schedules_id_seq', 18, true);


--
-- TOC entry 5097 (class 0 OID 0)
-- Dependencies: 238
-- Name: doctors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctors_id_seq', 7, true);


--
-- TOC entry 5098 (class 0 OID 0)
-- Dependencies: 242
-- Name: educations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.educations_id_seq', 11, true);


--
-- TOC entry 5099 (class 0 OID 0)
-- Dependencies: 258
-- Name: equipment_rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.equipment_rooms_id_seq', 16, true);


--
-- TOC entry 5100 (class 0 OID 0)
-- Dependencies: 246
-- Name: equipments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.equipments_id_seq', 16, true);


--
-- TOC entry 5101 (class 0 OID 0)
-- Dependencies: 262
-- Name: histories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.histories_id_seq', 6, true);


--
-- TOC entry 5102 (class 0 OID 0)
-- Dependencies: 254
-- Name: inventories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.inventories_id_seq', 16, true);


--
-- TOC entry 5103 (class 0 OID 0)
-- Dependencies: 256
-- Name: inventory_rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.inventory_rooms_id_seq', 13, true);


--
-- TOC entry 5104 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 15, true);


--
-- TOC entry 5105 (class 0 OID 0)
-- Dependencies: 240
-- Name: patients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.patients_id_seq', 12, true);


--
-- TOC entry 5106 (class 0 OID 0)
-- Dependencies: 244
-- Name: rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rooms_id_seq', 3, true);


--
-- TOC entry 5107 (class 0 OID 0)
-- Dependencies: 260
-- Name: settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settings_id_seq', 2, true);


--
-- TOC entry 5108 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 20, true);


--
-- TOC entry 4829 (class 2606 OID 29967)
-- Name: appointments pk_appointments; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT pk_appointments PRIMARY KEY (id);


--
-- TOC entry 4806 (class 2606 OID 29809)
-- Name: auth_activation_attempts pk_auth_activation_attempts; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_activation_attempts
    ADD CONSTRAINT pk_auth_activation_attempts PRIMARY KEY (id);


--
-- TOC entry 4808 (class 2606 OID 29818)
-- Name: auth_groups pk_auth_groups; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups
    ADD CONSTRAINT pk_auth_groups PRIMARY KEY (id);


--
-- TOC entry 4799 (class 2606 OID 29774)
-- Name: auth_logins pk_auth_logins; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_logins
    ADD CONSTRAINT pk_auth_logins PRIMARY KEY (id);


--
-- TOC entry 4810 (class 2606 OID 29827)
-- Name: auth_permissions pk_auth_permissions; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_permissions
    ADD CONSTRAINT pk_auth_permissions PRIMARY KEY (id);


--
-- TOC entry 4804 (class 2606 OID 29800)
-- Name: auth_reset_attempts pk_auth_reset_attempts; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_reset_attempts
    ADD CONSTRAINT pk_auth_reset_attempts PRIMARY KEY (id);


--
-- TOC entry 4802 (class 2606 OID 29785)
-- Name: auth_tokens pk_auth_tokens; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_tokens
    ADD CONSTRAINT pk_auth_tokens PRIMARY KEY (id);


--
-- TOC entry 4831 (class 2606 OID 29994)
-- Name: doctor_absents pk_doctor_absents; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_absents
    ADD CONSTRAINT pk_doctor_absents PRIMARY KEY (id);


--
-- TOC entry 4815 (class 2606 OID 29884)
-- Name: doctor_category pk_doctor_category; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_category
    ADD CONSTRAINT pk_doctor_category PRIMARY KEY (id);


--
-- TOC entry 4827 (class 2606 OID 29950)
-- Name: doctor_schedules pk_doctor_schedules; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_schedules
    ADD CONSTRAINT pk_doctor_schedules PRIMARY KEY (id);


--
-- TOC entry 4817 (class 2606 OID 29893)
-- Name: doctors pk_doctors; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctors
    ADD CONSTRAINT pk_doctors PRIMARY KEY (id);


--
-- TOC entry 4821 (class 2606 OID 29924)
-- Name: educations pk_educations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.educations
    ADD CONSTRAINT pk_educations PRIMARY KEY (id);


--
-- TOC entry 4837 (class 2606 OID 30032)
-- Name: equipment_rooms pk_equipment_rooms; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipment_rooms
    ADD CONSTRAINT pk_equipment_rooms PRIMARY KEY (id);


--
-- TOC entry 4825 (class 2606 OID 29943)
-- Name: equipments pk_equipments; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipments
    ADD CONSTRAINT pk_equipments PRIMARY KEY (id);


--
-- TOC entry 4843 (class 2606 OID 30060)
-- Name: histories pk_histories; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.histories
    ADD CONSTRAINT pk_histories PRIMARY KEY (id);


--
-- TOC entry 4833 (class 2606 OID 30008)
-- Name: inventories pk_inventories; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventories
    ADD CONSTRAINT pk_inventories PRIMARY KEY (id);


--
-- TOC entry 4835 (class 2606 OID 30015)
-- Name: inventory_rooms pk_inventory_rooms; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventory_rooms
    ADD CONSTRAINT pk_inventory_rooms PRIMARY KEY (id);


--
-- TOC entry 4789 (class 2606 OID 29750)
-- Name: migrations pk_migrations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT pk_migrations PRIMARY KEY (id);


--
-- TOC entry 4819 (class 2606 OID 29912)
-- Name: patients pk_patients; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patients
    ADD CONSTRAINT pk_patients PRIMARY KEY (id);


--
-- TOC entry 4823 (class 2606 OID 29936)
-- Name: rooms pk_rooms; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT pk_rooms PRIMARY KEY (id);


--
-- TOC entry 4839 (class 2606 OID 30051)
-- Name: settings pk_settings; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT pk_settings PRIMARY KEY (id);


--
-- TOC entry 4791 (class 2606 OID 29761)
-- Name: users pk_users; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_users PRIMARY KEY (id);


--
-- TOC entry 4841 (class 2606 OID 30053)
-- Name: settings settings_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_key_key UNIQUE (key);


--
-- TOC entry 4793 (class 2606 OID 29763)
-- Name: users users_email; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email UNIQUE (email);


--
-- TOC entry 4795 (class 2606 OID 29765)
-- Name: users users_username; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username UNIQUE (username);


--
-- TOC entry 4811 (class 1259 OID 29843)
-- Name: auth_groups_permissions_group_id_permission_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_groups_permissions_group_id_permission_id ON public.auth_groups_permissions USING btree (group_id, permission_id);


--
-- TOC entry 4812 (class 1259 OID 29859)
-- Name: auth_groups_users_group_id_user_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_groups_users_group_id_user_id ON public.auth_groups_users USING btree (group_id, user_id);


--
-- TOC entry 4796 (class 1259 OID 29775)
-- Name: auth_logins_email; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_logins_email ON public.auth_logins USING btree (email);


--
-- TOC entry 4797 (class 1259 OID 29776)
-- Name: auth_logins_user_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_logins_user_id ON public.auth_logins USING btree (user_id);


--
-- TOC entry 4800 (class 1259 OID 29791)
-- Name: auth_tokens_selector; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_tokens_selector ON public.auth_tokens USING btree (selector);


--
-- TOC entry 4813 (class 1259 OID 29875)
-- Name: auth_users_permissions_user_id_permission_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX auth_users_permissions_user_id_permission_id ON public.auth_users_permissions USING btree (user_id, permission_id);


--
-- TOC entry 4857 (class 2606 OID 29978)
-- Name: appointments appointments_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.doctors(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4858 (class 2606 OID 29973)
-- Name: appointments appointments_doctor_schedule_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_doctor_schedule_id_foreign FOREIGN KEY (doctor_schedule_id) REFERENCES public.doctor_schedules(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4859 (class 2606 OID 29968)
-- Name: appointments appointments_patient_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_patient_id_foreign FOREIGN KEY (patient_id) REFERENCES public.patients(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4860 (class 2606 OID 29983)
-- Name: appointments appointments_room_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4845 (class 2606 OID 29833)
-- Name: auth_groups_permissions auth_groups_permissions_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups_permissions
    ADD CONSTRAINT auth_groups_permissions_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.auth_groups(id) ON DELETE CASCADE;


--
-- TOC entry 4846 (class 2606 OID 29838)
-- Name: auth_groups_permissions auth_groups_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups_permissions
    ADD CONSTRAINT auth_groups_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.auth_permissions(id) ON DELETE CASCADE;


--
-- TOC entry 4847 (class 2606 OID 29849)
-- Name: auth_groups_users auth_groups_users_group_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups_users
    ADD CONSTRAINT auth_groups_users_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.auth_groups(id) ON DELETE CASCADE;


--
-- TOC entry 4848 (class 2606 OID 29854)
-- Name: auth_groups_users auth_groups_users_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_groups_users
    ADD CONSTRAINT auth_groups_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4844 (class 2606 OID 29786)
-- Name: auth_tokens auth_tokens_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_tokens
    ADD CONSTRAINT auth_tokens_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4849 (class 2606 OID 29870)
-- Name: auth_users_permissions auth_users_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_users_permissions
    ADD CONSTRAINT auth_users_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.auth_permissions(id) ON DELETE CASCADE;


--
-- TOC entry 4850 (class 2606 OID 29865)
-- Name: auth_users_permissions auth_users_permissions_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_users_permissions
    ADD CONSTRAINT auth_users_permissions_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4861 (class 2606 OID 29995)
-- Name: doctor_absents doctor_absents_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_absents
    ADD CONSTRAINT doctor_absents_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.doctors(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4855 (class 2606 OID 29951)
-- Name: doctor_schedules doctor_schedules_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_schedules
    ADD CONSTRAINT doctor_schedules_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.doctors(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4856 (class 2606 OID 29956)
-- Name: doctor_schedules doctor_schedules_room_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_schedules
    ADD CONSTRAINT doctor_schedules_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4851 (class 2606 OID 29894)
-- Name: doctors doctors_doctor_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctors
    ADD CONSTRAINT doctors_doctor_category_id_foreign FOREIGN KEY (doctor_category_id) REFERENCES public.doctor_category(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4852 (class 2606 OID 29899)
-- Name: doctors doctors_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctors
    ADD CONSTRAINT doctors_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4854 (class 2606 OID 29925)
-- Name: educations educations_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.educations
    ADD CONSTRAINT educations_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.doctors(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4864 (class 2606 OID 30038)
-- Name: equipment_rooms equipment_rooms_equipment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipment_rooms
    ADD CONSTRAINT equipment_rooms_equipment_id_foreign FOREIGN KEY (equipment_id) REFERENCES public.equipments(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4865 (class 2606 OID 30033)
-- Name: equipment_rooms equipment_rooms_room_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipment_rooms
    ADD CONSTRAINT equipment_rooms_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4866 (class 2606 OID 30061)
-- Name: histories histories_appointment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.histories
    ADD CONSTRAINT histories_appointment_id_foreign FOREIGN KEY (appointment_id) REFERENCES public.appointments(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4867 (class 2606 OID 30066)
-- Name: histories histories_patient_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.histories
    ADD CONSTRAINT histories_patient_id_foreign FOREIGN KEY (patient_id) REFERENCES public.patients(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4862 (class 2606 OID 30021)
-- Name: inventory_rooms inventory_rooms_inventory_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventory_rooms
    ADD CONSTRAINT inventory_rooms_inventory_id_foreign FOREIGN KEY (inventory_id) REFERENCES public.inventories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4863 (class 2606 OID 30016)
-- Name: inventory_rooms inventory_rooms_room_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inventory_rooms
    ADD CONSTRAINT inventory_rooms_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4853 (class 2606 OID 29913)
-- Name: patients patients_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patients
    ADD CONSTRAINT patients_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE SET NULL;


-- Completed on 2025-05-15 06:29:46

--
-- PostgreSQL database dump complete
--

