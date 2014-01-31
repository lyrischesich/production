<div class="users form">
<?php 
echo $this->Session->flash('auth');
echo $abc;
echo ('bla'.$eingelogt); 
?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Bitte Benutzernamen und Passwort eingeben'); ?>
        </legend>
    <?php 
        echo $this->Form->input('username', array('type' => 'text', "label" => "Benutzername", 'required' => true));
        echo $this->Form->input('passwd', array("label" => "Passwort", 'required' => true));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Anmelden')); ?>
</div>