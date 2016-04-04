<?php
// Performance
$start = microtime(true);
// Performance
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<div id="header">
<div id="page_title">Thomas Brasington</div>
<div id="menu_button">Menu</div>
</div>
<div id="page_content"></div>
<div id="navigation">
<div id="navigation_close">Close</div>
<div id="navigaton_content"></div>
</div>
</body>
</html>
<?php 
$end = microtime(true);
$creationtime = ($end - $start);
printf("Page created in %.6f seconds.", $creationtime);
// Performance
?>