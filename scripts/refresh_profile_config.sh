#!/bin/bash
# Script to copy configs from a site sync folder to a profile.

echo '
+-----------------------------------------------------------------------------------------+
| Use this script to refresh config in a profile using config in a site config directory. |
+------------------------------------------------------------------------------------------+
'

# Copy and strip stamps from config files.
read -p 'What is the FRESH INSTALL BASED site to copy from? [default is, well, default]' SOURCE_SITE
SOURCE_SITE=${SOURCE_SITE:-default}
read -p 'What profile dir will you copy to? [default is brochure]' PROFILE_DIR
PROFILE_DIR=${PROFILE_DIR:-brochure}

SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"

cd "$SCRIPT_DIR" || exit;

if [[ ! -e ../sites/$SOURCE_SITE/config ]]; then
    echo "No such site config directory: $SOURCE_SITE/config, assuming 'default'"
    SOURCE_SITE='default'
fi

if [[ ! -e ../profiles/$PROFILE_DIR ]]; then
    echo "No such profile directory: $PROFILE_DIR, assuming 'brochure'"
    PROFILE_DIR='brochure'
fi

export PROFILE_DIR

if [[ ! -e ../profiles/$PROFILE_DIR/config/install ]]; then
  if [[ ! -e ../profiles/$PROFILE_DIR/config/ ]]; then
    mkdir ../profiles/"$PROFILE_DIR"/config
  fi
  mkdir ../profiles/"$PROFILE_DIR"/config/install
fi

if [ -z "$(ls -A ../sites/"$SOURCE_SITE"/config/*.yml)" ]; then
   echo "The source site config is empty!"
   exit
fi

echo "Now copying config from ${SOURCE_SITE} to ${PROFILE_DIR}..."

rm -rf ../profiles/"$PROFILE_DIR"/config/install/*

cp ../sites/"$SOURCE_SITE"/config/* ../profiles/"$PROFILE_DIR"/config/install

find ../profiles/"$PROFILE_DIR"/config/install -type f -exec sed -i '' '/^uuid: /d' {} \;
find ../profiles/"$PROFILE_DIR"/config/install -type f -exec sed -i '' '/^_core:/{N;d;}' {} \;


# Copy the extensions over from core.extensions.yml to the profile info file then delete it.
echo "Now moving extensions from core.extension.yml to ${PROFILE_DIR}.info.yml..."

cd ../profiles/"$PROFILE_DIR" || exit;

EXTENSIONS="$(sed -n '/module:/,/profile:/p' ./config/install/core.extension.yml)"
export EXTENSIONS
rm -rf ./config/install/core.extension.yml

rm -rf __${PROFILE_DIR}.copy.yml
cp "${PROFILE_DIR}".info.yml __"${PROFILE_DIR}".copy.yml
rm -rf "${PROFILE_DIR}".info.yml

( echo "cat << EOF > temp2.yml";
  cat "$SCRIPT_DIR"/profile.tpl.yml;
  echo "EOF";
) > temp.yml
. temp.yml

sed "\$d;s/: [0-9]*\$/ /;/${PROFILE_DIR}:/d;s/  / - /;/module:/d;s/theme/themes/g;" temp2.yml > "${PROFILE_DIR}".info.yml

rm -rf temp.yml
rm -rf temp2.yml

echo "Now removing metatag display extender from views settings (breaks install)..."
sed "s/display_extenders://;s/  - metatag_display_extender//;/^$/d" ./config/install/views.settings.yml > temp.yml
mv temp.yml ./config/install/views.settings.yml
rm -rf temp.yml

# END

