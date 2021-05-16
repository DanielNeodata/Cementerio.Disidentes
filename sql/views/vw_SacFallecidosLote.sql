USE [disidentes]
GO

/****** Object:  View [dbo].[vw_SacFallecidosLote]    Script Date: 23/1/2021 18:37:09 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

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


