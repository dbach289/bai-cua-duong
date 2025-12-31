# add_vhost.ps1
# Chạy với PowerShell Run as Administrator
# Nội dung:

$hosts = 'C:\Windows\System32\drivers\etc\hosts'
$vhostsPath = 'C:\xampp\apache\conf\extra\httpd-vhosts.conf'
$httpdConf = 'C:\xampp\apache\conf\httpd.conf'
$docRoot = 'C:/xampp/htdocs/labs/lab01'
$serverName = 'DUONG.local'

Write-Output "Starting add_vhost.ps1 (needs Admin privileges)..."

# 1) Thêm hosts entry nếu chưa có
if (-not (Select-String -Path $hosts -Pattern ([regex]::Escape($serverName)) -Quiet)) {
    Add-Content -Path $hosts -Value ("`n127.0.0.1`t" + $serverName)
    Write-Output "Added hosts entry: 127.0.0.1 $serverName"
} else {
    Write-Output "Hosts already contains $serverName"
}

# 2) Đảm bảo httpd-vhosts.conf được include trong httpd.conf 
if (Test-Path $httpdConf) {
    $httpdText = Get-Content -Path $httpdConf -Raw
    if ($httpdText -match '^\s*#\s*Include\s+conf/extra/httpd-vhosts.conf') {
        $httpdText = $httpdText -replace '^\s*#\s*Include\s+conf/extra/httpd-vhosts.conf','Include conf/extra/httpd-vhosts.conf'
        Set-Content -Path $httpdConf -Value $httpdText -Force
        Write-Output "Uncommented Include conf/extra/httpd-vhosts.conf in httpd.conf"
    } else {
        Write-Output "httpd.conf already includes vhosts (or not commented)"
    }
} else {
    Write-Output "httpd.conf not found at $httpdConf"
}

# 3) Thêm VirtualHost block nếu chưa tồn tại
$vhostBlock = @"
<VirtualHost *:80>
    ServerName $serverName
    DocumentRoot "$docRoot"
    <Directory "$docRoot">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog "logs/$serverName-error.log"
    CustomLog "logs/$serverName-access.log" common
</VirtualHost>
"@

if (-not (Test-Path $vhostsPath)) {
    New-Item -Path $vhostsPath -ItemType File -Force | Out-Null
    Set-Content -Path $vhostsPath -Value $vhostBlock -Force
    Write-Output "Created vhosts file and wrote VirtualHost for $serverName"
} else {
    $vtext = Get-Content -Path $vhostsPath -Raw
    if ($vtext -match [regex]::Escape("ServerName $serverName")) {
        Write-Output "VirtualHost for $serverName already exists in $vhostsPath"
    } else {
        Add-Content -Path $vhostsPath -Value ("`n" + $vhostBlock)
        Write-Output "Appended VirtualHost block for $serverName to $vhostsPath"
    }
}

# 4) Restart Apache
$httpdExe = 'C:\xampp\apache\bin\httpd.exe'
if (Test-Path $httpdExe) {
    Write-Output "Restarting Apache via httpd.exe..."
    & $httpdExe -k restart
    Write-Output "Called httpd.exe -k restart"
} else {
    Write-Output "httpd.exe not found at $httpdExe; attempting service restart"
    try {
        net stop Apache2.4
        net start Apache2.4
        Write-Output "Restarted Apache service Apache2.4"
    } catch {
        Write-Output "Could not restart Apache service automatically. Please restart Apache from XAMPP Control Panel."
    }
}

# 5) Flush DNS
Write-Output "Flushing DNS cache..."
ipconfig /flushdns | Out-Null
Write-Output "Flushed DNS cache"

# 6) Verification (ping)
Write-Output "Ping result for ${serverName}:"
ping $serverName

Write-Output ("Done. Please open http://{0}/ and http://{0}/vhost_test.php to verify." -f $serverName)


