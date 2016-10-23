<?php

namespace Rocket\APIBundle\Exception;

class APIError {
    /**
     * @apiGroup APIError: General
     * @apiVersion 1.0.2
     *
     * @apiError  108 Wrong parameter value
     *
     */
    const WRONG_VALUE           = 108;

    protected $code;
    protected $message;

    protected $subCode;
    protected $subMessage;

    function __construct($code, $message, $subCode = null, $subMessage = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->subCode = $subCode;
        $this->subMessage = $subMessage;
    }

    /**
     * @param mixed $code
     * @return APIError
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $message
     * @return APIError
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $subCode
     * @return APIError
     */
    public function setSubCode($subCode)
    {
        $this->subCode = $subCode;
        return $this;
    }

    /**
     * @return null
     */
    public function getSubCode()
    {
        return $this->subCode;
    }

    /**
     * @param null $subMessage
     * @return APIError
     */
    public function setSubMessage($subMessage)
    {
        $this->subMessage = $subMessage;
        return $this;
    }

    /**
     * @return null
     */
    public function getSubMessage()
    {
        return $this->subMessage;
    }


    public function toJson()
    {
        $result = array(
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        );

        if($this->getSubCode()) {
            $result['subCode'] = $this->getSubCode();
        }

        if($this->getSubMessage()) {
            $result['subMessage'] = $this->getSubMessage();
        }

        return $result;
    }
}
