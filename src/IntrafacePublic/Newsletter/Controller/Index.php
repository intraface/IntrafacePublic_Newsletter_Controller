<?php
require_once 'get_ip_address.php';

class IntrafacePublic_Newsletter_Controller_Index extends k_Controller
{
    private $form;

    private function getForm()
    {
        if ($this->form) {
            return $this->form;
        }
        $this->form = new HTML_QuickForm('newsletter', 'POST', $this->url());
        $this->form->addElement('text', 'email', $this->__('Email'));
        $radio[0] =& HTML_QuickForm::createElement('radio', null, null, $this->__('subscribe'), '1');
        $radio[1] =& HTML_QuickForm::createElement('radio', null, null, $this->__('unsubscribe'), '2');
        $this->form->addGroup($radio, 'mode', null, null);
        $this->form->addElement('submit', null, $this->__('Save'));
        $this->form->setDefaults(array('mode' => 1));
        $this->form->addRule('email', $this->__('You have to supply an email address'), 'required', null);
        return $this->form;
    }

    public function POST()
    {
        if ($this->getForm()->validate()) {
            $client = $this->registry->get('newsletter');
            if ($this->POST['mode'] == 1) {
                if ($client->subscribe(14, $this->POST['email'], get_ip_address(''))) {
                    $msg = '<p class="notice">' . $this->__('You have now subscribed to the newsletter.') . '</p>';
                } else {
                    $msg = '<p class="alert">' . $this->__('An error occured. You could not subscribe.') . '</p>';
                }
            } elseif ($this->POST['mode'] == 2) {
                if ($client->unsubscribe(14, $this->POST['email'], get_ip_address())) {
                    $msg = '<p class="notice">' . $this->__('You have unsubscribed from the newsletter.') . '</p>';
                } else {
                    $msg = '<p class="alert">' . $this->__('An error occured. You could not be removed from the newsletter.') . '</p>';
                }
            }
            return '<h1>' . $this->__('Newsletter') . '</h1>' . $msg;
        } else {
            return '<h1>' . $this->__('Newsletter') . '</h1>' . $this->getForm()->toHTML();
        }
    }

    public function GET()
    {
        return '<h1>' . $this->__('Newsletter') . '</h1>
            <p>' . $this->__('Information about the newsletter.') . '</p>
            ' . $this->getForm()->toHTML();
    }
}