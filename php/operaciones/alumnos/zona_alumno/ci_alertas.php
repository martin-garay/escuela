<?php
class ci_alertas extends escuela_ci
{
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_alumno();			
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		return toba::zona()->get_alertas();
	}

}

?>