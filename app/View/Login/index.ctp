<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Bitte Benutzername und Passwort eingeben'); ?>
        </legend>
    	<?php 
	        echo $this->Form->input('username', array('label' => 'Benutzername', 'type' => 'text'));
        	echo $this->Form->input('password', array('label' => 'Passwort'));
    	?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>