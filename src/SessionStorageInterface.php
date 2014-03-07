<?php
/**
 * This file is part of tomkyle/tomkyle/core
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle\Session;

/**
 * SessionStorageInterface
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
interface SessionStorageInterface extends \ArrayAccess
{
	public function setNamespace($session_id);
	public function getNamespace();


}
