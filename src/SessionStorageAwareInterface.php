<?php
/**
 * This file is part of tomkyle/tomkyle/core
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle\Session;


/**
 * SessionStorageAwareInterface
 *
 * @author Carsten Witt <tomkyle@posteo.de
 */
interface SessionStorageAwareInterface
{

	public function setSessionStorage( SessionStorageInterface $session );

	public function getSessionStorage();

}
