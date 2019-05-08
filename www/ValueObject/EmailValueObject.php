<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 23:17
 * source : https://blog.sznapka.pl/immutable-value-objects-in-php/.
 */

namespace ValueObject;

final class EmailValueObject
{
    private $mailbox;
    private $host;

    public function __construct(string $email)
    {
        //Security the form already check if the @ is in the mail
        if (false === strpos($email, '@')) {
            throw new \InvalidArgumentException('This does not look like an email 1');
        }
        //Check the pattern xxx@xxx.xx
        if (false === filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('This does not look like an email 2');
        }
        $arrayEmail = explode('@', $email);

        $emailDotCut = explode('.', $arrayEmail[1]);
        $lastDot = end($emailDotCut);

        //Check the length of the text after the dot
        if (strlen($lastDot) < 2 || strlen($lastDot) > 3) {
            throw new \InvalidArgumentException('This does not look like an email 3');
        }

        //Some ref can be blocked ****** EXTRA BONUS *******
        $blockRefArray = array('io');

        if (in_array($lastDot, $blockRefArray)) {
            throw new \InvalidArgumentException('You can register with this ref');
        }

        $this->mailbox = $arrayEmail[0];
        $this->host = $arrayEmail[1];
    }

    public function __toString(): string
    {
        return sprintf('%s@%s', $this->mailbox, $this->host);
    }

    public function changeMailbox(EmailValueObject $newMail): string
    {
        $arrayEmail = explode('@', $newMail);

        $this->mailbox = $arrayEmail[0];
        $this->host = $arrayEmail[1];

        return (string) $this->mailbox.'@'.$this->host;
    }
}
