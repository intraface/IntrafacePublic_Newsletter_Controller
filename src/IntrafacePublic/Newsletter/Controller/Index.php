<?php
require_once 'get_ip_address.php';

class IntrafacePublic_Newsletter_Controller_Index extends k_Component
{
    protected $template;
    protected $client;

    function __construct(IntrafacePublic_Newsletter_Client_XMLRPC $client, k_TemplateFactory $template)
    {
        $this->template = $template;
        $this->client = $client;
    }

    public function renderHtml()
    {
        $this->document->setTitle('Newsletter');

        $data = array();
        $tpl = $this->template->create('IntrafacePublic/Newsletter/templates/details');
        return $tpl->render($this, $data);
    }

    public function postForm()
    {
        $data = $this->body();
        if (!Validate::email($this->body('email'))) {
            $data['message'] = 'An error occured. E-mail is not valid.';
        } else {

            if ($this->body('mode') == 1) {
                if ($this->client->subscribe($this->body('email'), $this->body('name'), get_ip_address(''))) {
                    $data = array();
                    $data['message'] = 'You have now subscribed to the newsletter.';
                } else {
                    $data['message'] = 'An error occured. You could not subscribe.';
                }
            } elseif ($this->body('mode') == 2) {
                if ($this->body('comment')) {
                    $comment = $this->body('comment');
                } else {
                    $comment = '';
                }
                if ($this->client->unsubscribe($this->body('email'), $comment)) {
                    $data = array();
                    $data['message'] = 'You have unsubscribed from the newsletter.';
                } else {
                    $data['message'] = 'An error occured. You could not be removed from the newsletter.';
                }
            }
        }

        return $this->render();
    }
}