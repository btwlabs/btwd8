#!/usr/bin/env bash
rsync -avz /Users/tbenice/PhpstormProjects/canonical-test/sites/default/config/ /Users/tbenice/PhpstormProjects/btwd8/profiles/brochure/config/install/
cd /Users/tbenice/PhpstormProjects/btwd8
sh scripts/clean-proiles-config.sh
rm -rf profiles/brochure/config/install/.*.DS_Store
rm -rf profiles/brochure/config/install/core.extension.yml
git checkout profiles/brochure/config/install/mandrill.settings.yml
git checkout profiles/brochure/config/install/system.site.yml
git checkout profiles/brochure/config/install/update.settings.yml
git checkout profiles/brochure/config/install/views.settings.yml
git status
## NOTE LINES ~117-118 of core.entity_view_display.paragraph.gallery.default.yml get overwritten by the cleaning script.
## Be sure to reset those removals.
