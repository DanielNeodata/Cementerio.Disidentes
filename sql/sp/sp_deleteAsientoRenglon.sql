create procedure sp_deleteAsientoRenglon
@id int
as
begin 

	delete from CON_Renglones where idEncabezado=@id
	select * from CON_Renglones where 1=2

end