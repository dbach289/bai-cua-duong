<?php
// demo_http_obs.php
// Server-side helper: dùng get_headers() để lặp qua một số URL trong project

$basePath = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
$host = $_SERVER['HTTP_HOST'];
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$targets = [
	"$scheme://$host$basePath/site/home.html",
	"$scheme://$host$basePath/site/about.html",
	"$scheme://$host$basePath/site/contact.html",
	"$scheme://$host$basePath/register.php",
];

function safe_get_headers($url) {
	$headers = @get_headers($url, 1);
	if ($headers === false) return null;
	return $headers;
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<title>Demo HTTP Observations</title>
	<style> body{font-family:Arial,Helvetica,sans-serif;margin:12px;} pre{background:#f5f5f5;padding:8px;border-radius:4px;} </style>
</head>
<body>
	<h1>Demo HTTP observations (server-side)</h1>
	<p>Base URL detected: <strong><?php echo htmlspecialchars("$scheme://$host$basePath"); ?></strong></p>
	<?php foreach ($targets as $t): ?>
		<?php
		$h = safe_get_headers($t);
		?>
		<section>
			<h2><?php echo htmlspecialchars($t); ?></h2>
			<?php if ($h === null): ?>
				<p style="color:red">Không lấy được headers (kiểm tra Apache/đường dẫn).</p>
			<?php else: ?>
				<pre>
Method: GET
<?php
$statusLine = is_array($h) ? reset($h) : $h;
// status line thường là dạng "HTTP/1.1 200 OK"
preg_match('/\s(\d{3})\s/', $statusLine, $m);
$code = $m[1] ?? 'N/A';
echo "Status: " . $code . "\n\n";

// Hiển thị 2 header tiêu biểu nếu có
$show = [];
if (isset($h['Content-Type'])) $show['Content-Type'] = $h['Content-Type'];
if (isset($h['Server'])) $show['Server'] = $h['Server'];
if (isset($h['Content-Length'])) $show['Content-Length'] = $h['Content-Length'];
if (empty($show) && is_array($h)) {
	// lấy 2 header đầu tiên (bỏ phần status)
	$keys = array_keys($h);
	for ($i=1;$i<count($keys) && count($show)<2;$i++) {
		$key = $keys[$i];
		$show[$key] = $h[$key];
	}
}
foreach ($show as $k=>$v) {
	if (is_array($v)) $v = implode(', ', $v);
	echo $k . ': ' . $v . "\n";
}
?>
				</pre>
			<?php endif; ?>
		</section>
	<?php endforeach; ?>

	<p><a href="lab01.php">Về mục lục lab01</a></p>
</body>
</html>


