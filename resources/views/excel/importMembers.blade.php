<!DOCTYPE html>
<html>
<head>
	<title>Import Members</title>
</head>
<body>
	<form action="postImport" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="file" name="members">
		<input type="submit" name="Import"></input>
	</form>
</body>
<a href="{{URL::to('/dashboard')}}">Back</a>
</html>