; <?php This is a sample configuration file
; comments start with ';', as in php.ini

[Database]
DBhost = "localhost"
DBport = 3306
DBuser = "root"
DBpass = ""
DBname = "wpp"

[Search options]
rowsPerPage = 20

[Upload settings]
; Allows *.pkt file upload. Disabled by default.
allowPkt = 0

; Relative path to *.pkt files uploaded
pktStoragePath = "./pktUploads"

; Dont ask
unused = "3899dcbab79f92af727c2190bbd8abc5"

[Safety]
passwordProtection = 1 ; Enable password protection - Enabled by default

[Tooltips]
enableTooltips = 1 ; Enable tooltips
tooltipJs = "http://wow.zamimg.com/widgets/power.js" ; URL pointing to javascript file
tooltipRedirectionUrl = "https://www.wowhead.com"; URL pointing to tooltip host
