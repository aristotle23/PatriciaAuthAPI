# PatriciaAuthAPI
Patricia's API-based Authentication System

Click on the link below to get full documation of this API <br />
https://documenter.getpostman.com/view/8252746/SW7W5pp8

Within the Object directory, Classes named with `_v5` indicates it support `PHP >= 5.*.*` but uses weaker hash and 
authentication method. 

Class without `_v5` uses hash and authentication method introduced in `PHP 7.*.*` so it will not work on `PHP 5.*.*`.

<b>The Default classes only support `PHP 7.*.*`</b>

To switch from `PHP 7.*.*` to `PHP >= 5.*.*` supported clases, rename `User.php -> User_V7.php` then rename 
`User_v5.php -> User.php`. Same goes for `Token.php`.

<b>Object/DbHandler.php</b> <br />This class is a wrapper class for PDO object. It removes the hassle of database connectivity
and controls.
