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
    public function send($data, $translator)
    {
        $mail = new Message();
        $mail->setEncoding("UTF-8");
        $mail->setBody($translator->translate('Zarejestrowany użytkownik', 'default', LOCALE) . ' ' . $translator->translate('kliknij link aby potwierdzić', 'default', LOCALE) . ' ' . $this->host() . LOCALE . '/auth/check/' . $data['token'] . '/' . $data['id'])
            ->setFrom('admin@mleczkop.nazwa.pl')
            ->addTo($data['email'])
            ->setSubject($translator->translate('Witamy', 'default', LOCALE));
        $transport = new Sendmail('admin@mleczkop.nazwa.pl');
        try {
            $transport->send($mail);
            return true;
        } catch (RuntimeException $exception) {
            return false;
        }
    }

    public function resetPassword($data, $translator)
    {
        $mail = new Message();
        $mail->setEncoding("UTF-8");
        $mail->setBody($translator->translate('Resetujemy hasło', 'default', LOCALE) . '... ' . $translator->translate('kliknij link aby zresetować', 'default', LOCALE) . ' ' . $this->host() . LOCALE . '/auth/resetPass/' . $data['token'] . '/' . $data['id'])
            ->setFrom('admin@mleczkop.nazwa.pl')
            ->addTo($data['email'])
            ->setSubject($translator->translate('Witamy', 'default', LOCALE));
        $transport = new Sendmail('admin@mleczkop.nazwa.pl');
        try {
            $transport->send($mail);
            return true;
        } catch (RuntimeException $exception) {
            return false;
        }
    }

    private function host()
    {
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $baseurl = "http://" . $host . $path . "/";
        return $baseurl;
    }
}