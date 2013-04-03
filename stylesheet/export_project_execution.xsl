<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-public="-//W3C//DTD HTML 4.01//EN"
                doctype-system="http://www.w3.org/TR/html4/strict.dtd" />
 
    <xsl:template match="scripts">
        <html>
            <head>
                <title>deltasql Server - Export Project</title>
            </head>
            <body>
			    <a href="index.php"><img src="pictures/deltasql.png" alt="logo" border="0" /></a>
                <h2>Export Project</h2>
                <table border="1">
					<tr>
						<th>id</th>
						<th>title</th>
						<th>version number</th>
						<th>code</th>
						<th>create_dt</th>
						<th>update_dt</th>
					</tr>
                    
                    <xsl:apply-templates select="script"/>
                </table>
				<hr />
				<a href="index.php"><img src="icons/home.png" /> Back to main menu</a>
            </body>
        </html>
    </xsl:template>
 
    <xsl:template match="script">
        <tr>
            <td>
                <xsl:value-of select="id"/>			
            </td>
			<td>
                <xsl:value-of select="title"/>			
            </td>
			<td>
                <xsl:value-of select="versionnr"/>			
            </td>
			<td>
                <xsl:value-of select="code"/>			
            </td>
			<td>
                <xsl:value-of select="create_dt"/>			
            </td>
			<td>
                <xsl:value-of select="update_dt"/>			
            </td>
		</tr>
    </xsl:template>
 
</xsl:stylesheet>