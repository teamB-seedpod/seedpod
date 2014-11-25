<div class="main">
    <h2>Let's Join SEEDPOD!</h2>
    <h3>This service only for Nexseed Students, Teachers, Staffs.</h3>
    <h2><a href="/seedpod/users/add">SIGN UP NOW!</a></h2>
</div>

<div class="leftside">
    <div class="users form">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Login'); ?></legend>
        <?php echo $this->Form->input('email');
        echo $this->Form->input('password');
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>               
</div>
