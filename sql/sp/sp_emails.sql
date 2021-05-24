USE [disidentes_new]
GO

/****** Object:  StoredProcedure [dbo].[sp_emails]    Script Date: 16/5/2021 23:49:36 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[sp_emails](
@remite varchar(max),
@destinatario varchar(max),
@subject varchar(max),
@body varchar(max),
@toName varchar(max),
@fromName varchar(max)
)
AS

INSERT INTO [dbo].[emails]
   (remite,destinatario,[subject],[body],fecha_envio,toName,fromName)
  VALUES 
   (@remite,@destinatario,@subject,@body,null,@toNmae,@fromName)

GO


