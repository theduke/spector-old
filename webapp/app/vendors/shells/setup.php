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
 
class SetupShell extends Shell
{
  public function main()
  {
    App::import('Model', 'User');
    App::import('Core', 'Security');
    
    $user = new User();
    $user->set('username', 'admin');
    $user->set('password', Security::hash('admin', null, true));
    
    $user->save();
    
    $this->out('Admin user created.');
  }
}