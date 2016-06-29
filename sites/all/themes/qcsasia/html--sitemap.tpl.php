<?php header('Content-Type: text/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <url>
        <loc><![CDATA[https://www.qcsasia.com]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/promotional-products/]]></loc> 
    </url><?php
    $aSingleValueQuery = ['patented', 'new', 'rush', 'cheap'];
    foreach (retrieveByTermName('category') as $aCategory) { 
        if (!taxonomy_get_parents($aCategory->tid)) {
            unset($aQuery['query']['category']);
            $sCatRef = $aCategory->field_reference['und'][0]['value'];
            $aQuery['query']['category'] = $sCatRef; 
            DisplaySearchUrl($aQuery);
            foreach (retrieveByTermName('function') as $aFunction) { 
                $aQuery['query']['function'] = $aFunction->field_reference['und'][0]['value']; 
                DisplaySearchUrl($aQuery);
            } 
            unset($aQuery['query']['function']);
            
            foreach (retrieveByTermName('logo_process') as $aLogoProcess) { 
                $aQuery['query']['logo-process'] = $aLogoProcess->field_reference['und'][0]['value']; 
                DisplaySearchUrl($aQuery);
            } 
            unset($aQuery['query']['logo-process']);
            
            foreach ($aSingleValueQuery as $sValue) {
                $aQuery['query'][$sValue] = null;
                DisplaySearchUrl($aQuery);
                unset($aQuery['query'][$sValue]);
            }
        }
    } 
    unset($aQuery['query']['category']);
    
    foreach (retrieveByTermName('function') as $aFunction) {
        $aQuery['query']['function'] = $aFunction->field_reference['und'][0]['value']; 
        DisplaySearchUrl($aQuery);
        foreach (retrieveByTermName('logo_process') as $aLogoProcess) { 
            $aQuery['query']['logo-process'] = $aLogoProcess->field_reference['und'][0]['value']; 
            DisplaySearchUrl($aQuery);
        } 
        unset($aQuery['query']['logo-process']);
            
        foreach ($aSingleValueQuery as $sValue) {
            $aQuery['query'][$sValue] = null;
            DisplaySearchUrl($aQuery);
            unset($aQuery['query'][$sValue]);
        }
    }
    unset($aQuery['query']['function']);
    
    foreach (retrieveByTermName('logo_process') as $aLogoProcess) { 
        $aQuery['query']['logo-process'] = $aLogoProcess->field_reference['und'][0]['value']; 
        DisplaySearchUrl($aQuery);
        foreach ($aSingleValueQuery as $sValue) {
            $aQuery['query'][$sValue] = null;
            DisplaySearchUrl($aQuery);
            unset($aQuery['query'][$sValue]);
        }
    } ?>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/promotional-products/?document_center]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/gift-and-souvenirs]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/layout-maker]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/catalog-and-tools]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/samples-and-prototypes]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/catalog-2016]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/toolkit]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/newsletters]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/member-area]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/about-us]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/factory-tour]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/guidelines]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/logo-processes]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/stamping-and-blind-stamping]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/photo-etching]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/zamac-injection]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/soft-enamel]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/hard-enamel]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/2d-soft-pvc]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/3d-soft-pvc]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/laser-engraving]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/silk-screen-printing]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/doming]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/offset-printing]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/offset-printing-label]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/bar-code-printing]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/colors-and-finishes-metal]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/supplier-program]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/career]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/term-conditions]]></loc> 
    </url>
    <url>
        <loc><![CDATA[https://www.qcsasia.com/contact-us]]></loc> 
    </url><?php
    
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product');

    $aResults = $oQuery->execute()['taxonomy_term'];

    foreach ($aResults as $oResult) {
        echo '
            <url>
                <loc><![CDATA[https://www.qcsasia.com'.url('taxonomy/term/'.$oResult->tid).']]></loc>
            </url>';
    }
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'theme');

    $aResults = $oQuery->execute()['taxonomy_term'];

    foreach ($aResults as $oResult) {
        echo '
            <url>
                <loc><![CDATA[https://www.qcsasia.com'.url('taxonomy/term/'.$oResult->tid).']]></loc>
            </url>';
    } ?>
</urlset>
<?php 
function DisplaySearchUrl ($aQuery) { ?>

<url>
    <loc><![CDATA[https://www.qcsasia.com<?= url('node/13', $aQuery); ?>]]></loc> 
</url>
    <?php
}