<?php
/*************************************************************************************
 * genero.php
 * ----------
 * Author: Lars Gersmann (lars.gersmann@gmail.com)
 * Copyright: (c) 2007 Lars Gersmann, Nigel McNie (http://qbnz.com/highlighter/)
 * Release Version: 1.0.7.21
 * CVS Revision Version: $Revision: 1.1 $
 *
 * Genero (FOURJ's Genero 4GL) language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2007/07/01 (1.0.0)
 *  -  Initial release
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

 $language_data = array (
    'LANG_NAME' => 'genero',
    'COMMENT_SINGLE' => array(1 => '--', 2 => '#'),
    'COMMENT_MULTI' => array('{' => '}'),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array("'", '"'),
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => array(
        1 => array(
          "ABSOLUTE",
            "ACCEPT",
            "ACTION",
            "ADD",
            "AFTER",
            "ALL",
            "ALTER",
            "AND",
            "ANY",
            "APPEND",
            "APPLICATION",
            "AS",
            "AT",
            "ATTRIBUTE",
            "ATTRIBUTES",
            "AUDIT",
            "AVG",
            "BEFORE",
            "BEGIN",
            "BETWEEN",
            "BORDER",
            "BORDER",
            "BOTTOM",
            "BREAKPOINT",
            "BUFFER",
            "BUFFERED",
            "BY",
            "CALL",
            "CANCEL",
            "CASE",
            "CENTURY",
            "CHANGE",
            "CHECK",
            "CLEAR",
            "CLIPPED",
            "CLOSE",
            "CLUSTER",
            "COLUMN",
            "COLUMNS",
            "COMMAND",
            "COMMENT",
            "COMMIT",
            "COMMITTED",
            "CONCURRENT ",
            "CONNECT",
            "CONNECTION",
            "CONSTANT",
            "CONSTRAINED",
            "CONSTRAINT",
            "CONSTRUCT",
            "CONTINUE",
            "CONTROL",
            "COUNT",
            "CREATE",
            "CROSS",
            "CURRENT",
            "DATABASE",
            "DBA",
            "DEC",
            "DECLARE",
            "DEFAULT",
            "DEFAULTS",
            "DEFER",
            "DEFINE",
            "DELETE",
            "DELIMITER",
            "DESCRIBE",
            "DESTINATION",
            "DIM",
            "DIALOG",
            "DIMENSION",
            "DIRTY",
            "DISCONNECT",
            "DISPLAY",
            "DISTINCT",
            "DORMANT",
            "DOWN",
            "DROP",
            "DYNAMIC",
            "ELSE",
            "END",
            "ERROR",
            "ESCAPE",
            "EVERY",
            "EXCLUSIVE",
            "EXECUTE",
            "EXISTS",
            "EXIT",
            "EXPLAIN",
            "EXTEND",
            "EXTENT",
            "EXTERNAL",
            "FETCH",
            "FGL_DRAWBOX",
            "FIELD",
            "FIELD_TOUCHED",
            "FILE",
            "FILL",
            "FINISH",
            "FIRST",
            "FLOAT",
            "FLUSH",
            "FOR",
            "FOREACH",
            "FORM",
            "FORMAT",
            "FOUND",
            "FRACTION",
            "FREE",
            "FROM",
            "FULL",
            "FUNCTION",
            "GET_FLDBUF",
            "GLOBALS",
            "GO",
            "GOTO",
            "GRANT",
            "GROUP",
            "HAVING",
            "HEADER",
            "HELP",
            "HIDE",
            "HOLD",
            "HOUR",
            "IDLE",
            "IF",
            "IMAGE",
            "IMMEDIATE",
            "IN",
            "INDEX",
            "INFIELD",
            "INITIALIZE",
            "INNER",
            "INPUT",
            "INSERT",
            "INTERRUPT",
            "INTERVAL",
            "INTO",
            "INVISIBLE",
            "IS",
            "ISOLATION",
            "JOIN",
            "KEEP",
            "KEY",
            "LABEL",
            "LAST",
            "LEFT",
            "LENGTH",
            "LET",
            "LIKE",
            "LINE",
            "LINENO",
            "LINES",
            "LOAD",
            "LOCATE",
            "LOCK",
            "LOG",
            "LSTR",
            "MAIN",
            "MARGIN",
            "MATCHES",
            "MAX",
            "MAXCOUNT",
            "MDY",
            "MEMORY",
            "MENU",
            "MESSAGE",
            "MIN",
            "MINUTE",
            "MOD",
            "MODE",
            "MODIFY",
            "MONEY",
            "NAME",
            "NEED",
            "NEXT",
            "NO",
            "NORMAL",
            "NOT",
            "NOTFOUND",
            "NULL",
            "NUMERIC",
            "OF",
            "ON",
            "OPEN",
            "OPTION",
            "OPTIONS",
            "OR",
            "ORDER",
            "OTHERWISE",
            "OUTER",
            "OUTPUT",
            "PAGE",
            "PAGENO",
            "PAUSE",
            "PERCENT",
            "PICTURE",
            "PIPE",
            "PRECISION",
            "PREPARE",
            "PREVIOUS",
            "PRINT",
            "PRINTER",
            "PRINTX",
            "PRIOR",
            "PRIVILEGES",
            "PROCEDURE",
            "PROGRAM",
            "PROMPT",
            "PUBLIC",
            "PUT",
            "QUIT",
            "READ",
            "REAL",
            "RECORD",
            "RECOVER",
            "RED ",
            "RELATIVE",
            "RENAME",
            "REOPTIMIZATION",
            "REPEATABLE",
            "REPORT",
            "RESOURCE",
            "RETURN",
            "RETURNING",
            "REVERSE",
            "REVOKE",
            "RIGHT",
            "ROLLBACK",
            "ROLLFORWARD",
            "ROW",
            "ROWS",
            "RUN",
            "SCHEMA",
            "SCREEN",
            "SCROLL",
            "SECOND",
            "SELECT",
            "SERIAL",
            "SET",
            "SFMT",
            "SHARE",
            "SHIFT",
            "SHOW",
            "SIGNAL ",
            "SIZE",
            "SKIP",
            "SLEEP",
            "SOME",
            "SPACE",
            "SPACES",
            "SQL",
            "SQLERRMESSAGE",
            "SQLERROR",
            "SQLSTATE",
            "STABILITY",
            "START",
            "STATISTICS",
            "STEP",
            "STOP",
            "STYLE",
            "SUM",
            "SYNONYM",
            "TABLE",
            "TEMP",
            "TERMINATE",
            "TEXT",
            "THEN",
            "THROUGH",
            "THRU",
            "TO",
            "TODAY",
            "TOP",
            "TRAILER",
            "TRANSACTION ",
            "UNBUFFERED",
            "UNCONSTRAINED",
            "UNDERLINE",
            "UNION",
            "UNIQUE",
            "UNITS",
            "UNLOAD",
            "UNLOCK",
            "UP",
            "UPDATE",
            "USE",
            "USER",
            "USING",
            "VALIDATE",
            "VALUE",
            "VALUES",
            "VARCHAR",
            "VIEW",
            "WAIT",
            "WAITING",
            "WARNING",
            "WHEN",
            "WHENEVER",
            "WHERE",
            "WHILE",
            "WINDOW",
            "WITH",
            "WITHOUT",
            "WORDWRAP",
            "WORK",
            "WRAP"
            ),
        2 => array(
            '&AMP;IFDEF', '&AMP;ENDIF'
            ),
        3 => array(
            "ARRAY",
            "BYTE",
            "CHAR",
            "CHARACTER",
            "CURSOR",
            "DATE",
            "DATETIME",
            "DECIMAL",
            "DOUBLE",
            "FALSE",
            "INT",
            "INTEGER",
            "SMALLFLOAT",
            "SMALLINT",
            "STRING",
            "TIME",
            "TRUE"
            ),
        4 => array(
            "BLACK",
            "BLINK",
            "BLUE",
            "BOLD",
            "ANSI",
            "ASC",
            "ASCENDING",
            "ASCII",
            "CYAN",
            "DESC",
            "DESCENDING",
            "GREEN",
            "MAGENTA",
            "OFF",
            "WHITE",
            "YELLOW",
            "YEAR",
            "DAY",
            "MONTH",
            "WEEKDAY"
            ),
        ),
    'SYMBOLS' => array(
        '+', '-', '*', '?', '=', '/', '%', '>', '<', '^', '!', '|', ':',
        '(', ')', '[', ']'
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => true,
        1 => false,
        2 => false,
        3 => false,
        4 => false,
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            1 => 'color: #0600FF;',
            2 => 'color: #0000FF; font-weight: bold;',
            3 => 'color: #008000;',
            4 => 'color: #FF0000;',
            ),
        'COMMENTS' => array(
            1 => 'color: #008080; font-style: italic;',
            2 => 'color: #008080;',
            'MULTI' => 'color: #008080; font-style: italic;'
            ),
        'ESCAPE_CHAR' => array(
            0 => 'color: #008080; font-weight: bold;'
            ),
        'BRACKETS' => array(
            0 => 'color: #000000;'
            ),
        'STRINGS' => array(
            0 => 'color: #808080;'
            ),
        'NUMBERS' => array(
            0 => 'color: #FF0000;'
            ),
        'METHODS' => array(
            1 => 'color: #0000FF;',
            2 => 'color: #0000FF;'
            ),
        'SYMBOLS' => array(
            0 => 'color: #008000;'
            ),
        'REGEXPS' => array(
            ),
        'SCRIPT' => array(
            )
        ),
    'URLS' => array(
        1 => '',
        2 => '',
        3 => '',
        4 => ''
        ),
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => array(
        1 => '.'
        ),
    'REGEXPS' => array(
        ),
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => array(
        ),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        )
);

?>
