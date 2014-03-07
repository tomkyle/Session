<?php
/**
 * This file is part of tomkyle/tomkyle/core
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle\Session;


/**
 * SessionStorage
 *
 * Enables storing session data in a namespaced manner:
 *
 *     $_SESSION (PHPs own)
 *          |
 *          +-- SessionStorage (or derived class name)
 *                 |
 *                 +-- keyword (passed in instantiation)
 *                        |
 *                        +-- foo => bar
 *                        +-- key => value
 *
 * Example:
 *
 *     <?php
 *     class MySessionData extends SessionStorage {}
 *
 *     $namespace1 = new MySessionData( "keyword" );
 *     $namespace1->foo = "bar";
 *     $namespace1->key = "value";
 *
 *     $namespace2 = new MySessionData( "user" );
 *     $namespace2->foo = "baz";
 *     $namespace2->key = 2000;
 *
 *     $namespace3 = new SessionStorage( "keyword" );
 *     $namespace3->foo = "anything";
 *     $namespace3->key = "something";
 *
 *     // will print "bar":
 *     echo $_SESSION['MySessionData']['keyword']['foo'];
 *
 *     // will print "baz":
 *     echo $_SESSION['MySessionData']['user']['foo'];
 *
 *     // will both print "not the same"
 *     echo ($namespace1->foo == $namespace2->foo)
 *     ? "samesame" : "not the same";
 *
 *     echo ($namespace2->foo == $namespace3->foo)
 *     ? "samesame" : "not the same";
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
class SessionStorage extends \ArrayObject implements SessionStorageInterface
{

    protected $session_storage_namespace = 'DefaultSessionArrayObject';


/**
 * Pass along a Session namespace keyword.
 *
 * If none passed, `DefaultSessionArrayObject` will be used instead.
 *
 * @param string $session_keyword, default: null
 * @uses  setNamespace()
 * @uses  importSessionData()
 */
    public function __construct($session_keyword = null)
    {
        if (is_string($session_keyword)) {
            $this->setNamespace($session_keyword);
        }
        elseif (is_array($session_keyword)) {
            parent::__construct( $session_keyword );
        }
    }


/**
 * @param string $var
 * @param mixed  $value
 */

    public function __set($var, $value)
    {
        $this->offsetSet($var, $value);
    }


/**
 * @param string $var
 */
    public function __get($var)
    {
        return $this->offsetExists($var)
        ? $this->offsetGet($var)
        : null;
    }





//  ==========  Implement Interface SessionStorageInterface  ===========





/**
 * @param  string $session_id
 * @return SessionStorage
 *
 * @uses   $session_storage_namespace
 */
    public function setNamespace($session_id)
    {
        $this->session_storage_namespace = $session_id;
        $this->importSessionData();
        return $this;
    }


/**
 * @return string,null
 *
 * @uses   $session_storage_namespace
 */
    public function getNamespace()
    {
        return $this->session_storage_namespace;
    }








// ========= Override Parent methods  =========================




    public function offsetSet($var, $value)
    {
        parent::offsetSet($var, $value);
        $_SESSION[ get_called_class() ][ $this->getNamespace() ][ $var ] = $value;
    }







// ========= Getting Things Work ======================================



/**
 * Imports the session data
 *
 * @return SessionStorage Fluent Interface
 * @uses   constructSessionArray()
 */
    final protected function importSessionData()
    {
        $this->exchangeArray( $this->constructSessionArray() );
        return $this;
    }



/**
 * Creates a 'namespaced sub-array' in the Session Superglobal.
 *
 * Since "Call-time pass-by-reference has been deprecated",
 * this method returns a reference that can be used in importSessionData.
 *
 * @return array
 */
    final protected function &constructSessionArray()
    {
        $this_class_name = get_called_class();

        if (!array_key_exists( $this_class_name, $_SESSION )) {
            $_SESSION[ $this_class_name ] = array();
        }

        $session_keyword = $this->getNamespace();
        if (!array_key_exists( $session_keyword, $_SESSION[ $this_class_name ] )) {
            $_SESSION[ $this_class_name ][ $session_keyword ] = array();
        }

        return $_SESSION[ $this_class_name ][ $session_keyword ];
    }





}

