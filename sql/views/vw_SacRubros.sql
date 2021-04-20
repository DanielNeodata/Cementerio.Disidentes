create view vw_SacRubros
as

	--REPLICATE(' ',(SELECT Count(NUMERO)*2+R1.NUMERO as NUMERO_TAB, 
	--REPLICATE(' ',(SELECT Count(NUMERO)*2 + ISNULL(R1.NOMBRE,'') as NOMBRE_TAB, 
SELECT 
    --REPLICATE(' ',(SELECT Count(NUMERO)*2+R1.NUMERO as NUMERO_TAB, 
	--REPLICATE(' ',(SELECT Count(NUMERO)*3 + ISNULL(R1.NOMBRE,'') as NOMBRE_TAB, 
	R1.ID,
	R1.NUMERO, 
	ISNULL(R1.NOMBRE,'') as NOMBRE, 
	REPLICATE('&nbsp;',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) As HtmlIndent,  
	REPLICATE(' ',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) As BlankIndent,
	(SELECT Count(NUMERO) FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO) As NumIndent,
	REPLICATE('&nbsp;',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) + R1.NUMERO As NUMERO_HTML,  
	REPLICATE('&nbsp;',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) + ISNULL(R1.NOMBRE,'') As NOMBRE_HTML,  
	REPLICATE(' ',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) + R1.NUMERO As NUMERO_BLANK,  
	REPLICATE(' ',(SELECT Count(NUMERO)*3 FROM [CON_Rubros] WHERE Left(R1.NUMERO,Len(NUMERO))=NUMERO AND NUMERO<>R1.NUMERO)) + ISNULL(R1.NOMBRE,'') As NOMBRE_BLANK  

FROM 
	[CON_Rubros] As R1