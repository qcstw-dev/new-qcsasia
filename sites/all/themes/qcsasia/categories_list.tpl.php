<?php
print "<ul>";
foreach ($aCategories as $oCategory) {
    print '<li><a href="' . url(entity_uri('taxonomy_term', $oCategory)['path']) . '" title="' . $oCategory->name . '">' . $oCategory->name . '</a></li>';
}
print "</ul>";
