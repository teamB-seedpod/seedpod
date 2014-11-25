<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$nowtime = date("Y-m-d H:i:s");

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->Html->css('common.css');

        if($this->name == 'Users') {
            echo $this->Html->css('user.css');
        }

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

</head>
<body>

	<div id="container">
		<div id="header">

            <?php echo '<a href="/seedpod/"><img src="/seedpod/img/logo_small.png"></a>'; ?>
            <div style="float:right;padding:10px;">
            <?php
                if(isset($loginUser)):
                    echo 'Welcome ';
                    echo h($loginUser['name']);
                    echo '! ';
                    echo $this->Html->link('LOGOUT', '/users/logout');
                else:
                    echo $this->Html->link('LOGIN', '/users/login');
                    echo ' ';
                    echo $this->Html->link('SIGN UP', '/users/add');
                endif;
            ?>
            </div>
		</div>
		<div id="content">
			<div class="main">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
			</div>

            <?php if(isset($loginUser)): ?>
            <div class="leftside">
            <div class="myprofile">
                <div class="profile">
			        <?php echo $this->Upload->uploadImage($loginUser, 'User.img', array('style'=>'thumb')); ?>
                    <h2><?php echo $loginUser['nickname'] ?></h2>
                </div>

                <?php echo '<p><a href="/seedpod/users/view/'.$loginUser['id'].'"><img src="/seedpod/img/human.png" width="13px">View User</a>'; ?>
                <?php echo ' <a href="/seedpod/users/edit/'.$loginUser['id'].'"><img src="/seedpod/img/gross.png" width="13px">Edit User</a></p>'; ?>
            </div>

            <div class="myevent">
                <h3>Your Future Event</h3>
                <h4>Owner Event</h4>
                <?php 
                foreach((array)$loginMyOwnerEvents as $event):
                    if($event['Event']['open_datetime'] > $nowtime):
                        echo '<li><a href="/seedpod/events/detail/'.$event['Event']['id'].'">'.$event['Event']['title'].'('.count($event['Participant']).')</a></li>';
                    endif;
                endforeach;
                ?>

                <h4>Participant Event</h4>
                <?php 
                foreach((array)$loginMyParticipantEvents as $event):
                    if($event['Event']['open_datetime'] > $nowtime):
                        echo '<li><a href="/seedpod/events/detail/'.$event['Event']['id'].'">'.$event['Event']['title'].'('.count($event['Participant']).')</a></li>';
                    endif;
                endforeach;
                ?>

                <h4>Invited Event</h4>
                <?php
                if(isset($loginMyInvitedEvents)):
                foreach((array)$loginMyInvitedEvents as $event):
                    if($event['Event']['open_datetime'] > $nowtime):
                        echo '<li><a href="/seedpod/events/detail/'.$event['Event']['id'].'">'.$event['Event']['title'].'('.count($event['Participant']).')</a></li>';
                    endif;
                endforeach;
                endif;
                ?>

            </div>

			<div class="actions">
			    <h3><?php echo __('Menu'); ?></h3>
			    <ul>
				    <li><?php echo $this->Html->link('Create Event', '/events/create/'); ?></li>
				    <li><?php echo $this->Html->link('Profile List', '/users/index/'); ?></li>
                </ul>

            </div>
            </div>
        </div><!--/container-->
		<div id="footer">
            <p align="center">SEED POD@inc All Right Reserved</p>
		</div>
	</div>
<?php endif; ?>

<script>
$(function(){
	setTimeout(function(){
		$('#flashMessage').fadeOut("slow");
	},800);
});
</script>

</body>
</html>
