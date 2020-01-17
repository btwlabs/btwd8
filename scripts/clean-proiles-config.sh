#!/usr/bin/env bash
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
find $SCRIPT_DIR/../profiles/brochure/config/install/ -type f -exec sed -i '' '/^uuid: /d' {} \;
find $SCRIPT_DIR/../profiles/brochure/config/install/ -type f -exec sed -i '' '/^_core:/{N;d;}' {} \;
