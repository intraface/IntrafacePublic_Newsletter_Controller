<?php
require_once 'config.local.php';

set_include_path(dirname(__FILE__) . '/../' . PATH_SEPARATOR . get_include_path());

require_once 'k.php';

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
  'return new IntrafacePublic_Newsletter_XMLRPC_Client(array("private_key" => INTRAFACE_PRIVATE_KEY, "session_id" => md5($registry->SESSION->getSessionId())), false);'
));
$application->dispatch();