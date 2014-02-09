<div class="navbar navbar-inverse  navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
		<a class="brand" href="/Cafeteria">Cafeteria-Planer</a>
		<ul class="nav">
		<?php 
		if (!AuthComponent::user('id')) {
			echo "<li class='active'>
					<a href='#'>Login</a>
				</li>
			";
		} else {
			$active = $this->params['controller'];
			$aCtrlClasses = App::objects('controller');
			foreach ($aCtrlClasses as $controller) {
				if ($controller != "AppController" && $controller != "LoginController") {
					$controllerName = str_replace("Controller", "", $controller);
					$name = strtolower($controllerName);
					if ($active == $name) echo "<li class='active'>";  else  echo "<li>";				
					echo $this->Html->link($controllerName,array(
							'controller' => $name,
							'action' => 'index'
							));
					echo "</li>";
				}
			}
		}		
		?>
		</ul>
		</div>
	</div>
</div>
