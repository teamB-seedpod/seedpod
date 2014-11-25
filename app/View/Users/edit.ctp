<div class="users form">
<?php echo $this->Form->create('User', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>

    <?php
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('name');
        echo $this->Form->input('nickname');
        
        echo $this->Form->input(
            'group_id',
            array(
                'label' => 'Group',
                'options' => array(
                    '1' => 'STUDENT',
                    '2' => 'TEACHER',
                    '3' => 'STAFF'
                )
            )
        );

        echo $this->Upload->uploadImage($user, 'User.img', array('style' => 'thumb'));
        echo $this->Form->input(
            'img',
            array(
                'type' => 'file',
                'label' => 'Picture'
            )
        );

        echo $this->Form->input(
            'birthday',
            array(
                'minYear' => date('Y') - 80,
                'maxYear' => date('Y')
            )
        );

        echo $this->Form->input(
            'coming_date',
            array(
                'minYear' => date('Y') - 20,
                'maxYear' => date('Y') + 20
            )
        );
        echo $this->Form->input(
            'graduating_date',
            array(
                'minYear' => date('Y') - 20,
                'maxYear' => date('Y') + 20
            )
        );

        echo $this->Form->input('hobby');

        echo $this->Form->input(
            'introduce',
            array(
                'type' => 'textarea'
            )
        );
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

