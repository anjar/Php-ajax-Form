PHP-Ajax-Form
=================
<h2> Installation </h2>
<ul>
	<li>Extract File</li>
	<li>Put your folder on your webhost e.g xampp/htdocs</li>
	<li>Open /include/Config.php <br>
		and then edit the following lines: <br>
		<pre>define('BASE_URL', 'http://localhost/contact-form/'); </pre>
		to your base url <br>
		and configure your database connection at var $config variable section <br>
		<pre>
		var $config = array(
			'host' 		=> 'localhost',
			'db'		=> 'contact',
			'login'		=> 'root',
			'password'	=> '',
			'port'		=> 3306
		);
		</pre>
	</li>
	<li>
		Create database / use existing database and then import your database with schema.sql file to your database
	</li>
	<li>
		last run at your browser
	</li>
</li>
