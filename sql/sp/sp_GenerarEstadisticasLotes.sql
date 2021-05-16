USE [disidentes]
GO

/****** Object:  StoredProcedure [dbo].[sp_GenerarEstadisticasLotes]    Script Date: 21/3/2021 01:13:40 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO





-- =============================================
-- Author:		Paul Dahuach
-- Create date: 2008-10-13
-- Description:	Regenera la tabla SAC_EstaLote incluyendo la info para correspondencia
-- =============================================
ALTER PROCEDURE [dbo].[sp_GenerarEstadisticasLotes]
AS

	SET NOCOUNT ON;

	DECLARE @RETVAL int
	DECLARE @SECCION nvarchar(3), @SEPULTURA nvarchar(6), @TIPO nvarchar(2), @TITULAR nvarchar(50), @ULTBIMPAGO datetime, @RES_DIRECC nvarchar(50), @RES_CODPOS nvarchar(6), @RES_LOCALI nvarchar(20), @RESPONSABL nvarchar(50), @RES_EMAIL nvarchar(255)
	DECLARE @intCan int, @intMeses int, @intDeuda int, @curImporte NUMERIC(18,2), @intCanTot int, @curPrecios6 NUMERIC(18,2), @curPrecios7 NUMERIC(18,2)

--	BEGIN TRANSACTION
		-- Inicializar variables...
		SET @RETVAL = 0
		SET @intCan = 0
		SET @intDeuda = 0
		SET @curImporte = 0
		SET @intCanTot = 0
		SET @curPrecios6 = 0
		SET @curPrecios7 = 0

		SELECT @curPrecios6 = CON_ADULTO, @curPrecios7 = CON_NIN_UR FROM SAC_Servicio;

		-- Vaciar las tablas de estadisticas...
		DELETE FROM SAC_EstaLote;
		DELETE FROM SAC_EstaTemp;

		DECLARE curLot CURSOR FOR
		SELECT   SECCION, SEPULTURA, TIPO, TITULAR, ULTBIMPAGO, RES_DIRECC, RES_CODPOS, RES_LOCALI, RESPONSABL, RES_EMAIL
		FROM	 SAC_Lotes
		ORDER BY SECCION, SEPULTURA;
		OPEN curLot

		-- MoveFirst
		FETCH NEXT FROM curLot INTO @SECCION, @SEPULTURA, @TIPO, @TITULAR, @ULTBIMPAGO,	@RES_DIRECC, @RES_CODPOS, @RES_LOCALI, @RESPONSABL, @RES_EMAIL
                WHILE (@@FETCH_STATUS = 0)
		BEGIN
			IF (@TIPO <> 'EX') AND NOT (UPPER(@TITULAR) Like '%DISPONIBL%') AND (@TITULAR <> '') AND (@SECCION<>'UC') AND (@SECCION<>'OS')
			BEGIN
                SET @intCan = @intCan + 1
				-- SET @curDeuda = CBIM(@ULTBIMPAGO, GETDATE())
				-- INLINE FUNCTION CBIM(@ULTBIMPAGO)
				-- Calcular bimestres entre una fecha y otra
				-- Se considera que un locatario DEBE un bimestre cuando todavia no lo pago
				-- el primer dia del bimestre siguiente.
				-- Recalcular formula en base a esto.
				SET @intMeses = 0
                IF (@ULTBIMPAGO IS NULL) OR (Convert(nvarchar(10), @ULTBIMPAGO) = '')
				  BEGIN
					SET @intMeses = -1;
				  END
				ELSE
				  BEGIN
					SET @intMeses = (YEAR(GETDATE()) - YEAR(@ULTBIMPAGO)) * 12 + (MONTH(GETDATE()) - MONTH(@ULTBIMPAGO)); -- + 1;
				END
				SET @intDeuda = (@intMeses / 2)

				IF @TIPO = 'AD' OR @TIPO = 'AN'
				BEGIN
					SET @curImporte = @curPrecios6 * @intDeuda
				END
				ELSE
				BEGIN
					SET @curImporte = @curPrecios7 * @intDeuda
				END
				-- Valores acumulados para el GroupHeader del Reporte...
				IF NOT (SELECT BIMESTRE FROM SAC_EstaTemp WHERE BIMESTRE=@intDeuda) IS NULL
				BEGIN
					UPDATE SAC_EstaTemp 
					SET CANTIDAD = CANTIDAD + 1, IMPORTE = IMPORTE + @curImporte
					WHERE BIMESTRE=@intDeuda
				END
				ELSE
				BEGIN
					INSERT INTO SAC_EstaTemp
						(BIMESTRE, CANTIDAD, IMPORTE, PORCENT1, PORCENT2)
					VALUES (@intDeuda, 1, @curImporte, NULL, NULL)
				END
				-- Valor detallado por lote de la deuda...
				INSERT INTO SAC_EstaLote
					(BIMESTRE, SECCION, SEPULTURA, TITULAR, ULTBIMPAGO, IMPORTE, DIRECCION, COD_POSTAL, LOCALIDAD, EMAIL, RESPONSABL, ENVIADO)
					VALUES (@intDeuda, @SECCION, @SEPULTURA, LEFT(@TITULAR, 40), @ULTBIMPAGO, @curImporte, @RES_DIRECC, @RES_CODPOS, @RES_LOCALI, @RES_EMAIL, LEFT(@RESPONSABL, 40), NULL)
				SET @intCanTot = @intCanTot + 1
			END
			-- MoveNext
			FETCH NEXT FROM curLot INTO @SECCION, @SEPULTURA, @TIPO, @TITULAR, @ULTBIMPAGO,	@RES_DIRECC, @RES_CODPOS, @RES_LOCALI, @RESPONSABL, @RES_EMAIL
		END
		UPDATE SAC_EstaTemp SET PORCENT1 = (CANTIDAD * 100) / CASE @intCanTot WHEN 0 THEN 1 ELSE @intCanTot END;

		CLOSE curLot
		DEALLOCATE curLot

		

		FIN:
		IF (@RETVAL = 0)
		BEGIN
	--		COMMIT
			select 'OK' as RunStatus
		END
		ELSE
		BEGIN
		--	ROLLBACK TRANSACTION
			select 'ERROR' as RunStatus
		END
		RETURN @RETVAL


GO


