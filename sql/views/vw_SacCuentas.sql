
create view vw_SacCuentas
as
 SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, isnull(qryTA,'') as TipoAjuste,  
                    REPLICATE(' ', ( 
                    SELECT Count(NRO) * 3
                    FROM ((SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Rubros]  WHERE NUMERO BETWEEN '0' AND '9999999999') UNION 
                          (SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Cuentas] WHERE NUMERO BETWEEN '0' AND '9999999999')) As S 
                    WHERE Left(NUMERO,Len(S.NRO))=S.NRO AND S.NRO<>NUMERO 
                    )) As IndentBlank,
					REPLICATE('&nbsp;', ( 
                    SELECT Count(NRO) * 3
                    FROM ((SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Rubros]  WHERE NUMERO BETWEEN '0' AND '9999999999') UNION 
                          (SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Cuentas] WHERE NUMERO BETWEEN '0' AND '9999999999')) As S 
                    WHERE Left(NUMERO,Len(S.NRO))=S.NRO AND S.NRO<>NUMERO 
                    )) As IndentHtml 
                    FROM ((SELECT NUMERO, NOMBRE, NULL As SALDONOMIN, NULL As SALDOAJUST, NULL As qryTA FROM [CON_Rubros]  WHERE NUMERO BETWEEN '0' AND '9999999999') UNION 
                          (SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, CASE WHEN TIPOAJUSTE='A' THEN 'Automático' ELSE (CASE WHEN TIPOAJUSTE='D' THEN 'Directo' ELSE 'Sin Ajuste' END) END As qryTA 
FROM [CON_Cuentas] WHERE NUMERO BETWEEN '0' AND '9999999999')) As U1 
WHERE (U1.NUMERO BETWEEN '0' AND '9999999999') 