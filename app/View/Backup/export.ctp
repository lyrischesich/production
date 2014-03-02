<?php 
header('Content-Disposition: attachment; filename=Sicherung_Cafeteria_'.date('d_m_Y', time()).'.sql');
header('Content-type: text/plain');

echo $dump;
?>