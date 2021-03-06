ALTER view [dbo].[vw_SacFallecidosLote]
as
select 
	':;'+CASE WHEN TIPO='UR' THEN 'Urna' ELSE 'Ap. Nº '+convert(varchar(50),[NRO_APERTU]) end+';'+convert(varchar(100),[NOMBRE])+';:' as InfoLote,
	SECCION,
	SEPULTURA,
	TIPO,
	idLote,
	NRO_APERTU,
	NOMBRE
FROM SAC_Fallecidos	
GO



ALTER view [dbo].[vw_SacFallecidos]
as
SELECT  l.ID
      ,ltrim(rtrim(l.[SECCION])) as SECCION
      ,ltrim(rtrim(l.[SEPULTURA])) as SEPULTURA
      ,l.[TIPO]
      ,l.[idLote]
      ,l.[NRO_APERTU]
      ,l.[NOMBRE]
      ,l.[EDAD]
      ,l.[ESTADOCIVI]
      ,l.[NACIONALID]
      ,l.[CAUSADECES]
      ,l.[PARTIDA]
      ,l.[FECHA]
      ,l.[HORA]
      ,l.[EMPR_FUNEB]
      ,l.[DNI]
      ,l.[OBSERVACIO]

	  	  ,'<table cellpadding=10><tr><td>Titular</td><td>Tel. Tit. </td><td>Responsable </td><td>Tel. Resp.</td></tr>'+replace(replace(replace(replace( reverse(stuff(reverse(ISNULL((select InfoLote + '| ' AS 'data()' from 
		 vw_SacLotes dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','</tr>'),':;','<tr><td>'),';:','</td></tr>'),';','</td><td>')+'</table>' as InfoLote

		,'<table cellpadding=10><tr><td>Nro Apertura</td><td>Nombre</td></tr>'+replace(replace(replace(replace( reverse(stuff(reverse(ISNULL((select InfoLote + '| ' AS 'data()' from 
		 vw_SacFallecidosLote dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA order by NRO_APERTU FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','</tr>'),':;','<tr><td>'),';:','</td></tr>'),';','</td><td>')+'</table>' as InfoLoteApertura
      ,isnull(l.SECCION,'') + '-' + isnull(l.SEPULTURA,'') +'-' + isnull(l.TIPO,'') as sst 
	  ,RIGHT( REPLICATE('_', 4) + RTRIM(l.SECCION), 4 )+' | '+RIGHT( REPLICATE('_', 4) + RTRIM(l.SEPULTURA), 4 )+' | '+l.TIPO+' | '+ l.NOMBRE +' | '+convert(varchar(15),l.NRO_APERTU)+' | '+convert(varchar(20),sl.ID) as ComboBusquedaRecibos
  FROM SAC_Fallecidos l left join SAC_Lotes sl on (l.SECCION=sl.SECCION and l.SEPULTURA=sl.SEPULTURA)




GO

  select * from vw_SacFallecidos  where SECCION='1' and SEPULTURA='13'
  go