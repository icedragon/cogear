<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$cogear->get('site.lang','en');?>">
<head>
        <?=theme('head')?>
    </head>
    <body>
        <?=theme('before')?>
        <div class="container_16" id="body">
            <div class="grid_16" id="header">
                <?=theme('header')?>
            </div>
            <div class="grid_3" id="sidebar">
                <?=theme('sidebar')?>
            </div>
            <div class="grid_13" id="content">
                <?=theme('content')?> 
            </div>
            <div class="grid_16" id="footer"><?=theme('footer')?></div>
        </div>
        <?=theme('after')?>
    </body>
</html>