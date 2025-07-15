-- Query para traspasar la alineacion formalizada 
update informe_acciones set alineacion_la = (select lineas from ia_alineacion where ia_alineacion.ia_id = informe_acciones.id LIMIT 1);