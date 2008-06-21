<?php
require_once 'config.local.php';

set_include_path(INTRAFACEPUBLIC_SHOP_INCLUDE_PATH);

require_once 'k.php';
require_once 'Ilib/ClassLoader.php';

class Newsletter_Root extends k_Dispatcher
{
    public $map = array('newsletter' => 'IntrafacePublic_Newsletter_Controller_Index');

    function execute()
    {
        throw new k_http_Redirect($this->url('newsletter'));
    }
}

$application = new Newsletter_Root();
$application->registry->registerConstructor('newsletter', create_function(
  '$className, $args, $registry',
  '//$session_id = $registry->SESSION->getSessionId();
   $session_id = session_id();
   return new IntrafacePublic_Newsletter_XMLRPC_Client(array("private_key" => INTRAFACE_PRIVATE_KEY, "session_id" => md5($session_id)), true, INTRAFACE_XMLRPCSERVER);'
));
$application->dispatch();