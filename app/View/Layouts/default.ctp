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
                    if ($loginUser['role'] == 0) {
                        echo '<p style="font-size:16px;color:yellow;font-weight:bold;">You are not approved, please wait.</p>';
                    }
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

        <div id="content">
            <?php if(isset($loginUser) && $loginUser['role'] != 0) { ?>
			<div class="main">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
			</div>

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
                if(isset($loginMyParticipantEvents)):
                foreach((array)$loginMyParticipantEvents as $event):
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

            <div id="minicalendar">
			<?php foreach ($events as $event) {
				$eventDate = $event['Event']['open_datetime'];
				list($eventYear, $eventMon, $eventDay) = explode("-", $eventDate); 
				$eventDate = substr("$eventDay", 0, 2);
				$eventDates[] = array("Year"=>$eventYear,"Month"=>$eventMon,"date"=>$eventDate);

			}
			?>
			<?php

				$year = date('Y');
				$month = date('n');
				$monNum = date('m');

				$last_day = date('j', mktime(0, 0, 0, $month+1, 0, $year));

				$calendar = array();
				$j = 0;
				for ($i = 1; $i < $last_day + 1; $i++) {
				    $week = date('w', mktime(0, 0, 0, $month, $i, $year));

					
				    if ($i == 1) {
				        for ($s = 1; $s <= $week; $s++) {
				            $calendar[$j]['day'] = '';
				            $j++;
				        }
				    }

				    $calendar[$j]['day'] = $i;
				    $j++;

				    if ($i == $last_day) {
				 
				        for ($e = 1; $e <= 6 - $week; $e++) {
				
				            $calendar[$j]['day'] = '';
				            $j++;
				 
				        }
				    }
				}
				
				?>
				
				<?php echo date('F'); ?>/<?php echo $year; ?>
				<br>
				<br>
				<table style="width: 78px;" >

				    <tr>
				        <th>Sun</th>
				        <th>Mon</th>
				        <th>Tue</th>
				        <th>Wed</th>
				        <th>Thu</th>
				        <th>Fri</th>
				        <th>Sat</th>
				    </tr>
				    <tr>
				    <?php $cnt = 0; ?>
				    <?php foreach ($calendar as $key => $value): ?>
				        <td>
				        <?php $cnt++; ?>

				        <?php
				        $flg = false;
				        for ($i = 0; $i < count($eventDates); $i++) {
				        	if($monNum == $eventDates[$i]['Month'] && $year == $eventDates[$i]['Year'] && $value['day'] ==$eventDates[$i]['date']) {
				         echo $this->Html->link($value['day'], '/events/index/'.$loginUser['id']);
				         	$flg = true;
				     		}	
						}
						if (!$flg) {
							echo $value['day'];
						}

				     ?>
				        </td>
				    <?php if ($cnt == 7): ?>
				    </tr>
				    <tr>
				    <?php $cnt = 0; ?>
				    <?php endif; ?>
				 
				    <?php endforeach; ?>
				    </tr>
				</table>
				
				<style type="text/css">
				table {
				    width: 80%;
				}
				table th {
				    background: #EEEEEE;
				}
				table th,
				table td {
					width: 10px;
				    border: 1px solid #CCCCCC;
				    text-align: center;
				    font-size: 5px;
				    padding: 5px;
				}
				</style>

			</div><!--minicalendar-->

            </div>
            <?php 
            } else { ?>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
            <?php } ?>
        </div><!--/container-->

		<div id="footer">
            <p align="center">SEED POD@inc All Right Reserved</p>
		</div>
	</div>

<script>
$(function(){
	setTimeout(function(){
		$('#flashMessage').fadeOut("slow");
	},800);
});
</script>

</body>
</html>
