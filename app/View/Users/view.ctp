<div class="users view">
<h2><?php echo 'Benutzer'; ?></h2>
	<dl><table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
		<dt><?php echo 'Benutzername'; ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Fname'; ?></dt>
		<dd>
			<?php echo h($user['User']['fname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Lname'; ?></dt>
		<dd>
			<?php echo h($user['User']['lname']); ?>
			&nbsp;
		</dd>
		<!--<dt><?php echo 'Passwort'; ?></dt>
		<dd>
			<?php echo h($user['User']['passwd']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo 'Telefonnummer 1'; ?></dt>
		<dd>
			<?php echo h($user['User']['tel1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Telefonnummer 2'; ?></dt>
		<dd>
			<?php echo h($user['User']['tel2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'E-Mail Adresse'; ?></dt>
		<dd>
			<?php echo h($user['User']['mail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Ausstiegsdatum'; ?></dt>
		<dd>
			<?php echo h($user['User']['leave_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Mo'; ?></dt>
		<dd>
			<?php echo h($user['User']['mo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Di'; ?></dt>
		<dd>
			<?php echo h($user['User']['di']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Mi'; ?></dt>
		<dd>
			<?php echo h($user['User']['mi']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Do'; ?></dt>
		<dd>
			<?php echo h($user['User']['do']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Fr'; ?></dt>
		<dd>
			<?php echo h($user['User']['fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Administrator'; ?></dt>
		<dd>
			<?php echo h($user['User']['admin']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
</div>
