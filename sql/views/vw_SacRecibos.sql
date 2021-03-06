USE [disidentes]
GO

/****** Object:  View [dbo].[vw_SacRecibos]    Script Date: 18/3/2021 21:32:00 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER view [dbo].[vw_SacRecibos] as 

SELECT 
	  [ID]
      ,[NRO_RECIBO]
      ,[FECHA_EMIS]
      ,[RESPONSABL]
      ,[RENGLONES]
      ,ISNULL([PESOS],0) as PESOS
      ,ISNULL([DOLARES],0) as DOLARES
      ,ISNULL([CHEQUE],0) as CHEQUE
      ,[BANCO]
      ,ISNULL([TARJETA],0) as TARJETA
      ,[TARJDATO]
      ,ISNULL([COTIZACION],0) as COTIZACION
      ,ISNULL([TRANSFERENCIA],0) AS TRANSFERENCIA
	  ,CONVERT(char(10),FECHA_EMIS,103) as FECHA_EMIS_SPA
	  ,convert(float,ISNULL([PESOS],0))+convert(float,ISNULL([DOLARES],0))*convert(float,ISNULL([COTIZACION],0))+convert(float,ISNULL([CHEQUE],0))+convert(float,ISNULL([TARJETA],0))+convert(float,ISNULL([TRANSFERENCIA],0)) as TOTAL
  FROM 
	SAC_Enca as l


GO





--select REPLACE('sarasa2','2','OK')
--select * from vw_SacLotes where seccion='141' and sepultura='25'
--go