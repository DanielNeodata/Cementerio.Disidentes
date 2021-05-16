    
	
	--select * from dbo.CON_cuentas order by NUMERO

alter procedure sp_LibroMayor
@desde datetime,
@hasta datetime,
@cdesde varchar(20),
@chasta varchar(20),
@prefijo varchar(20)
as
begin
	SET NOCOUNT ON;
			    
		SELECT C.NUMERO, C.NOMBRE, 
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE>0 THEN R.IMPORTE ELSE 0 END) As qrySdoDeb,  
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE<0 THEN -R.IMPORTE ELSE 0 END) As qrySdoHab, 
		Sum(CASE WHEN R.FECHA<@desde THEN R.IMPORTE ELSE 0 END) As qrySdoAnt 
		into #saldos
		FROM [CON_Cuentas] As C LEFT outer JOIN  [CON_Renglones] As R ON C.NUMERO=R.CUENTA 
		WHERE 1=2
		GROUP BY C.NUMERO, C.NOMBRE ORDER BY C.NUMERO;
    if (@prefijo='')
	begin
		insert into #saldos
		SELECT C.NUMERO, C.NOMBRE, 
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE>0 THEN R.IMPORTE ELSE 0 END) As qrySdoDeb,  
		Sum(CASE WHEN R.FECHA<@desde AND R.IMPORTE<0 THEN -R.IMPORTE ELSE 0 END) As qrySdoHab, 
		Sum(CASE WHEN R.FECHA<@desde THEN R.IMPORTE ELSE 0 END) As qrySdoAnt 
		FROM [CON_Cuentas] As C LEFT outer JOIN  [CON_Renglones] As R ON C.NUMERO=R.CUENTA 
		WHERE 
			--(R.ASIENTO Like @prefijo 
		(C.NUMERO BETWEEN @cdesde AND @chasta) 
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
		FROM [CON_Cuentas] As C LEFT outer JOIN  [CON_Renglones] As R ON C.NUMERO=R.CUENTA 
		WHERE 
			(R.ASIENTO Like @prefijo) and  
		(C.NUMERO BETWEEN @cdesde AND @chasta) 
		GROUP BY C.NUMERO, C.NOMBRE ORDER BY C.NUMERO;
	end
						
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		into #cuentas
		FROM CON_Renglones As R left  join CON_Encabezados As E on (R.idEncabezado=E.ID)
		WHERE  1=2
		ORDER BY R.ASIENTO;

    if (@prefijo='')
	begin
		insert into #cuentas
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		
		FROM CON_Renglones As R left  join CON_Encabezados As E on (R.idEncabezado=E.ID)
		WHERE  (R.FECHA BETWEEN @desde AND @hasta) And (R.CUENTA BETWEEN @cdesde AND @chasta) 
				--And R.ASIENTO Like @prefijo 
		ORDER BY R.ASIENTO;

	end
	else
	begin
		insert into #cuentas
		SELECT R.CUENTA, E.COMENTARIO, R.COMENTARIO As qryObsRen, 
		R.FECHA, R.ASIENTO, R.TIPCOM, R.NUMCOM, 
		CASE WHEN R.IMPORTE>0 THEN R.IMPORTE ELSE NULL END As qryDeb, CASE WHEN R.IMPORTE<=0 THEN -R.IMPORTE ELSE NULL END As qryCre 
		
		FROM CON_Renglones As R left  join CON_Encabezados As E on (R.idEncabezado=E.ID)
		WHERE  (R.FECHA BETWEEN @desde AND @hasta) And (R.CUENTA BETWEEN @cdesde AND @chasta) 
				And R.ASIENTO Like @prefijo 
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
exec sp_LibroMayor '2017-01-01','2017-01-01','0','99999999',''        
 --select * from CON_Renglones a where a.FECHA<='2015-12-31'		    

 sp_who


