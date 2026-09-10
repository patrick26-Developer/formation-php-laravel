<?php

/*
 * A: XSS VULNERABILITY.
 * $_GET['nom'] is echoed straight into the HTML without htmlspecialchars().
 * An attacker can pass ?nom=<script>...</script> to run JS.
 *
 * B: NO VULNERABILITY.
 * Prepared statement: $_GET['id'] is passed separately via execute(),
 * never concatenated into the SQL text. This is the pattern to always follow.
 *
 * C: SQL INJECTION VULNERABILITY.
 * $_GET['nom'] is concatenated directly into the query text.
 * An attacker can pass ?nom=' OR '1'='1 to manipulate the query.
 *
 * D: NO VULNERABILITY (for the display).
 * htmlspecialchars() correctly escapes the data before HTML output.
 */
