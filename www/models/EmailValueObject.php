<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 23:17
 * source : https://blog.sznapka.pl/immutable-value-objects-in-php/
 */

namespace Models;


final class EmailValueObject
{
    private $mailbox;
    private $host;

    public function __construct(string $email)
    {
        if (false === strpos($email, '@')) {
            throw new \InvalidArgumentException('This does not look like an email');
        }
        $arrayEmail = explode('@', $email);

        $this->mailbox = $arrayEmail[0];
        $this->host = $arrayEmail[1];
    }

    public function __toString()
    {
        return sprintf('%s@%s', $this->mailbox, $this->host);
    }

    public function changeMailbox(EmailValueObject $newMail)
    {
        //$copy = clone $this;
        //$copy->mailbox = $newMail;

        $arrayEmail = explode('@', $newMail);

        $this->mailbox = $arrayEmail[0];
        $this->host = $arrayEmail[1];

        return $this->mailbox.'@'.$this->host;
    }
}