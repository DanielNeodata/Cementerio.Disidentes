
alter procedure DetalleMovimientoDeCaja
@desde datetime,
@hasta datetime
as
begin

SET NOCOUNT ON;

SELECT E.NRO_RECIBO, E.FECHA_EMIS, IsNull(E.TRANSFERENCIA,0) As qryTRANSFERENCIAS, IsNull(E.PESOS,0) As qryPESOS, IsNull(E.CHEQUE,0) As qryCHEQUE, IsNull(E.DOLARES,0) As qryDOLARES, IsNull(E.DOLARES,0)*IsNull(E.COTIZACION,0) As qryDolaresEnPesos, IsNull(E.TARJETA,0) As qryTARJETA, 
    IsNull(E.PESOS,0)+IsNull(E.CHEQUE,0)+IsNull(E.TARJETA,0) As qrySubTotal, 
    IsNull(E.TRANSFERENCIA,0)+IsNull(E.PESOS,0)+IsNull(E.CHEQUE,0)+IsNull(E.DOLARES,0)*IsNull(E.COTIZACION,0)+IsNull(E.TARJETA,0) As qryTotal 
	into #tmp1
    FROM [SAC_Enca] As E 
    WHERE E.FECHA_EMIS BETWEEN @desde AND @hasta;

SELECT M.NRO_RECIBO, M.CONCEPTO, M.IMPORTE into #tmp2
                FROM [SAC_Movimientos] As M 
                WHERE M.FECHA_EMIS BETWEEN  @desde AND @hasta
                ORDER BY M.ID

select * from #tmp1 a, #tmp2 b where a.NRO_RECIBO=b.NRO_RECIBO
order by FECHA_EMIS

end
go

exec DetalleMovimientoDeCaja '2020-05-01','2020-05-04'