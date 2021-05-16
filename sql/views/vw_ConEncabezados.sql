alter view vw_ConEncabezados as
select 
	ID,
	NUMERO as NUMERO_ENCABEZADO,
	FECHA,
	RENGLONES,
	COMENTARIO,
	XTRUDEADO--,
--	convert(varchar(2),'0') as TIPCON,
--	0 as NUMCON,
--	0 as BALANCE
from CON_Encabezados