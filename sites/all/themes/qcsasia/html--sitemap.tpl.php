<?php 
header('Content-Type: text/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <url>
        <loc>https://www.qcsasia.com</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/?category[]=plastic-injection</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/?category[]=metal-enamel</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/?category[]=aluminium</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/?category[]=soft-pvc-cloisonne</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/promotional-products/?document_center</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/gift-and-souvenirs</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/layout-maker</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/catalog-and-tools</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/samples-and-prototypes</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/catalog-2016</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/toolkit</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/newsletters</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/member-area</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/about-us</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/factory-tour</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/guidelines</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/logo-processes</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/stamping-and-blind-stamping</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/photo-etching</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/zamac-injection</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/soft-enamel</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/hard-enamel</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/2d-soft-pvc</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/3d-soft-pvc</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/laser-engraving</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/silk-screen-printing</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/doming</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/offset-printing</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/offset-printing-label</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/bar-code-printing</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/colors-and-finishes-metal</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/supplier-program</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/career</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/term-conditions</loc> 
    </url>
    <url>
        <loc>https://www.qcsasia.com/contact-us</loc> 
    </url><?php
    
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product');

    $aResults = $oQuery->execute()['taxonomy_term'];

    foreach ($aResults as $oResult) {
        echo '
            <url>
                <loc>https://www.qcsasia.com'.url('taxonomy/term/'.$oResult->tid).'</loc>
            </url>';
    } ?>
</urlset>