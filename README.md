Santa Is Talking
====================
This is an implementation of IVR using  [Africa's talking](https://www.africastalking.com/) API.

How to set up
----------------

1. Clone the repository
2. Create an account with [Africa's talking](https://account.africastalking.com/register)
3. Install [Redis](http://redis.io) and [Predis](https://github.com/nrk/predis) You can read a [tutorial](http://www.sitepoint.com/an-introduction-to-redis-in-php-using-predis/)
4. On your Africa's talking acccount, set your call back url to http://yoursever/santa.php
5. Change `santa.php` around line 33  and add `https://yourserver/wishlist.php`
6. Africa is talking will assign you a number that you can use. So change `includes/utils.php` and add your `aitusername`, `aitkey` and `aitnumber`
6. So, to talk to santa, just call the number africa is talking gave you. He will call you back and you will get to tell him what you want for christmas