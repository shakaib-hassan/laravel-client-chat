<h1>
	User {{ $message }}
</h1>

<p>Login User 

	{{ link_to(route('sessions.create'), "here", $attributes = array(), $secure = null) }}

	<p>