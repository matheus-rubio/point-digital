--
-- PostgreSQL database dump
--

-- Dumped from database version 12.8 (Ubuntu 12.8-0ubuntu0.20.04.1)
-- Dumped by pg_dump version 12.8 (Ubuntu 12.8-0ubuntu0.20.04.1)

-- Started on 2021-08-31 20:39:09 -03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 7 (class 2615 OID 16856)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 3024 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 202 (class 1259 OID 16857)
-- Name: tb_administradores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tb_administradores (
    id integer NOT NULL,
    nome character varying NOT NULL,
    login character varying NOT NULL,
    senha character varying NOT NULL
);


ALTER TABLE public.tb_administradores OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 16863)
-- Name: tb_administradores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tb_administradores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_administradores_id_seq OWNER TO postgres;

--
-- TOC entry 3025 (class 0 OID 0)
-- Dependencies: 203
-- Name: tb_administradores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tb_administradores_id_seq OWNED BY public.tb_administradores.id;


--
-- TOC entry 204 (class 1259 OID 16865)
-- Name: tb_clientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tb_clientes (
    id integer NOT NULL,
    nome character varying NOT NULL,
    login character varying NOT NULL,
    senha character varying NOT NULL,
    telefone character varying(100) NOT NULL
);


ALTER TABLE public.tb_clientes OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 16871)
-- Name: tb_clientes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tb_clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_clientes_id_seq OWNER TO postgres;

--
-- TOC entry 3026 (class 0 OID 0)
-- Dependencies: 205
-- Name: tb_clientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tb_clientes_id_seq OWNED BY public.tb_clientes.id;


--
-- TOC entry 206 (class 1259 OID 16873)
-- Name: tb_ordens_de_servico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tb_ordens_de_servico (
    id integer NOT NULL,
    id_cliente integer NOT NULL,
    data_inicio timestamp without time zone DEFAULT now() NOT NULL,
    data_finalizacao timestamp without time zone,
    modelo_aparelho character varying,
    status_servico character varying NOT NULL,
    problema_identificado character varying,
    orcamento_inicial real NOT NULL,
    valor_final real
);


ALTER TABLE public.tb_ordens_de_servico OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 16880)
-- Name: tb_ordens_de_servico_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tb_ordens_de_servico_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_ordens_de_servico_id_seq OWNER TO postgres;

--
-- TOC entry 3027 (class 0 OID 0)
-- Dependencies: 207
-- Name: tb_ordens_de_servico_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tb_ordens_de_servico_id_seq OWNED BY public.tb_ordens_de_servico.id;


--
-- TOC entry 208 (class 1259 OID 16882)
-- Name: tb_pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tb_pedidos (
    id integer NOT NULL,
    id_cliente integer NOT NULL,
    id_produto integer NOT NULL,
    data_pedido timestamp without time zone DEFAULT now() NOT NULL,
    valor_total real NOT NULL,
    status character varying NOT NULL,
    codigo_de_barras text NOT NULL
);


ALTER TABLE public.tb_pedidos OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16889)
-- Name: tb_pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tb_pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_pedidos_id_seq OWNER TO postgres;

--
-- TOC entry 3028 (class 0 OID 0)
-- Dependencies: 209
-- Name: tb_pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tb_pedidos_id_seq OWNED BY public.tb_pedidos.id;


--
-- TOC entry 210 (class 1259 OID 16891)
-- Name: tb_produtos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tb_produtos (
    id integer NOT NULL,
    nome character varying NOT NULL,
    marca character varying,
    preco real NOT NULL,
    qnt_estoque integer NOT NULL,
    descricao text
);


ALTER TABLE public.tb_produtos OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 16897)
-- Name: tb_produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tb_produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_produtos_id_seq OWNER TO postgres;

--
-- TOC entry 3029 (class 0 OID 0)
-- Dependencies: 211
-- Name: tb_produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tb_produtos_id_seq OWNED BY public.tb_produtos.id;


--
-- TOC entry 2863 (class 2604 OID 16899)
-- Name: tb_administradores id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_administradores ALTER COLUMN id SET DEFAULT nextval('public.tb_administradores_id_seq'::regclass);


--
-- TOC entry 2864 (class 2604 OID 16900)
-- Name: tb_clientes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_clientes ALTER COLUMN id SET DEFAULT nextval('public.tb_clientes_id_seq'::regclass);


--
-- TOC entry 2866 (class 2604 OID 16901)
-- Name: tb_ordens_de_servico id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_ordens_de_servico ALTER COLUMN id SET DEFAULT nextval('public.tb_ordens_de_servico_id_seq'::regclass);


--
-- TOC entry 2868 (class 2604 OID 16902)
-- Name: tb_pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_pedidos ALTER COLUMN id SET DEFAULT nextval('public.tb_pedidos_id_seq'::regclass);


--
-- TOC entry 2869 (class 2604 OID 16903)
-- Name: tb_produtos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_produtos ALTER COLUMN id SET DEFAULT nextval('public.tb_produtos_id_seq'::regclass);


--
-- TOC entry 3009 (class 0 OID 16857)
-- Dependencies: 202
-- Data for Name: tb_administradores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tb_administradores (id, nome, login, senha) FROM stdin;
1	Admin	admin	21232f297a57a5a743894a0e4a801fc3
\.


