<?php
/**
 * User: mlecz
 * Date: 01.02.2017
 * Time: 15:12
 */

namespace Application\Service;

use Zend\Mail\Exception\RuntimeException;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

class MailService
{
    public function send() {
        $mail = new Message();
        $mail->setFrom('mleczko.pawel1@gmail.com', 'Paweł Mleczko');
        $mail->setTo('pawel.mleczko@mediaflex.pl', 'Paweł');
        $mail->setReplyTo('mleczko.pawel1@gmail.com', 'admin');
        $mail->setSubject('Test');
        $mail->setBody('To jest mail testowy');

        $transport = new Sendmail();
        try {
            $transport->send($mail);
            return true;
        } catch (RuntimeException $exception) {
            return false;
        }
    }
}