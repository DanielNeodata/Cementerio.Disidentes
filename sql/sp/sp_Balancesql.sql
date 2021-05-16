

create procedure sp_Balance
@desde datetime,
@hasta datetime,
@cdesde varchar(20),
@chasta varchar(20),
@prefijo varchar(20)
as
begin
	SET NOCOUNT ON;


    SELECT NUMERO, NOMBRE, ROC, 
    (SELECT Count(CASE WHEN FECHA <=@desde THEN 1 ELSE 0 END) FROM [CON_Renglones] WHERE U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryHasMovs, 
    (SELECT Sum(CASE WHEN FECHA< @desde THEN IMPORTE ELSE 0 END) FROM [CON_Renglones] WHERE U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qrySdoAnt, 
    (SELECT Sum(CASE WHEN FECHA BETWEEN @desde AND @hasta THEN (CASE WHEN IMPORTE>0 THEN  IMPORTE ELSE 0 END) ELSE 0 END) FROM [CON_Renglones] WHERE U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryTotDeb, 
    (SELECT Sum(CASE WHEN FECHA BETWEEN  @desde  AND @hasta THEN (CASE WHEN IMPORTE<0 THEN -IMPORTE ELSE 0 END) ELSE 0 END) FROM [CON_Renglones] WHERE U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qryTotCre, 
    (SELECT Sum(CASE WHEN FECHA <= @hasta THEN IMPORTE ELSE 0 END) FROM [CON_Renglones] WHERE U1.NUMERO=Left(CUENTA,Len(U1.NUMERO))) As qrySdoAct, 
    REPLICATE('&nbsp;', ( 
    SELECT Count(NRO) 
    FROM ((SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Rubros]  WHERE NUMERO BETWEEN @cdesde AND '9999999999') UNION 
            (SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Cuentas] WHERE NUMERO BETWEEN @cdesde  AND '9999999999')) As S
    WHERE Left(NUMERO,Len(S.NRO))=S.NRO AND S.NRO<>NUMERO 
    )) As qryIndent 
    FROM ((SELECT NUMERO, NOMBRE, 'R' As ROC FROM [CON_Rubros]  WHERE NUMERO BETWEEN @cdesde  AND  @chasta ) UNION 
            (SELECT NUMERO, NOMBRE, 'C' As ROC FROM [CON_Cuentas] WHERE NUMERO BETWEEN @cdesde  AND @chasta )) As U1 
    WHERE (U1.NUMERO BETWEEN @cdesde AND @chasta) 
    GROUP BY NUMERO, NOMBRE, ROC 
    ORDER BY U1.NUMERO

end
go

exec sp_Balance '2017-01-01','2017-01-01','0','99999999',''   

sp_who