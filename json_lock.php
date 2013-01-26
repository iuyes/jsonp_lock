<?php
/*
Copyright (c) 2013 J. Ryan Littlefield

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do 
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

$key = $_REQUEST['key'];
$action = $_REQUEST['action'];
$who = $_REQUEST['who'];

$callback = $_REQUEST['callback'];

$db = new PDO('sqlite:/tmp/weblocks.sq3');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$now = gmdate('Y-m-d H:i:s');
if ($key && $who && $action) {

	if ($action == 'acquire') {
		$sql = "INSERT OR IGNORE INTO weblocks (key, who, acquired_datetime) VALUES(:key, :who, :now) ";
	} else if ($action == 'release') {
		$sql = "DELETE FROM weblocks WHERE key = :key AND who = :who";
	}
	$query = $db->prepare($sql);

	$query->bindParam(':key', $key);
	$query->bindParam(':who', $who);
	if ($action == 'acquire') {
		$query->bindParam(':now', $now);
	}
	$result = $query->execute();
	$row_count = $query->rowCount();
	
	$success = $row_count == 1;
}

if ($action == 'init') {
	$sql = "create table if not exists weblocks(key TEXT PRIMARY KEY, who TEXT, acquired_datetime TEXT)";
	$query = $db->prepare($sql);
	$query->execute();
}

echo $callback.'('.json_encode($success).');';


