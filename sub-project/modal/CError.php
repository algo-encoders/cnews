<?php

namespace CNEWS;

class CError
{
    private $code;
    private $message;
    private $default_message = 'There is a problem with request please try again letter';
    private $messages_list;

    /**
     * @param $code
     * @param $message
     */
    public function __construct($code)
    {
        $this->messages_list = \CNEWS\CNotices::$messages_list;
        $this->code = $code;
        $this->message = cnews_get_value($code, $this->messages_list, $this->default_message);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

}