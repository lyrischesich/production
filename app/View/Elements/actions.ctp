<div class="span2">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
		<li class="nav-header">Aktionen</li>
		<?php foreach($actions as $action){ 
			echo "<li>";
			echo $this->Html->link($action['text'],$action['params']);
			echo "</li>";			
		}
		?>
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
			echo "</li>";
		} 
		?>
		</ul>	
	</div>
</div>
<div class="span9">