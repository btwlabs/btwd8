#!/bin/bash
# Script to quickly create sub-theme.

echo '
+-----------------------------------------------------------------------------+
| With this script you could quickly create btw_base sub-theme           |
| In order to use this:                                                       |
| - btw_base theme (this folder) should be in the themes/custom folder   |
+-----------------------------------------------------------------------------+
'
echo 'The machine name of your custom theme? [e.g. mycustom_theme]'
read SUB_THEME

echo 'Your theme name ? [e.g. My Custom Theme]'
read SUB_THEME_NAME

SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"

cd "$SCRIPT_DIR" || exit;
cd ../.. || exit;

cp -r btw_base "$SUB_THEME"
cd "$SUB_THEME" || exit;
for file in *btw_base.*; do mv "$file" "${file//btw_base/$SUB_THEME}"; done
grep -Rl btw_base .|xargs sed -i '' -e "s/btw_base/$SUB_THEME/"
LC_ALL=C sed -i '' -e "s/BTW Base/$SUB_THEME_NAME/" "$SUB_THEME.info.yml"

echo "If you are using a Mac the illegal byte error is shown, but it is harmless. In GNU the error occurs but it is not reported."
echo "# Check the themes/custom folder for your new sub-theme."
d
