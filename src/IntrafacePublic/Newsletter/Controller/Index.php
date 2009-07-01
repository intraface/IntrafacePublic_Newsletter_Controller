<?php
require_once 'get_ip_address.php';

class IntrafacePublic_Newsletter_Controller_Index extends k_Controller
{
    
    public function POST()
    {
        $this->document->title = $this->__('Newsletter');
        
        $data = $this->POST->getArrayCopy();
        if (!Validate::email($this->POST['email'])) {
            $data['message'] = 'An error occured. E-mail is not valid.';
        } else {
            $client = $this->registry->get('newsletter');
        
            if ($this->POST['mode'] == 1) {
                if ($client->subscribe($this->POST['email'], $this->POST['name'], get_ip_address(''))) {
                    $data = array();
                    $data['message'] = 'You have now subscribed to the newsletter.';
                } else {
                    $data['message'] = 'An error occured. You could not subscribe.';
                }
            } elseif ($this->POST['mode'] == 2) {
                if ($client->unsubscribe($this->POST['email'], get_ip_address(''))) {
                    $data = array();
                    $data['message'] = 'You have unsubscribed from the newsletter.';
                } else {
                    $data['message'] = 'An error occured. You could not be removed from the newsletter.';
                }
            }
        }
        
        return $this->render('IntrafacePublic/Newsletter/templates/details-tpl.php', $data);
    }

    public function GET()
    {
        $this->document->title = $this->__('Newsletter');
        
        $data = array();
        return $this->render('IntrafacePublic/Newsletter/templates/details-tpl.php', $data);
        
        return '<h1>' . $this->__('Newsletter') . '</h1>
            <p>' . $this->__('Information about the newsletter.') . '</p>
            ' . $this->getForm()->toHTML();
    }
    
}