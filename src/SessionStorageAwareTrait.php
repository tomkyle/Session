<?php
/**
 * This file is part of tomkyle/tomkyle/core
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle\Session;


/**
 * SessionStorageAwareTrait
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
trait SessionStorageAwareTrait
{

/**
 * @var SessionStorageInterface
 */
    protected $session_storage;

/**
 * @param  SessionStorageInterface $session
 * @uses   $session_storage
 */
    public function setSessionStorage(SessionStorageInterface $session)
    {
        $this->session_storage = $session;
        return $this;
    }


/**
 * @return SessionStorageInterface
 * @uses   $session_storage
 */
    public function getSessionStorage()
    {
        return $this->session_storage;
    }


}
