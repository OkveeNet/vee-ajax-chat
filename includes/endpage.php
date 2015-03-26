<?php

if (@$footerpage != "custom") {
	include(_THEME_PATH_."overall-footer.php");
}

/* real end page */##########
if (isset($db)) {
	$db->close();
	$db->disconnect();
}

ob_end_flush();

?>