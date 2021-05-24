USE [disidentes_new]
GO

/****** Object:  StoredProcedure [dbo].[sp_emails]    Script Date: 17/5/2021 22:04:30 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


create PROCEDURE [dbo].[sp_emails_update](
@id int,
@error varchar(max)
)
AS

if (@error is null or rtrim(ltrim(@error))='')
begin
	update emails set error=@error, fecha_envio=GETDATE(),estado='enviado'
	where id=@id
end
else
begin
	update emails set error=@error, fecha_envio=GETDATE(),estado='error'
	where id=@id
end

select * from emails where id=@id

GO


