#!/usr/bin/env bash

find ../profiles/brochure/config/install/ -type f -exec sed -i '' '/^uuid: /d' {} \;
find ../profiles/brochure/config/install/ -type f -exec sed -i '' '/_core:/{N;d;}' {} \;