--
-- TOC entry 3011 (class 0 OID 16865)
-- Dependencies: 204
-- Data for Name: tb_clientes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tb_clientes (id, nome, login, senha, telefone) FROM stdin;
1	Teste	teste@teste.com	21232f297a57a5a743894a0e4a801fc3	32999401604
3	Matheus Rubio	matheus@teste.com	4350a4e485da6f7af45b21c1b4b5f917	32999401604
15	Matheus Rubio	admin@teste.com	d1c07866d71dc3a09b3b692d0a2086b4	32999401604
\.


--
-- TOC entry 3013 (class 0 OID 16873)
-- Dependencies: 206
-- Data for Name: tb_ordens_de_servico; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tb_ordens_de_servico (id, id_cliente, data_inicio, data_finalizacao, modelo_aparelho, status_servico, problema_identificado, orcamento_inicial, valor_final) FROM stdin;
1	1	2021-08-28 11:48:15.97086	2021-08-30 12:08:00	LG	Finalizado	Tela Danificada	700	700
2	1	2021-08-30 01:24:50.596312	\N	LG	Pendente	USB Com defeito	800	\N
\.


--
-- TOC entry 3015 (class 0 OID 16882)
-- Dependencies: 208
-- Data for Name: tb_pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tb_pedidos (id, id_cliente, id_produto, data_pedido, valor_total, status, codigo_de_barras) FROM stdin;
1	1	1	2021-08-28 11:50:00.956796	700	Pendente	39993000000000014993739040736027668911000002
18	3	1	2021-08-29 23:23:30.877808	755	Pendente	39993000000000014993739040736027668911000002
19	3	61	2021-08-30 01:50:46.324993	1000	Pendente	39993000000000014993739040736027668911000002
\.


--
-- TOC entry 3017 (class 0 OID 16891)
-- Dependencies: 210
-- Data for Name: tb_produtos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tb_produtos (id, nome, marca, preco, qnt_estoque, descricao) FROM stdin;
56	J7 PRIME	Samsung	849.99	10	Processador Octacore, Android 6.0, 16 GB de Armazenamento
1	LG K10	Samsung	849.99	10	Processador Octacore, Android 6.0, 16 GB de Armazenamento
61	Redmi Note 8	Xiaomi	1000	26	\N
\.


--
-- TOC entry 3030 (class 0 OID 0)
-- Dependencies: 203
-- Name: tb_administradores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tb_administradores_id_seq', 1, true);


--
-- TOC entry 3031 (class 0 OID 0)
-- Dependencies: 205
-- Name: tb_clientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tb_clientes_id_seq', 15, true);


--
-- TOC entry 3032 (class 0 OID 0)
-- Dependencies: 207
-- Name: tb_ordens_de_servico_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tb_ordens_de_servico_id_seq', 2, true);


--
-- TOC entry 3033 (class 0 OID 0)
-- Dependencies: 209
-- Name: tb_pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tb_pedidos_id_seq', 19, true);


--
-- TOC entry 3034 (class 0 OID 0)
-- Dependencies: 211
-- Name: tb_produtos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tb_produtos_id_seq', 61, true);


--
-- TOC entry 2871 (class 2606 OID 16905)
-- Name: tb_administradores tb_administradores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_administradores
    ADD CONSTRAINT tb_administradores_pkey PRIMARY KEY (id);


--
-- TOC entry 2873 (class 2606 OID 16907)
-- Name: tb_clientes tb_clientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_clientes
    ADD CONSTRAINT tb_clientes_pkey PRIMARY KEY (id);


--
-- TOC entry 2875 (class 2606 OID 16909)
-- Name: tb_ordens_de_servico tb_ordens_de_servico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_ordens_de_servico
    ADD CONSTRAINT tb_ordens_de_servico_pkey PRIMARY KEY (id);


--
-- TOC entry 2877 (class 2606 OID 16911)
-- Name: tb_pedidos tb_pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_pedidos
    ADD CONSTRAINT tb_pedidos_pkey PRIMARY KEY (id);


--
-- TOC entry 2879 (class 2606 OID 16913)
-- Name: tb_produtos tb_produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_produtos
    ADD CONSTRAINT tb_produtos_pkey PRIMARY KEY (id);


--
-- TOC entry 2880 (class 2606 OID 16914)
-- Name: tb_ordens_de_servico tb_ordens_de_servico_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_ordens_de_servico
    ADD CONSTRAINT tb_ordens_de_servico_fk FOREIGN KEY (id_cliente) REFERENCES public.tb_clientes(id);


--
-- TOC entry 2881 (class 2606 OID 16919)
-- Name: tb_pedidos tb_pedidos_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_pedidos
    ADD CONSTRAINT tb_pedidos_fk FOREIGN KEY (id_cliente) REFERENCES public.tb_clientes(id);


--
-- TOC entry 2882 (class 2606 OID 16924)
-- Name: tb_pedidos tb_pedidos_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tb_pedidos
    ADD CONSTRAINT tb_pedidos_fk_1 FOREIGN KEY (id_produto) REFERENCES public.tb_produtos(id);


-- Completed on 2021-08-31 20:39:09 -03

--
-- PostgreSQL database dump complete
--

