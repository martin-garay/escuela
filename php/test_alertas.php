<?php

$alertas = toba::consulta_php('alertas')->get_alertas_persona(253);
ei_arbol($alertas);