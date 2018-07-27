CREATE TABLE public.personas_tipo
(
  id serial NOT NULL,
  id_persona integer NOT NULL,
  id_tipo_persona integer NOT NULL,
  CONSTRAINT pk_personas_tipos PRIMARY KEY (id),
  CONSTRAINT fk_personas_tipos__personas FOREIGN KEY (id_persona)
      REFERENCES public.personas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_personas_tipos__tipo_persona FOREIGN KEY (id_tipo_persona)
      REFERENCES public.tipo_persona (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT uk_personas_tipos UNIQUE (id_persona, id_tipo_persona)
)
WITH (
  OIDS=FALSE
);

CREATE OR REPLACE FUNCTION get_tipo_persona(_id_persona integer)
RETURNS setof int AS
$BODY$
  SELECT id_tipo_persona FROM personas_tipo WHERE id_persona=_id_persona;
$BODY$
LANGUAGE SQL;

CREATE OR REPLACE FUNCTION es_alumno(_id_persona integer)
RETURNS boolean AS
$BODY$
  SELECT exists (SELECT 1 FROM personas_tipo WHERE id_persona=_id_persona and id_tipo_persona=1);
$BODY$
LANGUAGE SQL;

CREATE OR REPLACE FUNCTION es_profesor(_id_persona integer)
RETURNS boolean AS
$BODY$
  SELECT exists (SELECT 1 FROM personas_tipo WHERE id_persona=_id_persona and id_tipo_persona=2);
$BODY$
LANGUAGE SQL;

CREATE OR REPLACE FUNCTION get_usuario(_id_persona integer)
RETURNS character varying(60) AS
$BODY$
  SELECT dni::character varying(60) FROM personas WHERE id=_id_persona;
$BODY$
LANGUAGE SQL;

CREATE OR REPLACE FUNCTION get_id_persona(_usuario text)
RETURNS integer AS
$BODY$
  SELECT id FROM personas WHERE trim(_usuario)=trim(dni::character varying(60));
$BODY$
LANGUAGE SQL;

/* Cursos que dicta un profesor */
CREATE OR REPLACE FUNCTION get_cursos_profesor(_id_profesor integer)
RETURNS setof int AS
$BODY$
  SELECT id_curso FROM cursadas WHERE id IN (SELECT id_cursada FROM cursadas_profesores WHERE id_profesor =_id_profesor);
$BODY$
LANGUAGE SQL;

/* Cursadas que dicta un profesor */
CREATE OR REPLACE FUNCTION get_cursadas_profesor(_id_profesor integer)
RETURNS setof int AS
$BODY$
  SELECT id_cursada FROM cursadas_profesores WHERE id_profesor =_id_profesor;
$BODY$
LANGUAGE SQL;

/* IMPORTACION DE CURSOS */
ALTER TABLE public.cursos_modulos DROP CONSTRAINT uk_cursos_modulos;
INSERT INTO public.cursos VALUES (1, 'PROFESORADO YOGA', 'PROFESORADO YOGA', 12, 80.00, 10, NULL, 12, true, 100, 100, true, NULL, 1, 80, 100);
INSERT INTO public.cursos VALUES (2, 'PROFESORADO SUPERIOR DE YOGATERAPIA', 'PROFESORADO SUPERIOR DE YOGATERAPIA', 12, 80.00, 10, NULL, 12, true, 100, 100, true, NULL, 2, 80, 100);
INSERT INTO public.cursos VALUES (3, 'PROFESORADO SUPERIOR DE YOGA', 'PROFESORADO SUPERIOR DE YOGA', 12, 80.00, 10, NULL, 12, true, 100, 100, true, NULL, 3, 80, 100);
INSERT INTO public.cursos VALUES (4, 'PROFESORADO SUPERIOR EN YOGA DINÁMICO', 'PROFESORADO SUPERIOR EN YOGA DINÁMICO', 12, 80.00, 10, NULL, 12, true, 100, 100, true, NULL, 4, 80, 100);
INSERT INTO public.cursos VALUES (5, 'FORMACIÓN EN SUDDHA RAJA YOGA', 'FORMACIÓN EN SUDDHA RAJA YOGA', 6, 100.00, 10, NULL, 6, false, 0, 100, true, NULL, 5, 0, 100);
INSERT INTO public.cursos VALUES (6, 'YOGATERAPIA INCLUSIVA Y EDUCACIÓN PARA NIÑOS', 'YOGATERAPIA INCLUSIVA Y EDUCACIÓN PARA NIÑOS', 6, 80.00, 10, NULL, 6, true, NULL, NULL, true, NULL, 6, NULL, NULL);
INSERT INTO public.cursos VALUES (7, 'ESPECIALIZACIÓN EN YOGA PARA NIÑOS', 'ESPECIALIZACIÓN EN YOGA PARA NIÑOS', 6, 80.00, 10, NULL, 6, true, NULL, NULL, true, NULL, 7, NULL, NULL);
INSERT INTO public.cursos VALUES (8, 'ESPECIALIZACIÓN EN MATRO YOGA', 'ESPECIALIZACIÓN EN MATRO YOGA', 6, 80.00, 10, NULL, 6, true, NULL, NULL, true, NULL, 8, NULL, NULL);
INSERT INTO public.cursos VALUES (9, 'FORMACIÓN EN APLICACIÓN DE CUENCOS TIBETANOS', 'FORMACIÓN EN APLICACIÓN DE CUENCOS TIBETANOS', 3, 80.00, 10, NULL, 6, true, NULL, NULL, true, NULL, 9, NULL, NULL);
INSERT INTO public.cursos VALUES (10, 'MASOTERAPIA AYURVEDICA', 'MASOTERAPIA AYURVEDICA', 8, 80.00, 10, NULL, 8, true, NULL, NULL, true, NULL, 10, NULL, NULL);
INSERT INTO public.cursos VALUES (11, 'CONSUTOR EN AYURVEDA', 'CONSUTOR EN AYURVEDA', 24, 100.00, 10, NULL, 10, true, NULL, NULL, true, NULL, 11, NULL, NULL);
INSERT INTO public.cursos VALUES (12, 'ESPECIALIZACIÓN EN PRANIC BALANCE YOGA', 'ESPECIALIZACIÓN EN PRANIC BALANCE YOGA', 6, 80.00, 10, NULL, 6, false, NULL, NULL, true, NULL, 12, NULL, NULL);
INSERT INTO public.cursos VALUES (13, 'INSTRUCTORADO DE TAI CHI', 'INSTRUCTORADO DE TAI CHI', 10, 100.00, 10, NULL, 10, true, NULL, NULL, true, NULL, 13, NULL, NULL);
INSERT INTO public.cursos VALUES (14, 'ESPECIALIZACIÓN EN YOGA PARA ADULTOS MAYORES', 'ESPECIALIZACIÓN EN YOGA PARA ADULTOS MAYORES', 1, 80.00, 10, NULL, 1, true, NULL, NULL, true, NULL, 14, NULL, NULL);
INSERT INTO public.cursos VALUES (15, 'ESPECIALIZACIÓN EN SWARA YOGA', 'ESPECIALIZACIÓN EN SWARA YOGA', 6, 80.00, 10, NULL, 6, false, NULL, NULL, true, NULL, 15, NULL, NULL);
INSERT INTO public.cursos VALUES (16, 'FORMACION', 'FORMACION', 24, 80.00, 10, NULL, 24, true, NULL, NULL, true, NULL, 16, NULL, NULL);
INSERT INTO public.cursos VALUES (17, 'ESPECIALIZACION PARA PROFESORES DE YOGA', 'ESPECIALIZACION PARA PROFESORES DE YOGA', 3, 80.00, 10, NULL, 3, true, NULL, NULL, true, NULL, 17, NULL, NULL);


--
-- Name: cursos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cursos_id_seq', 2, true);


--
-- Data for Name: cursos_modulos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.cursos_modulos VALUES (429, 'Modulo 1', 4, 'Modulo 1 - Abril', 'Modulo 1', 1, 1, 1);
INSERT INTO public.cursos_modulos VALUES (430, 'Modulo 2', 5, 'Modulo 2 - Mayo', 'Modulo 2', 1, 2, 2);
INSERT INTO public.cursos_modulos VALUES (431, 'Modulo 3', 6, 'Modulo 3 - Junio', 'Modulo 3', 1, 3, 3);
INSERT INTO public.cursos_modulos VALUES (432, 'Modulo 4', 7, 'Modulo 4 - Julio', 'Modulo 4', 1, 4, 4);
INSERT INTO public.cursos_modulos VALUES (433, 'Modulo 5', 8, 'Modulo 5 - Agosto', 'Modulo 5', 1, 5, 5);
INSERT INTO public.cursos_modulos VALUES (434, 'Modulo 6', 9, 'Modulo 6 - Septiembre', 'Modulo 6', 1, 6, 6);
INSERT INTO public.cursos_modulos VALUES (435, 'Modulo 7', 10, 'Modulo 7 - Octubre', 'Modulo 7', 1, 7, 7);
INSERT INTO public.cursos_modulos VALUES (436, 'Modulo 8', 11, 'Modulo 8 - Noviembre', 'Modulo 8', 1, 8, 8);
INSERT INTO public.cursos_modulos VALUES (437, 'Modulo 9', 12, 'Modulo 9 - Diciembre', 'Modulo 9', 1, 9, 9);
INSERT INTO public.cursos_modulos VALUES (438, 'Modulo 10', 1, 'Modulo 10 - Enero', 'Modulo 10', 1, 10, 10);
INSERT INTO public.cursos_modulos VALUES (439, 'Modulo 11', 2, 'Modulo 11 - Febrero', 'Modulo 11', 1, 11, 11);
INSERT INTO public.cursos_modulos VALUES (440, 'Modulo 12', 3, 'Modulo 12 - Marzo', 'Modulo 12', 1, 12, 12);
INSERT INTO public.cursos_modulos VALUES (441, 'Modulo 1', 3, 'Modulo 3 - Marzo', 'Modulo 1', 2, 1, 1);
INSERT INTO public.cursos_modulos VALUES (442, 'Modulo 2', 4, 'Modulo 4 - Abril', 'Modulo 2', 2, 2, 2);
INSERT INTO public.cursos_modulos VALUES (443, 'Modulo 3', 5, 'Modulo 5 - Mayo', 'Modulo 3', 2, 3, 3);
INSERT INTO public.cursos_modulos VALUES (444, 'Modulo 4', 6, 'Modulo 6 - Junio', 'Modulo 4', 2, 4, 4);
INSERT INTO public.cursos_modulos VALUES (445, 'Modulo 5', 7, 'Modulo 7 - Julio', 'Modulo 5', 2, 5, 5);
INSERT INTO public.cursos_modulos VALUES (446, 'Modulo 6', 8, 'Modulo 8 - Agosto', 'Modulo 6', 2, 6, 6);
INSERT INTO public.cursos_modulos VALUES (447, 'Modulo 7', 9, 'Modulo 9 - Septiembre', 'Modulo 7', 2, 7, 7);
INSERT INTO public.cursos_modulos VALUES (448, 'Modulo 8', 10, 'Modulo 10 - Octubre', 'Modulo 8', 2, 8, 8);
INSERT INTO public.cursos_modulos VALUES (449, 'Modulo 9', 11, 'Modulo 11 - Noviembre', 'Modulo 9', 2, 9, 9);
INSERT INTO public.cursos_modulos VALUES (450, 'Modulo 10', 12, 'Modulo 12 - Diciembre', 'Modulo 10', 2, 10, 10);
INSERT INTO public.cursos_modulos VALUES (451, 'Modulo 11', 1, 'Modulo 1 - Enero', 'Modulo 11', 2, 11, 11);
INSERT INTO public.cursos_modulos VALUES (452, 'Modulo 12', 2, 'Modulo 2 - Febrero', 'Modulo 12', 2, 12, 12);
INSERT INTO public.cursos_modulos VALUES (453, 'Modulo 1', 1, 'Modulo 1 - Febrero', 'Modulo 1', 4, 1, 1);
INSERT INTO public.cursos_modulos VALUES (454, 'Modulo 2', 2, 'Modulo 2 - Marzo', 'Modulo 2', 4, 2, 2);
INSERT INTO public.cursos_modulos VALUES (455, 'Modulo 3', 3, 'Modulo 3 - Abril', 'Modulo 3', 4, 3, 3);
INSERT INTO public.cursos_modulos VALUES (456, 'Modulo 4', 4, 'Modulo 4 - Mayo', 'Modulo 4', 4, 4, 4);
INSERT INTO public.cursos_modulos VALUES (457, 'Modulo 5', 5, 'Modulo 5 - Junio', 'Modulo 5', 4, 5, 5);
INSERT INTO public.cursos_modulos VALUES (458, 'Modulo 6', 6, 'Modulo 6 - Julio', 'Modulo 6', 4, 6, 6);
INSERT INTO public.cursos_modulos VALUES (459, 'Modulo 7', 7, 'Modulo 7 - Agosto', 'Modulo 7', 4, 7, 7);
INSERT INTO public.cursos_modulos VALUES (460, 'Modulo 8', 8, 'Modulo 8 - Septiembre', 'Modulo 8', 4, 8, 8);
INSERT INTO public.cursos_modulos VALUES (461, 'Modulo 9', 9, 'Modulo 9 - Octubre', 'Modulo 9', 4, 9, 9);
INSERT INTO public.cursos_modulos VALUES (462, 'Modulo 10', 10, 'Modulo 10 - Noviembre', 'Modulo 10', 4, 10, 10);
INSERT INTO public.cursos_modulos VALUES (463, 'Modulo 11', 11, 'Modulo 11 - Diciembre', 'Modulo 11', 4, 11, 11);
INSERT INTO public.cursos_modulos VALUES (464, 'Modulo 12', 12, 'Modulo 12 - Enero', 'Modulo 12', 4, 12, 12);
INSERT INTO public.cursos_modulos VALUES (465, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 5, 1, 1);
INSERT INTO public.cursos_modulos VALUES (466, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 5, 2, 2);
INSERT INTO public.cursos_modulos VALUES (467, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 5, 3, 3);
INSERT INTO public.cursos_modulos VALUES (468, 'Modulo 4', 4, 'Modulo 4', 'Modulo 4', 5, 4, 4);
INSERT INTO public.cursos_modulos VALUES (469, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 5, 5, 5);
INSERT INTO public.cursos_modulos VALUES (470, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 5, 6, 6);
INSERT INTO public.cursos_modulos VALUES (471, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 6, 1, 1);
INSERT INTO public.cursos_modulos VALUES (472, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 6, 2, 2);
INSERT INTO public.cursos_modulos VALUES (473, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 6, 3, 3);
INSERT INTO public.cursos_modulos VALUES (474, 'Modulo 4', 4, 'Modulo 4', 'Modulo 4', 6, 4, 4);
INSERT INTO public.cursos_modulos VALUES (475, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 6, 5, 5);
INSERT INTO public.cursos_modulos VALUES (476, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 6, 6, 6);
INSERT INTO public.cursos_modulos VALUES (477, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 7, 1, 1);
INSERT INTO public.cursos_modulos VALUES (478, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 7, 2, 2);
INSERT INTO public.cursos_modulos VALUES (479, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 7, 3, 3);
INSERT INTO public.cursos_modulos VALUES (480, 'Modulo 4', 4, 'Modulo 4', 'Modulo 4', 7, 4, 4);
INSERT INTO public.cursos_modulos VALUES (481, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 7, 5, 5);
INSERT INTO public.cursos_modulos VALUES (482, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 7, 6, 6);
INSERT INTO public.cursos_modulos VALUES (483, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 8, 1, 1);
INSERT INTO public.cursos_modulos VALUES (484, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 8, 2, 2);
INSERT INTO public.cursos_modulos VALUES (485, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 8, 3, 3);
INSERT INTO public.cursos_modulos VALUES (486, 'Modulo 4', 4, 'Modulo 4', 'Modulo 4', 8, 4, 4);
INSERT INTO public.cursos_modulos VALUES (487, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 8, 5, 5);
INSERT INTO public.cursos_modulos VALUES (488, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 8, 6, 6);
INSERT INTO public.cursos_modulos VALUES (489, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 9, 1, 1);
INSERT INTO public.cursos_modulos VALUES (490, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 9, 2, 2);
INSERT INTO public.cursos_modulos VALUES (491, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 9, 3, 3);
INSERT INTO public.cursos_modulos VALUES (492, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 10, 1, 1);
INSERT INTO public.cursos_modulos VALUES (493, 'Modulo 2', 2, 'Modulo 2 ', 'Modulo 2', 10, 2, 2);
INSERT INTO public.cursos_modulos VALUES (494, 'Modulo 3', 3, 'Modulo 3 ', 'Modulo 3', 10, 3, 3);
INSERT INTO public.cursos_modulos VALUES (495, 'Modulo 4', 4, 'Modulo 4 ', 'Modulo 4', 10, 4, 4);
INSERT INTO public.cursos_modulos VALUES (496, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 10, 5, 5);
INSERT INTO public.cursos_modulos VALUES (497, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 10, 6, 6);
INSERT INTO public.cursos_modulos VALUES (498, 'Modulo 7', 7, 'Modulo 7', 'Modulo 7', 10, 7, 7);
INSERT INTO public.cursos_modulos VALUES (499, 'Modulo 8', 8, 'Modulo 8', 'Modulo 8', 10, 8, 8);
INSERT INTO public.cursos_modulos VALUES (500, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 11, 1, 1);
INSERT INTO public.cursos_modulos VALUES (501, 'Modulo 2', 2, 'Modulo 2', 'Modulo 2', 11, 2, 2);
INSERT INTO public.cursos_modulos VALUES (502, 'Modulo 3', 3, 'Modulo 3', 'Modulo 3', 11, 3, 3);
INSERT INTO public.cursos_modulos VALUES (503, 'Modulo 4', 4, 'Modulo 4 ', 'Modulo 4', 11, 4, 4);
INSERT INTO public.cursos_modulos VALUES (504, 'Modulo 5', 5, 'Modulo 5 ', 'Modulo 5', 11, 5, 5);
INSERT INTO public.cursos_modulos VALUES (505, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 11, 6, 6);
INSERT INTO public.cursos_modulos VALUES (506, 'Modulo 7', 7, 'Modulo 7 ', 'Modulo 7', 11, 7, 7);
INSERT INTO public.cursos_modulos VALUES (507, 'Modulo 8', 8, 'Modulo 8 ', 'Modulo 8', 11, 8, 8);
INSERT INTO public.cursos_modulos VALUES (508, 'Modulo 9', 9, 'Modulo 9 ', 'Modulo 9', 11, 9, 9);
INSERT INTO public.cursos_modulos VALUES (509, 'Modulo 10', 10, 'Modulo 10 ', 'Modulo 10', 11, 10, 10);
INSERT INTO public.cursos_modulos VALUES (510, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 12, 1, 1);
INSERT INTO public.cursos_modulos VALUES (511, 'Modulo 2', 2, 'Modulo 2 ', 'Modulo 2', 12, 2, 2);
INSERT INTO public.cursos_modulos VALUES (512, 'Modulo 3', 3, 'Modulo 3 ', 'Modulo 3', 12, 3, 3);
INSERT INTO public.cursos_modulos VALUES (513, 'Modulo 4', 4, 'Modulo 4 ', 'Modulo 4', 12, 4, 4);
INSERT INTO public.cursos_modulos VALUES (514, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 13, 1, 1);
INSERT INTO public.cursos_modulos VALUES (515, 'Modulo 2', 2, 'Modulo 2 ', 'Modulo 2', 13, 2, 2);
INSERT INTO public.cursos_modulos VALUES (516, 'Modulo 3', 3, 'Modulo 3 ', 'Modulo 3', 13, 3, 3);
INSERT INTO public.cursos_modulos VALUES (517, 'Modulo 4', 4, 'Modulo 4 ', 'Modulo 4', 13, 4, 4);
INSERT INTO public.cursos_modulos VALUES (518, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 13, 5, 5);
INSERT INTO public.cursos_modulos VALUES (519, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 13, 6, 6);
INSERT INTO public.cursos_modulos VALUES (520, 'Modulo 7', 7, 'Modulo 7', 'Modulo 7', 13, 7, 7);
INSERT INTO public.cursos_modulos VALUES (521, 'Modulo 8', 8, 'Modulo 8', 'Modulo 8', 13, 8, 8);
INSERT INTO public.cursos_modulos VALUES (522, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 14, 1, 1);
INSERT INTO public.cursos_modulos VALUES (523, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 15, 1, 1);
INSERT INTO public.cursos_modulos VALUES (524, 'Modulo 2', 2, 'Modulo 2 ', 'Modulo 2', 15, 2, 2);
INSERT INTO public.cursos_modulos VALUES (525, 'Modulo 3', 3, 'Modulo 3 ', 'Modulo 3', 15, 3, 3);
INSERT INTO public.cursos_modulos VALUES (526, 'Modulo 4', 4, 'Modulo 4 ', 'Modulo 4', 15, 4, 4);
INSERT INTO public.cursos_modulos VALUES (527, 'Modulo 5', 5, 'Modulo 5', 'Modulo 5', 15, 5, 5);
INSERT INTO public.cursos_modulos VALUES (528, 'Modulo 6', 6, 'Modulo 6', 'Modulo 6', 15, 6, 6);
INSERT INTO public.cursos_modulos VALUES (529, 'Modulo 1', 3, 'Modulo 1', 'Modulo 1', 16, 1, 1);
INSERT INTO public.cursos_modulos VALUES (530, 'Modulo 2', 4, 'Modulo 2', 'Modulo 2', 16, 2, 2);
INSERT INTO public.cursos_modulos VALUES (531, 'Modulo 3', 5, 'Modulo 3', 'Modulo 3', 16, 3, 3);
INSERT INTO public.cursos_modulos VALUES (532, 'Modulo 4', 6, 'Modulo 4', 'Modulo 4', 16, 4, 4);
INSERT INTO public.cursos_modulos VALUES (533, 'Modulo 5', 7, 'Modulo 5', 'Modulo 5', 16, 5, 5);
INSERT INTO public.cursos_modulos VALUES (534, 'Modulo 6', 8, 'Modulo 6', 'Modulo 6', 16, 6, 6);
INSERT INTO public.cursos_modulos VALUES (535, 'Modulo 7', 9, 'Modulo 7', 'Modulo 7', 16, 7, 7);
INSERT INTO public.cursos_modulos VALUES (536, 'Modulo 8', 10, 'Modulo 8', 'Modulo 8', 16, 8, 8);
INSERT INTO public.cursos_modulos VALUES (537, 'Modulo 9', 11, 'Modulo 9', 'Modulo 9', 16, 10, 10);
INSERT INTO public.cursos_modulos VALUES (538, 'Modulo 10', 12, 'Modulo 10', 'Modulo 10', 16, 10, 10);
INSERT INTO public.cursos_modulos VALUES (539, 'Modulo 11', 1, 'Modulo 11', 'Modulo 11', 16, 11, 11);
INSERT INTO public.cursos_modulos VALUES (540, 'Modulo 12', 2, 'Modulo 12', 'Modulo 12', 16, 12, 12);
INSERT INTO public.cursos_modulos VALUES (541, 'Modulo 13', 3, 'Modulo 13', 'Modulo 13', 16, 1, 1);
INSERT INTO public.cursos_modulos VALUES (542, 'Modulo 14', 4, 'Modulo 14', 'Modulo 14', 16, 2, 2);
INSERT INTO public.cursos_modulos VALUES (543, 'Modulo 15', 5, 'Modulo 15', 'Modulo 15', 16, 3, 3);
INSERT INTO public.cursos_modulos VALUES (544, 'Modulo 16', 6, 'Modulo 16', 'Modulo 16', 16, 4, 4);
INSERT INTO public.cursos_modulos VALUES (545, 'Modulo 17', 7, 'Modulo 17', 'Modulo 17', 16, 5, 5);
INSERT INTO public.cursos_modulos VALUES (546, 'Modulo 18', 8, 'Modulo 18', 'Modulo 18', 16, 6, 6);
INSERT INTO public.cursos_modulos VALUES (547, 'Modulo 19', 9, 'Modulo 19', 'Modulo 19', 16, 7, 7);
INSERT INTO public.cursos_modulos VALUES (548, 'Modulo 20', 10, 'Modulo 20', 'Modulo 20', 16, 8, 8);
INSERT INTO public.cursos_modulos VALUES (549, 'Modulo 21', 11, 'Modulo 21', 'Modulo 21', 16, 10, 10);
INSERT INTO public.cursos_modulos VALUES (550, 'Modulo 22', 12, 'Modulo 22', 'Modulo 22', 16, 10, 10);
INSERT INTO public.cursos_modulos VALUES (551, 'Modulo 23', 1, 'Modulo 23', 'Modulo 23', 16, 11, 11);
INSERT INTO public.cursos_modulos VALUES (552, 'Modulo 24', 2, 'Modulo 24', 'Modulo 24', 16, 12, 12);
INSERT INTO public.cursos_modulos VALUES (553, 'Modulo 1', 1, 'Modulo 1', 'Modulo 1', 17, 1, 1);
INSERT INTO public.cursos_modulos VALUES (554, 'Modulo 2', 2, 'Modulo 2 ', 'Modulo 2', 17, 2, 2);
INSERT INTO public.cursos_modulos VALUES (555, 'Modulo 3', 3, 'Modulo 3 ', 'Modulo 3', 17, 3, 3);



/* Nombre del perfil cursadas */
CREATE OR REPLACE FUNCTION public.sp_trg_cursadas_nombre_perfil()
RETURNS trigger AS
$BODY$
DECLARE
  sede character varying(255);
  curso character varying(255);
BEGIN
  SELECT nombre INTO sede FROM public.sedes WHERE NEW.id_sede=id;
  SELECT nombre INTO curso FROM public.cursos WHERE NEW.id_curso=id;
  NEW.nombre_perfil := curso || ' - Sede: ' || sede || ' - ' || NEW.descripcion;
  RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_bi_cursadas
BEFORE INSERT
ON public.cursadas
FOR EACH ROW
EXECUTE PROCEDURE public.sp_trg_cursadas_nombre_perfil();

CREATE TRIGGER trg_bu_cursadas
BEFORE UPDATE
ON public.cursadas
FOR EACH ROW
EXECUTE PROCEDURE public.sp_trg_cursadas_nombre_perfil();


ALTER TABLE clases_asistencia RENAME COLUMN id_persona TO id_alumno;
update cursadas_modulos set nro_modulo=orden where nro_modulo is null;

DROP TABLE public.clases_asistencia;
CREATE TABLE public.clases_asistencia
(
  id serial NOT NULL,
  id_alumno integer NOT NULL,
  id_clase integer NOT NULL,
  CONSTRAINT pk_clases_asistencia PRIMARY KEY (id),
  CONSTRAINT fk_clases_asistencia__persona FOREIGN KEY (id_alumno)
      REFERENCES public.personas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_clases_asistencia_clase FOREIGN KEY (id_clase)
      REFERENCES public.clases (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

ALTER TABLE public.clases_asistencia ADD COLUMN presente boolean;
ALTER TABLE public.clases_asistencia ALTER COLUMN presente SET NOT NULL;
ALTER TABLE public.clases_asistencia ALTER COLUMN presente SET DEFAULT false;
