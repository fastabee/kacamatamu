$file = 'c:\laragon\www\88foundation\app\Views\inc\head.php'
$c = [IO.File]::ReadAllText($file)
$c = $c.Replace("session('username')", "session('nama')")
[IO.File]::WriteAllText($file, $c)
Write-Host "done: $($Matches.Count) replacements"
