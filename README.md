jsonp_lock
==========

Quick and dirty PHP script that lets you acquire and release a "lock" through HTTP with jsonp.

Requires: PDO, sqlite3, and probably PHP 5.something.

Usage: http://[site]/json_lock.php?action=acquire&key=ryan&who=ryan&callback=foo
Output: foo(true);

The "action" parameter will be either "acquire" or "release".
The "key" parameter should identify the resource you which to lock. It could be anything, but probably should be the shortest unique ID for your resource.
The "who" parameter is to prevent someone other than the lock holder from releasing the lock.
The "callback" parameter is optional and intended for jsonp purposes. Consult your jsonp library on what to use for it.

You will probably want to adjust the location of the sqlite3 database file.

----

Why not build the lock support into your app? Isn't this a waste of code? The main use case I have for this is when you can add some javascript to a page but don't control the app itself (think javascript bookmarklet).
