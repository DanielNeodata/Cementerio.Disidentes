
ALTER view [dbo].[vw_SacLotesDetalleHistorico]
as
  /*select 'Fecha             R. Nro.   Detalle                                                   <br/>' as Historico,
  union all                                                                          */
  SELECT 
	convert(varchar(20),[FECHA_EMIS],103)+';'+convert(varchar(20),[NRO_RECIBO])+';'+[CONCEPTO] as Historico,Seccion,Sepultura,idLote,FECHA_EMIS
      
  FROM SAC_Movimientos
GO
