<div class="users index">
    <h2><?php echo 'Nexseed Members!! Now total '.$total.' people!!' ?></h2>

    <?php
    /**
     * Filter Function
     */
        echo $this->Form->create('Sort');
        echo $this->Form->input(
            'group_id',
            array(
                'options' => array(
                    '0' => 'ALL',
                    '1' => 'STUDENT',
                    '2' => 'TEACHER',
                    '3' => 'STAFF'
                ),
            )
        );
        echo $this->Form->end(__('Filter'));
    ?>

    <?php foreach ($users as $user): ?>
    <a href="users/view/<?php echo $user['User']['id'] ?>">
    
    <div class="col3">
        <p class="pic"><?php echo $this->Upload->uploadImage($user, 'User.img', array('style' => 'thumb')) ?></p>
        <p class="nickname"><?php echo h($user['User']['nickname']); ?></p>
        <p class="name"><?php echo h($user['User']['name']); ?></p>

        <p class="group">
        <?php
        if ($user['User']['group_id'] == '1') {
            echo '<font color="blue">STUDENT</font>';
        } else if ($user['User']['group_id'] == '2'){
            echo '<font color="red">TEACHER</font>';
        } else if ($user['User']['group_id'] == '3'){
            echo '<font color="green">STAFF</font>';
        }
        ?>
        </p>

        <?php list($year, $mon, $day) = explode('-', $user['User']['birthday']) ?>
        <p class="birthday">BIRTHDAY: <?php echo date('M.d', strtotime($user['User']['birthday'])); ?></p>
        <p class="graduating_date">GRADUATE: <?php echo date('M.d.Y', strtotime($user['User']['graduating_date']))?></p>
        <p class="hobby">HOBBY: <?php echo h($user['User']['hobby']); ?></p>
        <p class="introduce"><?php echo h($user['User']['introduce']); ?></p>
    </div>
    </a>

    <?php endforeach; ?>

    <div class="clear"></div>

    <?php
        echo $this->Paginator->counter(array('format' => 'TOTAL:{:count} | SHOWING:{:current} | ' ));
        echo $this->Paginator->counter(array('format' => 'PAGE:{:page}/{:pages}'));
    ?>  </p>
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
