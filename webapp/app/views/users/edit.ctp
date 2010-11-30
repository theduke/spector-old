<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Christoph Herzog <christoph.herzog@theduke.at>
 * @copyright Crevo
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 */
 
?>
<div class="users form">
<?php echo $form->create('User' , array( 'type' => 'post' ));?>
  <fieldset>
    <legend><?php __('Add User');?></legend>
  <?php
    echo $form->input('User.username');
    echo $form->input('User.password');
    echo $form->input('password_confirm');
    echo $form->input('User.email');
  ?>
  </fieldset>
<?php echo $form->end('Submit');?>
</div>