<li class="nav-header">
	Statische Aktionen
</li>
<?php 
	if (AuthComponent::user('id')) {
		echo "<li>";
		echo $this->Html->link('Logout',array(
			'controller' => 'login',
			'action' => 'logout'	
			));
	} 
?>