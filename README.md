+ uplaod code
+ copy media
    + follow
    + poweruser
    + refund-exchange
    + sales
    + wysiwyg
+ rebuild
+ disable DebugHelper Shopial_Facebook
+ change theme to Peanut: content->configuration
+ install extension:  
    + mageplaza/magento-2-social-login
    + mageplaza/module-smtp
    + mageplaza/magento-2-blog-extension
    + beeketing/magento-countdowncart
+ admin configurations:
    + Mageplaza Extensions
        + register
        + general -> disable topmenu
    + Customer
        + disable
+ cms
    + content->configuration->edit
        +Html Head
            + favicon icon: logo_1byone_small.png
            + Default Page Tile: 1byone
        + Header
            + logo image: logo.png
            + logo attribute width: 116
            + welcome text :
        + Footer
            + Copyright:Copyright © 2018 1byone, Inc. All rights reserved.
    + content
        + add New block
            + see cms blocks:name and id is filename ,and code is file content
        + add widget
            + type: cms static block
            + theme: peanut
            + title: 1BYONE-Home-Page
            + All-store-view
            + SepcifiedPage/CmsHomePage/MainContentArea
            + select block 1BYONE-Home-Page
        + add pages
            + campaign:insert widget- block:1BYONE-campaign, layout update:1 column + see cms pages
            + blog:insert widget- block:1BYONE-blog, layout update:1 column + see cms pages
            + products:insert widget Product List 2 columns with left bar
            + testimony:insert widget- block:1BYONE-testimony, layout update:1 column
        + edit pages
            + Home Page -> Design ->  Layout Update XML -> see cms page--Home Page
            
+ cron jobs
    <pre><code>
    * * * * * /usr/bin/php /var/www/html/bin/magento cron:run | grep -v "Ran jobs by schedule" >> /var/www/html/var/log/magento.cron.log
    * * * * * /usr/bin/php /var/www/html/update/cron.php >> /var/www/html/var/log/update.cron.log
    * * * * * /usr/bin/php /var/www/html/bin/magento setup:cron:run >> /var/www/html/var/log/setup.cron.log
    </code></pre>
+ store -> attributes -> products -> add attributes
    + Amazon ASIN,Text,amazon_asin,use in search
    + Amazon url, Text,amazon_url,
    + discount,Text,discount,Used for Sorting in Product Listing
    + Suggested,Text,suggested,Used for Sorting in Product Listing
    + Mark,Text,mark,in Product Listing
    + Product FAQ, Text area, product_faq
    + Download Files,Text area, download_files
    