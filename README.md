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
+ install extension
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
    + content->block
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