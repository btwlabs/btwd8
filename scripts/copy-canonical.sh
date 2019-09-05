#!/usr/bin/env bash
rsync -avz /Users/tbenice/PhpstormProjects/canonical-test/sites/default/config/ /Users/tbenice/PhpstormProjects/d8upstream/profiles/brochure/config/install/
cd /Users/tbenice/PhpstormProjects/d8upstream
sh scripts/clean-proiles-config.sh
rm -rf profiles/brochure/config/install/.*.DS_Store
rm -rf profiles/brochure/config/install/core.extension.yml
git checkout profiles/brochure/config/install/mandrill.settings.yml
git checkout profiles/brochure/config/install/system.site.yml
git checkout profiles/brochure/config/install/update.settings.yml
git checkout profiles/brochure/config/install/views.settings.yml
git status
