    
	
	--select * from dbo.CON_cuentas order by NUMERO
	-- SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY ID DESC order by convert(int,ID) desc

create procedure sp_LibroMayorHistorico
@desde datetime,
@hasta datetime,
@cdesde varchar(20),
@chasta varchar(20),
@prefijo varchar(20),
@idEjercicio int
as
begin
	SET NOCOUNT ON;
			  
		declare @inicio datetime
		select @inicio= INICIO FROM [CON_Configuracion_Historico]  where ID = @idEjercicio
			    
		SELECT C.NUMERO, C.NOMBRE, 
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE>0 THEN R.IMPORTE ELSE 0 END) As qrySdoDeb,  
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE<0 THEN -R.IMPORTE ELSE 0 END) As qrySdoHab, 
		Sum(CASE WHEN R.FECHA<@desde THEN R.IMPORTE ELSE 0 END) As qrySdoAnt 
		into #saldos
		FROM [CON_Cuentas_Historico] As C LEFT outer JOIN  [CON_Renglones_Historico] As R ON C.NUMERO=R.CUENTA 
		 
		WHERE 1=2
		GROUP BY C.NUMERO, C.NOMBRE ORDER BY C.NUMERO;


    if (@prefijo='')
	begin
		insert into #saldos
		SELECT C.NUMERO, C.NOMBRE, 
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE>0 THEN R.IMPORTE ELSE 0 END) As qrySdoDeb,  
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE<0 THEN -R.IMPORTE ELSE 0 END) As qrySdoHab, 
		Sum(CASE WHEN R.FECHA<@desde THEN R.IMPORTE ELSE 0 END) As qrySdoAnt 
		FROM [CON_Cuentas_Historico] As C LEFT outer JOIN  [CON_Renglones_Historico] As R ON C.NUMERO=R.CUENTA 
		WHERE 
			--(R.ASIENTO Like @prefijo 
		(C.NUMERO BETWEEN @cdesde AND @chasta) 
		 AND (C.DESDE=@inicio) 
         AND (R.DESDE=@inicio) 
		GROUP BY C.NUMERO, C.NOMBRE ORDER BY C.NUMERO;
	end
	else
	begin

		select @prefijo=@prefijo+'%'
		insert into #saldos
		SELECT C.NUMERO, C.NOMBRE, 
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE>0 THEN R.IMPORTE ELSE 0 END) As qrySdoDeb,  
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE<0 THEN -R.IMPORTE ELSE 0 END) As qrySdoHab, 
		Sum(CASE WHEN R.FECHA<@desde THEN R.IMPORTE ELSE 0 END) As qrySdoAnt 
		FROM [CON_Cuentas_Historico] As C LEFT outer JOIN  [CON_Renglones_Historico] As R ON C.NUMERO=R.CUENTA 
		WHERE 
			(R.ASIENTO Like @prefijo) and  
		(C.NUMERO BETWEEN @cdesde AND @chasta) 
		AND (C.DESDE=@inicio) 
         AND (R.DESDE=@inicio) 
		GROUP BY C.NUMERO, C.NOMBRE ORDER BY C.NUMERO;
	end
						
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		into #cuentas
		FROM CON_Renglones_Historico As R left  join CON_Encabezados_Historico As E on (e.NUMERO=r.ASIENTO )
		WHERE  1=2
		ORDER BY R.ASIENTO;

    if (@prefijo='')
	begin
		insert into #cuentas
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		
		FROM CON_Renglones_Historico As R left  join CON_Encabezados_Historico As E on (e.NUMERO=r.ASIENTO )
		WHERE  (R.FECHA BETWEEN @desde AND @hasta) And (R.CUENTA BETWEEN @cdesde AND @chasta) 
		 AND (E.DESDE=@inicio) 
         AND (R.DESDE=@inicio) 
				--And R.ASIENTO Like @prefijo 
		ORDER BY R.ASIENTO;

	end
	else
	begin
		insert into #cuentas
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		
		FROM CON_Renglones_Historico As R left  join CON_Encabezados_Historico As E on (e.NUMERO=r.ASIENTO )
		WHERE  (R.FECHA BETWEEN @desde AND @hasta) And (R.CUENTA BETWEEN @cdesde AND @chasta) 
				And R.ASIENTO Like @prefijo 
				AND (E.DESDE=@inicio) 
         AND (R.DESDE=@inicio) 
		ORDER BY R.ASIENTO;
	end
		select s.*,c.* from #saldos s left join #cuentas c on (s.NUMERO=c.CUENTA)
		 order by s.NUMERO,c.ASIENTO

		 --select * from #saldos
		 --select * from #cuentas

		 drop table #cuentas
		 drop table #saldos

end
go

exec sp_LibroMayorHistorico '2015-01-01','2015-01-01','0','99999999','',56        
go
exec sp_LibroMayor '2015-01-01','2015-01-01','0','99999999','',56
go
 --select * from CON_Renglones a where a.FECHA<='2015-12-31'		    

-- sp_who


