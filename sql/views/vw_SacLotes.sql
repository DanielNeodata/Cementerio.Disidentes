
/*
select * from vw_SacLotes where seccion='141' and sepultura='25'
*/



/*
select * from vw_SacLotes where seccion='141' and sepultura='25'
*/

ALTER view [dbo].[vw_SacLotes] as 

SELECT l.[ID]
      ,rtrim(ltrim(l.[SECCION])) as SECCION
      ,rtrim(ltrim(l.[SEPULTURA])) as SEPULTURA
      ,l.[SECTOR]
      ,l.[TIPO]
      ,l.[TITULAR]
      ,l.[DIRECCION]
      ,l.[COD_POSTAL]
      ,l.[LOCALIDAD]
      ,l.[TELEFONO]
      ,l.[EMAIL]
      ,l.[RESPONSABL]
      ,l.[RES_DIRECC]
      ,l.[RES_CODPOS]
      ,l.[RES_LOCALI]
      ,l.[RES_TELEFO]
      ,l.[RES_EMAIL]
      ,l.[NROTITULO]
      ,l.[FECHACOMPR]
      ,l.[PRECICOMPR]
      ,l.[ANOSARREND]
      ,l.[ULT_RENOVA]
      ,l.[ANOSRENOVA]
      ,l.[ULTBIMPAGO]
      ,l.[COMENTARIO]
      ,l.[NSER]
      ,case when [ULTBIMPAGO] is null then -1 else datediff(MM,[ULTBIMPAGO],getdate())/2 end as [DEUDA]
      ,l.[OBS]
      ,l.[ACUENTA]
      ,l.[TITULO]
      ,l.[CARTARENOV]
      ,l.[CARTACONSE]
      ,l.[REGLAMENTO]
      ,l.[VENCIMIENTO]
      ,l.[BIMVENCIDO]
      ,l.[RENVENCIDA]
      ,l.[id_forma_pago]
      ,l.[numero_tarjeta]
	  ,l.[ESTADO_OCUPACION]
	  ,l.[EMAIL_SEC]
	  ,l.[RES_EMAIL_SEC]
	  ,convert(int,ISNULL(sm.IMPORTE,0)) as IMPORTEACUENTA
	  ,eo.[descripcion] as ESTADO_OCUPACION_DESC
	  ,'Fecha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R. Nro. &nbsp;Detalle                                                   <br/>'+replace(replace( reverse(stuff(reverse(ISNULL((select dag.Historico + '| ' AS 'data()' from 
		 vw_SacLotesDetalleHistorico dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA and dag.idLote=l.ID order by FECHA_EMIS ASC FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','<br/>'),';','&nbsp;&nbsp;&nbsp;&nbsp;') as HISTORIA
	  ,isnull(l.seccion,'') + '-' + isnull(l.sepultura,'') +'-' + isnull(l.sector,'') +'-' + isnull(l.tipo,'') as ssst,
	  ':;'+convert(varchar(50),l.[TITULAR])+';'+convert(varchar(100),[TELEFONO])+';'+convert(varchar(50),[RESPONSABL])+';'+convert(varchar(100),[RES_TELEFO])+';:' as InfoLote
	  ,RIGHT( REPLICATE('_', 4) + RTRIM(l.SECCION), 4 )+' | '+RIGHT( REPLICATE('_', 4) + RTRIM(l.SEPULTURA), 4 )+' | '+l.TIPO+' | '+l.TITULAR+' | '+l.RESPONSABL+ ' | '+eo.descripcion as ComboBusquedaRecibos
  FROM 
	SAC_Lotes as l left join estados_ocupacion eo on (l.ESTADO_OCUPACION = eo.Id)
	left join SAC_Movimientos sm on (l.ACUENTA=sm.NRO_RECIBO and sm.OPERACION='PC' and IMPORTE>0)





go

--select REPLACE('sarasa2','2','OK')
select * from vw_SacLotes where seccion='141' and sepultura='25'
go

