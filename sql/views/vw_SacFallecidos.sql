alter view vw_SacFallecidosLote
as
select 
	':;'+convert(varchar(50),[NRO_APERTU])+';'+convert(varchar(100),[NOMBRE])+';:' as InfoLote,
	SECCION,
	SEPULTURA,
	TIPO,
	idLote,
	NRO_APERTU,
	NOMBRE
FROM SAC_Fallecidos	
go

alter view vw_SacFallecidos
as
SELECT  l.ID
      ,[SECCION]
      ,[SEPULTURA]
      ,[TIPO]
      ,[idLote]
      ,[NRO_APERTU]
      ,[NOMBRE]
      ,[EDAD]
      ,[ESTADOCIVI]
      ,[NACIONALID]
      ,[CAUSADECES]
      ,[PARTIDA]
      ,[FECHA]
      ,[HORA]
      ,[EMPR_FUNEB]
      ,[OBSERVACIO]

	  	  ,'<table cellpadding=10><tr><td>Titular</td><td>Tel. Tit. </td><td>Responsable </td><td>Tel. Resp.</td></tr>'+replace(replace(replace(replace( reverse(stuff(reverse(ISNULL((select InfoLote + '| ' AS 'data()' from 
		 vw_SacLotes dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','</tr>'),':;','<tr><td>'),';:','</td></tr>'),';','</td><td>')+'</table>' as InfoLote

		,'<table cellpadding=10><tr><td>Nro Apertura</td><td>Nombre</td></tr>'+replace(replace(replace(replace( reverse(stuff(reverse(ISNULL((select InfoLote + '| ' AS 'data()' from 
		 vw_SacFallecidosLote dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA order by NRO_APERTU FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','</tr>'),':;','<tr><td>'),';:','</td></tr>'),';','</td><td>')+'</table>' as InfoLoteApertura
      ,isnull(l.SECCION,'') + '-' + isnull(l.SEPULTURA,'') +'-' + isnull(l.TIPO,'') as sst 

  FROM SAC_Fallecidos l
  go
  select * from vw_SacFallecidos  where SECCION='1' and SEPULTURA='13'
  go