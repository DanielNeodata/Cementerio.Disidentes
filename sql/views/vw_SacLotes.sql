
/*
select * from vw_SacLotes where seccion='141' and sepultura='25'
*/

alter view [vw_SacLotes] as 

SELECT [ID]
      ,[SECCION]
      ,[SEPULTURA]
      ,[SECTOR]
      ,[TIPO]
      ,[TITULAR]
      ,[DIRECCION]
      ,[COD_POSTAL]
      ,[LOCALIDAD]
      ,[TELEFONO]
      ,[EMAIL]
      ,[RESPONSABL]
      ,[RES_DIRECC]
      ,[RES_CODPOS]
      ,[RES_LOCALI]
      ,[RES_TELEFO]
      ,[RES_EMAIL]
      ,[NROTITULO]
      ,[FECHACOMPR]
      ,[PRECICOMPR]
      ,[ANOSARREND]
      ,[ULT_RENOVA]
      ,[ANOSRENOVA]
      ,[ULTBIMPAGO]
      ,[COMENTARIO]
      ,[NSER]
      ,case when [ULTBIMPAGO] is null then -1 else datediff(MM,[ULTBIMPAGO],getdate())/2 end as [DEUDA]
      ,[OBS]
      ,[ACUENTA]
      ,[TITULO]
      ,[CARTARENOV]
      ,[CARTACONSE]
      ,[REGLAMENTO]
      ,[VENCIMIENTO]
      ,[BIMVENCIDO]
      ,[RENVENCIDA]
      ,[id_forma_pago]
      ,[numero_tarjeta]
	  ,'Fecha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R. Nro. &nbsp;Detalle                                                   <br/>'+replace(replace( reverse(stuff(reverse(ISNULL((select dag.Historico + '| ' AS 'data()' from 
		 vw_SacLotesDetalleHistorico dag where dag.seccion = l.seccion and dag.SEPULTURA=l.SEPULTURA and dag.idLote=l.ID order by FECHA_EMIS ASC FOR XML PATH('')
		),'N/A,,')),1,2,'')),'|','<br/>'),';','&nbsp;&nbsp;&nbsp;&nbsp;') as HISTORIA
	  ,isnull(l.seccion,'') + '-' + isnull(l.sepultura,'') +'-' + isnull(l.sector,'') +'-' + isnull(l.tipo,'') as ssst,
	  ':;'+convert(varchar(50),[TITULAR])+';'+convert(varchar(100),[TELEFONO])+';'+convert(varchar(50),[RESPONSABL])+';'+convert(varchar(100),[RES_TELEFO])+';:' as InfoLote
  FROM 
	SAC_Lotes as l
go

--select REPLACE('sarasa2','2','OK')
select * from vw_SacLotes where seccion='141' and sepultura='25'
go