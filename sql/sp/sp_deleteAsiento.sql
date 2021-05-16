alter procedure sp_deleteAsiento
@id int
as
begin 

	delete from CON_Renglones where idEncabezado=@id
	delete from CON_ENCABEZADOS where ID=@id

	select * from CON_ENCABEZADOS where 1=2

end