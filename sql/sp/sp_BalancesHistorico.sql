

alter procedure sp_BalanceHistorico
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

	/*
	AND (C.DESDE=@inicio) 
         AND (R.DESDE=@inicio) 
		 AND (DESDE=@inicio) 
	*/

    SELECT NUMERO, NOMBRE, ROC, 
    (SELECT Count(CASE WHEN FECHA <=@desde THEN 1 ELSE 0 END) FROM [CON_Renglones_Historico] WHERE (DESDE=@inicio) and U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryHasMovs, 
    (SELECT Sum(CASE WHEN FECHA< @desde THEN IMPORTE ELSE 0 END) FROM [CON_Renglones_Historico] WHERE (DESDE=@inicio) and U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qrySdoAnt, 
    (SELECT Sum(CASE WHEN FECHA BETWEEN @desde AND @hasta THEN (CASE WHEN IMPORTE>0 THEN  IMPORTE ELSE 0 END) ELSE 0 END) FROM [CON_Renglones_Historico] WHERE (DESDE=@inicio) and U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryTotDeb, 
    (SELECT Sum(CASE WHEN FECHA BETWEEN  @desde  AND @hasta THEN (CASE WHEN IMPORTE<0 THEN -IMPORTE ELSE 0 END) ELSE 0 END) FROM [CON_Renglones_Historico] WHERE (DESDE=@inicio) and U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryTotCre, 
    (SELECT Sum(CASE WHEN FECHA <= @hasta THEN IMPORTE ELSE 0 END) FROM [CON_Renglones_Historico] WHERE (DESDE=@inicio) and U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qrySdoAct, 
    REPLICATE('&nbsp;', ( 
    SELECT Count(NRO) 
    FROM ((SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Rubros_Historico]  WHERE (DESDE=@inicio) and NUMERO BETWEEN @cdesde AND '9999999999') UNION 
            (SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Cuentas_Historico] WHERE (DESDE=@inicio) and NUMERO BETWEEN @cdesde  AND '9999999999')) As S
    WHERE Left(NUMERO,Len(S.NRO))=S.NRO AND S.NRO<>NUMERO 
    )) As qryIndent 
    FROM ((SELECT NUMERO, NOMBRE, 'R' As ROC FROM [CON_Rubros_Historico]  WHERE (DESDE=@inicio) and NUMERO BETWEEN @cdesde  AND  @chasta ) UNION 
            (SELECT NUMERO, NOMBRE, 'C' As ROC FROM [CON_Cuentas_Historico] WHERE (DESDE=@inicio) and NUMERO BETWEEN @cdesde  AND @chasta )) As U1 
    WHERE (U1.NUMERO BETWEEN @cdesde AND @chasta) 
    GROUP BY NUMERO, NOMBRE, ROC 
    ORDER BY U1.NUMERO

end
go

exec sp_BalanceHistorico '2015-01-01','2015-01-01','0','99999999','' ,56  
go
exec sp_Balance '2015-01-01','2015-01-01','0','99999999','' 
go


