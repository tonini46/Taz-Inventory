<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="{{ url('public/css/bootstrap.min.css') }}">
    </head>
    <body>
        <h2>Your password was reseted !</h2>
        <h3>Please login with follows credentials:</h3>

		<table class="table">
			<tr>
				<td>User:</td>
				<td>{{ $user }}</td>
			</tr>
			
			<tr>
				<td>Password:</td>
				<td>{{ $password }}</td>
			</tr>			
		</table>

    </body>
</html>