# Path Corrections Summary

## Files with corrected paths (../ added)

### Page files (in /page directory)
1. affiliate_dashboard.php
2. setup_2fa.php
3. notification_settings.php
4. apply_coupon.php

### System files (in /system directory)
1. setup_2fa.php
2. disable_2fa.php
3. apply_coupon.php
4. save_notification_settings.php
5. line_connect.php
6. disconnect_line.php

## Pattern of correction

Changed from:
```
require_once 'system/a_func.php';
```

To:
```
require_once '../system/a_func.php';
```

And similarly for other system files:
```
require_once '2fa.php'; → require_once '../system/2fa.php';
require_once 'coupon.php'; → require_once '../system/coupon.php';
```

## Reason for correction

The page files are located in the /page directory, while the system files they depend on are in the /system directory. The previous relative paths were incorrect, causing "Failed to open stream" errors.

## Verification

After these corrections, the pages should load correctly without path-related errors. All AJAX calls from the frontend to the system files should also work properly since those system files now correctly reference the a_func.php file.