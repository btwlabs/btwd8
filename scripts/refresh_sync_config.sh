#!/bin/bash
# Script to copy changed configs from the profile install folder to the sync folder.

git checkout master --quiet

SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"

cd "$SCRIPT_DIR" || exit;
cd .. || exit;
cd .. || exit;

read -p 'What profile dir will you copy to? [default is veneld8]' PROFILE_DIR
PROFILE_DIR=${PROFILE_DIR:-veneld8}

read -p "How many commits do we need to deploy config against? [default is 1]" COMMITS
COMMITS=${COMMITS:-1}

FILE_LIST=$(find docroot/profiles/"$PROFILE_DIR"/config/install | xargs git diff --name-only HEAD HEAD~"$COMMITS")
for i in $FILE_LIST; do
  cp "$i" docroot/profiles/"$PROFILE_DIR"/config/sync-multisites
done

echo "...done"
