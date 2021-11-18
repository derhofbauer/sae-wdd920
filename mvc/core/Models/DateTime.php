<?php

namespace Core\Models;

/**
 * Wir erweitern hier die von PHP mitgelieferte \DateTime-Klasse.
 */
class DateTime extends \DateTime
{
    /**
     * Um möglichst nah an der erweiterten Klasse zu sein, definieren wir eine Klassenkonstante für das Ausgabeformat.
     */
    const MYSQL_DATETIME = 'Y-m-d H:i:s';

    /**
     * Was soll ausgegeben werden, wenn das Objekt in einen String konvertiert werden soll?
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format(self::MYSQL_DATETIME);
    }

}
