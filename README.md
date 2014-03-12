#tomkyle/session


[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/tomkyle/Session/badges/quality-score.png?s=a80068f1af1333ff735c22e65e949c173b7872a0)](https://scrutinizer-ci.com/g/tomkyle/Session/)

A PHP Session helper that stores session data in sub-namespaces.

    $_SESSION (PHP superglobal)
         |
         +-- SessionStorage (or derived class name)
                |
                +-- keyword (passed in instantiation)
                       |
                       +-- foo => bar
                       +-- key => value


##Example

```php
<?php
use \tomkyle\Session\SessionStorage;
use \MyNamepace\MySessionData;

class MySessionData extends SessionStorage {}

$namespace1 = new MySessionData( "keyword" );
$namespace1->foo = "bar";
$namespace1->key = "value";

$namespace2 = new MySessionData( "user" );
$namespace2->foo = "baz";
$namespace2->key = 2000;

$namespace3 = new SessionStorage( "keyword" );
$namespace3->foo = "anything";
$namespace3->key = "something";

// will both print "bar":
echo $namespace1->foo;
// compare old-school:
echo $_SESSION['MySessionData']['keyword']['foo'];

// will both print "baz":
echo $namespace2->foo;
// compare old-school:
echo $_SESSION['MySessionData']['user']['foo'];



// will both print "not the same"
echo ($namespace1->foo == $namespace2->foo)
? "samesame" : "not the same";

echo ($namespace2->foo == $namespace3->foo)
? "samesame" : "not the same";
```

